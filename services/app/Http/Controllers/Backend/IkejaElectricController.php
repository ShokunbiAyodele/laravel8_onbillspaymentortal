<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Http;
use Auth;
use App\Models\User;
use App\Models\AllPaymentHistory;
use App\Models\IkejaPrepaid;
use App\Models\IkejaPostpaid;
use Carbon\Carbon;
use PDF;
use DB;


class IkejaElectricController extends Controller
{
    
    public function ikejaElectricView(){
        return view('backend.electricity.ikeja_prepaid.ikeja_prepaid_view');
    }


    public function ikejaElectricBuyToken(Request $request){
        $user_id = Auth::user()->id;
        $meterNumber = $request->meterNumber;
        $amount = $request->amount;
        $mobileNumber = $request->phone;
       

        // $data = array(
        //     'meterNumber' => $meterNumber,
        //     'amount'  => $amount,
        //     'phone' => $mobileNumber,
        // );
        // dd($data);

          //insert a phone in users table
          $phone = User::where('id',$user_id)->first()['phone'];
          if($phone == null){
              User:: where('id',$user_id)->update(['phone' => $mobileNumber]);
          }

          $response = Http::withHeaders([
            'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
            'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        ])->post('http://132.145.231.191/vasb2b/dev/Api/proxy',[
            'details' => ['meterNumber' => $meterNumber,
        ],
            'serviceId' => 'APB'
        ]);

        if($response->status() == 200){
            $name = $response['details']['name'];
            $address = $response['details']['address'];
            $meterNumber = $response['details']['meterNumber'];
            $customerDtNumber = $response['details']['customerDtNumber'];
            $customerAccountType = $response['details']['customerAccountType'];

               //call a payment gateway API for an authorization code 
               $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

               $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');

                if($response->status() == 200){
                    //get user email address  and name
                    $userEmailAddress = User::where('id', $user_id)->first()['email'];

                    //get the authorozation code on the header
                    $code = $response->header('Authorization-Code');

             //get a request id for the transaction
             $requestId =(string)(rand(10000, 99999));
             //create a hash
             $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$userEmailAddress"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/ikeja_prepaid/make/payment");

              //call a create payment Api
              $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
                'amount'        => $amount,
                'custName'      => $name,
                'custEmail'     => $userEmailAddress,
                'currency'      => 'NGN',
                'phoneNumber'   =>   $mobileNumber,
                'callbackUrl'   =>  'http://localhost/Ebill/services/public/ikeja_prepaid/make/payment',
                'hash'          =>  $TRANSACTION_HASH,
                'requestId'     =>  $requestId,
                'narration'     =>  'Payment for Ikeja Electric prepaid',]);

             if($response->status() == 200){
                $paymentUrl = $response->header('Payment-Url');
                //insert customer details into prepaid table
                $data = new IkejaPrepaid();
                $data->name = $name;
                $data->address =  $address;
                $data->meterNumber = $meterNumber;
                $data->email = $userEmailAddress;
                $data->phone = $mobileNumber;
                $data->customerDtNumber = $customerDtNumber;
                $data->customerAccountType = $customerAccountType;
                $data->amount = $amount;
                $data->requestId = $requestId;
                $data->user_id   = $user_id;
                $data->save();
                return Redirect::to($paymentUrl);
   
                }

            }
        }
        else{
            $notification = array(
                'message'  => 'Wrong input details',
                'alert-type'  => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function ikejaPrepaidPayment(){
        $requestId =$_GET['requestId'];
        $user_id = IkejaPrepaid::where('requestId',$requestId)->first()['user_id'];

        // $requestId =IkejaPrepaid::where('user_id',$user_id)->orderBy('id','desc')->first()['requestId'];

        //get a merchant hash for authorization code
     $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

     //calling authorization API to get an authorization code for billers
     $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');
     $code = $response->header('Authorization-Code');

    //get the parameters and save to database and share token value with the user

    //calling validate payment API
     $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/payment/validate', ['requestId' => $requestId,]);

    
             
        if($response->status() == 200){
            $data = array();
            $data['message']  = $response['message'];
            $data['status']  = $response['data']['status'];
            $data['transactionReference']  = $response['data']['transactionReference'];
            $data['transactionDate']  = $response['data']['transactionDate'];

            DB::table('ikeja_prepaids')->where('requestId',$requestId)->update($data);

            if($response['data']['status'] == "Failed"){
                $notification = array(
                    'message'    => 'Your Payment was not successfull',
                    'alert-type' => 'error'
                );
                return redirect()->route('dashboard')->with( $notification);
            }
            if($response['data']['status'] == 'Success'){


                    //generate a request id for exchange
                    $request_id = (rand(1000, 9999));

                    $data = IkejaPrepaid::where('user_id',$user_id)->orderBy('id','desc')->first();
                    $name = $data->name;
                    $phoneNumber = $data->phone;
                    $meterNumber = $data->meterNumber;
                    $customerDtNumber = $data->customerDtNumber;
                    $customerAccountType = $data->customerAccountType;
                    $email = $data->email;
                    $address = $data->address;
                    $amount = $data->amount;
    
            $response = Http::withHeaders([
                'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
                'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
            ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
                'details' => [
                'customerName'      => $name,
                'meterNumber'      => $meterNumber,
                'customerAddress'      => $address,
                'phoneNumber'  =>    $phoneNumber,
                'customerAccountType'  => $customerAccountType,
                'customerDtNumber'       =>  $customerDtNumber,
                'contactType'       => 'TENANT',
                'email'       =>      $email,
                'amount'           =>  $amount
               ],
                'id'                 => $request_id,
                'paymentCollectorId' => "CDL",
                'paymentMethod'      => 'PREPAID',
                'serviceId'          => 'APB'
            ]);
         
            $id =IkejaPrepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
            //insert Biller Request Id here to prepaid table
            if($id == null){
                DB::table('ikeja_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
            }
           if($response->status()== 200){

            $billerId = IkejaPrepaid::where('requestId',$requestId)->first()['billerRequestId'];
            if($response['details']['status']== 'PENDING'){
                $id =IkejaPrepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
                //insert Biller Request Id here to prepaid table
                if($id == null){
                    DB::table('ikeja_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
                }
                //insert to pending_transaction table
                DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'phone'=> $phoneNumber, 'meterNumber'=>$meterNumber,'user_id' => $user_id]);
                $data = array();
                $data['status'] = $response['details']['status'];
                $data['requestId'] = $request_id;
                $data['amount'] = $amount;
                $data['meterNumber'] = $meterNumber;
                $data['email'] = $email;
                $data['date'] =Carbon::now();
                $data['customerName'] =$customerName;
                $data['user_id'] = $user_id;
                $data['transactionNumber'] = $response['transactionNumber'];
                DB::table('all_payment_histories')->insert($data);
                $notification = array(
                    'message'  => 'Your Transaction has been processing',
                    'alert-type'  => 'success'
                );
                return redirect()->route('dashboard')->with($notification);
                

            }
            elseif($response['details']['status']== 'ACCEPTED'){
                $id =IkejaPrepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
                //insert Biller Request Id here to prepaid table
                if($id == null){
                    DB::table('ikeja_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
                }
                    $data = array();
                    $data['transactionNumber'] = $response['transactionNumber'];
                    $data['amount'] = $amount;
                    $data['meterNumber'] = $meterNumber;
                    $data['exchangeReference']  =  $response['details']['exchangeReference'];
                    $data['creditToken']  = $response['details']['creditToken'];
                    $data['tokenAmount'] = $response['details']['tokenAmount'];
                    $data['status']  = $response['details']['status'];
                    $data['customerName']      =   $name;
                    $data['email'] = $email;
                    $data['date'] =Carbon::now();
                    $data['requestId']         =     $request_id;
                    $data['user_id']         =     $user_id;
                    $data = DB::table('all_payment_histories')->insert($data);
                    $selectIkejaPrepaid = AllPaymentHistory::where(['status' =>'ACCEPTED','user_id'=> $user_id])->orderBy('id','desc')->first();
                    return view('backend.electricity.ikeja_prepaid.ikejaPrepaid_acceptedTrans', compact('selectIkejaPrepaid'));

                $notification = array(
                    'message'  => 'your transaction was successfull',
                    'alert-type'  => 'success'
                );
                return redirect()->route('dashboard')->with($notification);
            }
            else{
                $notification = array(
                    'message'  => 'Transaction was rejected',
                    'alert-type'  => 'error'
                );
                return redirect()->route('dashboard')->with($notification);

            }
        }
      }
    }

    }

    public function ikejaPrepaidPDF(){
        $user_id = Auth::user()->id;
    $data['pdf_details'] =AllPaymentHistory::where('user_id', $user_id)->orderBy('id','desc')->first();
    $pdf = PDF::loadView('backend.electricity.ikeja_prepaid.ikejaprepaid_pdf',$data);
    $pdf->SetProtection(['copy', 'print'], '', 'pass');
    return $pdf->stream('document.pdf');
    }


    public function ikejaElectricPostpaidView(){
        return view('backend.electricity.ikeja_postpaid.ikeja_postpaid_view');

    }

    public function ikejaPostpaidBuy(Request $request){
        $user_id  = Auth::user()->id;
        $accountNumber = $request->accountNumber;
        $amount = $request->amount;
        $mobileNumber = $request->phone;
        //  $data = array(
        //     'accountNumber' => $accountNumber,
        //     'amount'  => $amount,
        //     'phone' => $mobileNumber,
        // );
        // dd($data);


            //insert a phone in users table
            $phone = User::where('id',$user_id)->first()['phone'];
            if($phone == null){
                User:: where('id',$user_id)->update(['phone' => $mobileNumber]);
            }

            $response = Http::withHeaders([
                'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
                'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
            ])->post('http://132.145.231.191/vasb2b/dev/Api/proxy',[
                'details' => ['customerNumber' =>  $accountNumber ],
                'serviceId' => 'APA'
            ]);

            if($response->status() == 200){
               
                $name = $response['details']['name'];
                $address = $response['details']['address'];
                $accountNumber = $response['details']['accountNumber'];
                $customerDtNumber = $response['details']['customerDtNumber'];
                $customerAccountType = $response['details']['customerAccountType'];
                // dd($response->json());

                 //call a payment gateway API for an authorization code 
               $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

               $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');
           

                if($response->status() == 200){

                        //get user email address  and name
                        $userEmailAddress = User::where('id', $user_id)->first()['email'];
    
                        //get the authorozation code on the header
                        $code = $response->header('Authorization-Code');


                             //get a request id for the transaction
             $requestId =(string)(rand(10000, 99999));
             //create a hash
             $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$userEmailAddress"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/ikeja_postpaid/make/payment");


                 //call a create payment Api
                 $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
                    'amount'        => $amount,
                    'custName'      => $name,
                    'custEmail'     => $userEmailAddress,
                    'currency'      => 'NGN',
                    'phoneNumber'   =>   $mobileNumber,
                    'callbackUrl'   =>  'http://localhost/Ebill/services/public/ikeja_postpaid/make/payment',
                    'hash'          =>  $TRANSACTION_HASH,
                    'requestId'     =>  $requestId,
                    'narration'     =>  'Payment for Ikeja Electric postpaid',]);

                    if($response->status() == 200){
                        $paymentUrl = $response->header('Payment-Url');
                        //insert customer details into prepaid table
                        $data = new IkejaPostpaid();
                        $data->name = $name;
                        $data->address =  $address;
                        $data->customerAccount = $accountNumber;
                        $data->email = $userEmailAddress;
                        $data->phone = $mobileNumber;
                        $data->customerDtNumber = $customerDtNumber;
                        $data->customerAccountType = $customerAccountType;
                        $data->amount = $amount;
                        $data->requestId = $requestId;
                        $data->user_id   = $user_id;
                        $data->save();
                        return Redirect::to($paymentUrl);
           
                        }

                }

            }
            else{
                $notification = array(
                    'message'  => 'Wrong input details',
                    'alert-type'  => 'error'
                );
                return redirect()->back()->with($notification);
            }

    }

    public function ikejaPostpaidPayment(){
        $requestId =$_GET['requestId'];
        $user_id = IkejaPostpaid::where('requestId',$requestId)->first()['user_id'];

        // $requestId =IkejaPostpaid::where('user_id',$user_id)->orderBy('id','desc')->first()['requestId'];
        
     //get a merchant hash for authorization code
     $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

     //calling authorization API to get an authorization code for billers
     $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');
     $code = $response->header('Authorization-Code');

    //get the parameters and save to database and share token value with the user

    //calling validate payment API
     $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/payment/validate', ['requestId' => $requestId,]);

    
             
        if($response->status() == 200){
            $data = array();
            $data['message']  = $response['message'];
            $data['status']  = $response['data']['status'];
            $data['transactionReference']  = $response['data']['transactionReference'];
            $data['transactionDate']  = $response['data']['transactionDate'];

            DB::table('ikeja_postpaids')->where('requestId',$requestId)->update($data);

            if($response['data']['status'] == "Failed"){
                $notification = array(
                    'message'    => 'Your Payment was not successfull',
                    'alert-type' => 'error'
                );
                return redirect()->route('dashboard')->with( $notification);
            }
            if($response['data']['status'] == 'Success'){
                    //generate a request id for exchange
                    $request_id = (rand(1000, 9999));

                    $data = IkejaPostPaid::where('user_id',$user_id)->orderBy('id','desc')->first();
                    $name = $data->name;
                    $phoneNumber = $data->phone;
                    $customerAccount = $data->customerAccount;
                    $customerDtNumber = $data->customerDtNumber;
                    $phoneNumber = $data->phone;
                    $customerAccountType = $data->customerAccountType;
                    $email = $data->email;
                    $address = $data->address;
                    $amount = $data->amount;
    
            $response = Http::withHeaders([
                'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
                'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
            ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
                'details' => [
                'customerName'      => $name,
                'accountNumber'      => $customerAccount,
                'customerAddress'      => $address,
                'phoneNumber'  =>    $phoneNumber,
                'customerAccountType'  => $customerAccountType,
                'customerDtNumber'       => $customerDtNumber,
                'contactType'       => 'LANDLORD',
                'email'       =>      $email,
                'amount'           =>  $amount
               ],
                'id'                 => $request_id,
                'paymentCollectorId' => "CDL",
                'paymentMethod'      => 'POSTPAID',
                'serviceId'          => 'APA'
            ]);
           if($response->status()== 200){
            if($response['details']['status']== 'PENDING'){
                $id =IkejaPostpaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
                //insert Biller Request Id here to prepaid table
                if($id == null){
                    DB::table('ikeja_postpaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
                }
               
                 //insert to pending_transaction table
                 DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'phone'=> $phoneNumber, 'accountNumber'=>$ $customerAccount,'user_id' => $user_id]);
                 $data = array();
                 $data['status'] = $response['details']['status'];
                 $data['requestId'] = $request_id;
                 $data['customerName'] =$customerName;
                 $data['accountNumber'] = $customerAccount;
                 $data['user_id'] = $user_id;
                 $data['email'] = $email;
                 $data['date'] = Carbon::now();
                 $data['transactionNumber'] = $response['transactionNumber'];
                 DB::table('all_payment_histories')->insert($data);
                 $notification = array(
                     'message'  => 'Your Transaction has been processing',
                     'alert-type'  => 'success'
                 );
                 return redirect()->route('dashboard')->with($notification);
            }
            elseif($response['details']['status']== 'ACCEPTED'){
                $id =IkejaPostpaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
                //insert Biller Request Id here to prepaid table
                if($id == null){
                    DB::table('ikeja_postpaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
                }
                    $data = array();
                    $data['transactionNumber'] = $response['transactionNumber'];
                    $data['amount'] = $amount;
                    $data['customerName'] = $name;
                    $data['email'] = $email;
                    $data['accountNumber'] = $customerAccount;
                    $data['exchangeReference']  =  $response['details']['exchangeReference'];
                    $data['status']  = $response['details']['status'];
                    $data['requestId']         =     $request_id;
                    $data['user_id']         =     $user_id;
                    $data['date'] = Carbon::now();
                    $data = DB::table('all_payment_histories')->insert($data);
                    $selectIkejaPostPaid = AllPaymentHistory::where(['status' =>'ACCEPTED','user_id'=> $user_id])->orderBy('id','desc')->first();
                    return view('backend.electricity.ikeja_postpaid.ikejaPostpaid_acceptedTrans', compact('selectIkejaPostPaid'));

                $notification = array(
                    'message'  => 'your transaction was successfull',
                    'alert-type'  => 'success'
                );
                return redirect()->route('dashboard')->with($notification);
            }
            else{
                $notification = array(
                    'message'  => 'Transaction was rejected',
                    'alert-type'  => 'error'
                );
                return redirect()->route('dashboard')->with($notification);

            }
        }
      }
    }
    }

    public function ikejaPostPaidPDF(){
        $user_id = Auth::user()->id;
        $data['pdf_details'] =AllPaymentHistory::where('user_id', $user_id)->orderBy('id','desc')->first();
        $pdf = PDF::loadView('backend.electricity.ikeja_postpaid.ikejapostpaid_pdf',$data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');

    }
}
