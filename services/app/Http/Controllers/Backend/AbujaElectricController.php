<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\AbujaPrepaid;
use App\Models\AbujaPostPaid;
use App\Models\AllPaymentHistory;
use Redirect;
use Illuminate\Support\Facades\Http;
use DB;
use PDF;

class AbujaElectricController extends Controller
{
    public function abujaElectricView(){
        return view('backend.electricity.abuja_electric.abuja_electric_prepaid');
    }


    public function abujaElectricBuyToken(Request $request){
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
            'details' => ['customerReference' => $meterNumber,
            'customerReferenceType'  =>'STS_PREPAID'
        
        ],
            'serviceId' => 'BABA'
        ]);

        if($response->status() == 200 &  $response['details']['responseCode'] == true){
            $customerName = $response['details']['customerName'];
            $responseMessage = $response['details']['responseMessage'];
            $uniqueCode = $response['details']['uniqueCode'];

               //call a payment gateway API for an authorization code 
               $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

               $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');

                if($response->status() == 200){
                    //get user email address  and name
                    $userEmailAddress = User::where('id', $user_id)->first()['email'];
                    $customerName = User::where('id', $user_id)->first()['name'];

                    //get the authorozation code on the header
                    $code = $response->header('Authorization-Code');

             //get a request id for the transaction
             $requestId =(string)(rand(10000, 99999));
             //create a hash
             $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$userEmailAddress"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/abuja_prepaid/make/payment");

              //call a create payment Api
              $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
                'amount'        => $amount,
                'custName'      => $customerName,
                'custEmail'     => $userEmailAddress,
                'currency'      => 'NGN',
                'phoneNumber'   =>   $mobileNumber,
                'callbackUrl'   =>  'http://localhost/Ebill/services/public/abuja_prepaid/make/payment',
                'hash'          =>  $TRANSACTION_HASH,
                'requestId'     =>  $requestId,
                'narration'     =>  'Payment for Abuja Electric prepaid',]);

             if($response->status() == 200){
                $paymentUrl = $response->header('Payment-Url');
                //insert customer details into prepaid table
                $data = new AbujaPrepaid();
                $data->name = $customerName;
                $data->uniqueCode =  $uniqueCode;
                $data->customerReference = $meterNumber;
                $data->phone = $mobileNumber;
                $data->email = $userEmailAddress;
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


    public function  abujaPrepaidPayment(){
        $requestId =$_GET['requestId'];
        $user_id = AbujaPrepaid::where('requestId',$requestId)->first()['user_id'] ;

        // $requestId =AbujaPrepaid::where('user_id',$user_id)->orderBy('id','desc')->first()['requestId'];

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

            DB::table('abuja_prepaids')->where('requestId',$requestId)->update($data);

            if($response['data']['status'] == "Failed"){
                $notification = array(
                    'message'    => 'Your Payment was not successfull',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with( $notification);
            }
            if($response['data']['status'] == 'Success'){


                    //generate a request id for exchange
                    $request_id = (rand(1000, 9999));

                    $data = AbujaPrepaid::where('user_id',$user_id)->orderBy('id','desc')->first();
                    $meterNumber = $data->customerReference;
                    $uniqueCode = $data->uniqueCode;
                    $customerName = $data->name;
                    $email = $data->email;
                    $amount = $data->amount;
                    $phoneNumber = $data->phone;
                    $amount = $data->amount;
    
            $response = Http::withHeaders([
                'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
                'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
            ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
                'details' => [
                'customerReference'      => $meterNumber,
                'customerReferenceType'  => 'STS_PREPAID',
                'uniqueCode'       => $uniqueCode,
                'amount'           =>  $amount
               ],
                'id'                 => $request_id,
                'paymentCollectorId' => "CDL",
                'paymentMethod'      => 'PREPAID',
                'serviceId'          => 'BABA'
            ]);
         
           if($response->status()== 200){
            $billerId = AbujaPrepaid::where('requestId',$requestId)->first()['billerRequestId'];
            if($response['details']['status']== 'PENDING'){

                $id =AbujaPrepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
                //insert Biller Request Id here to prepaid table
                if($id == null){
                    DB::table('abuja_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
                }
                
                //insert to pending_transaction table
                DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'phone'=> $phoneNumber, 'meterNumber'=>$meterNumber,'user_id' => $user_id]);
                $data = array();
                $data['status'] = $response['details']['status'];
                $data['requestId'] = $request_id;
                $data['customerName'] =$customerName;
                $data['user_id'] = $user_id;
                $data['amount'] =$amount;
                $data['date'] =Carbon::now();
                $data['email'] = $email;
                $data['transactionNumber'] = $response['transactionNumber'];
                DB::table('all_payment_histories')->insert($data);
                $notification = array(
                    'message'  => 'Your Transaction has been processing',
                    'alert-type'  => 'success'
                );
                return redirect()->route('dashboard')->with($notification);

            }
            elseif($response['details']['status']== 'ACCEPTED'){
                $id =AbujaPrepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
                //insert Biller Request Id here to prepaid table
                if($id == null){
                    DB::table('abuja_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
                }
                    $data = array();
                    $data['transactionNumber'] = $response['transactionNumber'];
                    $data['amount'] = $amount;
                    $data['exchangeReference']  =  $response['details']['exchangeReference'];
                    $data['creditToken']  = $response['details']['creditToken'];
                    $data['responseMessage']  = $response['details']['responseMessage'];
                    $data['status']  = $response['details']['status'];
                    $data['customerName']      =   $customerName;
                    $data['meterNumber']      =   $meterNumber;
                    $data['email']            =   $email;
                    $data['amount']            =   $amount;
                    $data['date']              =   Carbon::now();
                    $data['requestId']       =     $request_id;
                    $data['user_id']         =     $user_id;
                    $data = DB::table('all_payment_histories')->insert($data);
                    $selectAbujaPrepaid = AllPaymentHistory::where(['status' =>'ACCEPTED','user_id'=> $user_id])->orderBy('id','desc')->first();
                    return view('backend.electricity.abuja_electric.abuja_electric_accepted', compact('selectAbujaPrepaid'));
            }
            else{
                $notification = array(
                    'message'  => 'Transaction was rejected',
                    'alert-type'  => 'error'
                );
                return redirect()->back()->with($notification);

            }
        }
      }
    }

    }

    public function abuja_prepaidpdf(){
        $user_id = Auth::user()->id;
        $data['pdf_details'] =AllPaymentHistory::where('user_id', $user_id)->orderBy('id','desc')->first();
        $pdf = PDF::loadView('backend.electricity.abuja_electric.abujaprepaid_pdf',$data);
    	$pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }

    public function abujaElectricPostpaidView(){
        return view('backend.electricity.abuja_electric.abuja_electric_postpaid.abuja_electric_postpaid');
    }

    public function AbujaPostpaidBuy(Request $request){
        $user_id = Auth::user()->id;
        $accountNumber = $request->accountNumber;
        $amount = $request->amount;
        $mobileNumber = $request->phone;

         //insert a phone in users table
         $phone = User::where('id',$user_id)->first()['phone'];
         if($phone == null){
             User:: where('id',$user_id)->update(['phone' => $mobileNumber]);
         }

         $response = Http::withHeaders([
           'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
           'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
       ])->post('http://132.145.231.191/vasb2b/dev/Api/proxy',[
           'details' => ['customerReference' => $accountNumber,
           'customerReferenceType'  =>'POSTPAID'
       ],
           'serviceId' => 'BABB'
       ]);
     
       if($response->status() == 200){
        $customerName = $response['details']['customerName'];
        $responseMessage = $response['details']['responseMessage'];
        $uniqueCode = $response['details']['uniqueCode'];

           //call a payment gateway API for an authorization code 
           $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

           $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');

            if($response->status() == 200){
                //get user email address  and name
                $userEmailAddress = User::where('id', $user_id)->first()['email'];
                $customerName = User::where('id', $user_id)->first()['name'];

                //get the authorozation code on the header
                $code = $response->header('Authorization-Code');

         //get a request id for the transaction
         $requestId =(string)(rand(10000, 99999));
         //create a hash
         $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$userEmailAddress"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/abuja_postpaid/make/payment");

          //call a create payment Api
          $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
            'amount'        => $amount,
            'custName'      => $customerName,
            'custEmail'     => $userEmailAddress,
            'currency'      => 'NGN',
            'phoneNumber'   =>   $mobileNumber,
            'callbackUrl'   =>  'http://localhost/Ebill/services/public/abuja_postpaid/make/payment',
            'hash'          =>  $TRANSACTION_HASH,
            'requestId'     =>  $requestId,
            'narration'     =>  'Payment for Abuja Electric postpaid',]);
         if($response->status() == 200){
            $paymentUrl = $response->header('Payment-Url');
            
            //insert customer details into prepaid table
            $data = new AbujaPostPaid();
            $data->name = $customerName;
            $data->uniqueCode =  $uniqueCode;
            $data->customerReference = $accountNumber;
            $data->phone = $mobileNumber;
            $data->amount = $amount;
            $data->email = $userEmailAddress;
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

    public function abujaPostpaidPayment(){
      
        $requestId =$_GET['requestId'];
        $user_id = AbujaPostPaid::where('requestId',$requestId)->first()['user_id'] ;

        // $requestId =AbujaPostPaid::where('user_id',$user_id)->orderBy('id','desc')->first()['requestId'];

     //get a merchant hash for authorization code
     $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

     //calling authorization API to get an authorization code for billers
     $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');
     $code = $response->header('Authorization-Code');

    
      //calling validate payment API
      $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/payment/validate', ['requestId' => $requestId,]);


                
        if($response->status() == 200){
            $data = array();
            $data['message']  = $response['message'];
            $data['status']  = $response['data']['status'];
            $data['transactionReference']  = $response['data']['transactionReference'];
            $data['transactionDate']  = $response['data']['transactionDate'];

            DB::table('abuja_post_paids')->where('requestId',$requestId)->update($data);

            if($response['data']['status'] == "Failed"){
                $notification = array(
                    'message'    => 'Your Payment was not successfull',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with( $notification);
            }
            if($response['data']['status'] == 'Success'){


                    //generate a request id for exchange
                    $request_id = (rand(1000, 9999));

                    $data = AbujaPostPaid::where('user_id',$user_id)->orderBy('id','desc')->first();
                    $accountNumber = $data->customerReference;
                    $uniqueCode = $data->uniqueCode;
                    $phoneNumber = $data->phone;
                    $email = $data->email;
                    $accountNumber = $data->customerReference;
                    $customerName = $data->name;
                    $amount = $data->amount;
    
            $response = Http::withHeaders([
                'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
                'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
            ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
                'details' => [
                'customerReference'      => $accountNumber,
                'customerReferenceType'  => 'POSTPAID',
                'uniqueCode'       => $uniqueCode,
                'amount'           =>  $amount
               ],
                'id'                 => $request_id,
                'paymentCollectorId' => "CDL",
                'paymentMethod'      => 'POSTPAID',
                'serviceId'          => 'BABB'
            ]);
           if($response->status()== 200){

            $billerId = AbujaPostPaid::where('requestId',$requestId)->first()['billerRequestId'];
            if($response['details']['status']== 'PENDING'){
                $id =AbujaPostPaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
                //insert Biller Request Id here to prepaid table
                if($id == null){
                    DB::table('abuja_post_paids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
                }
              
                   //insert to pending_transaction table
                    DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'phone'=> $phoneNumber, 'accountNumber'=>$accountNumber,'user_id' => $user_id]);
                    $data = array();
                    $data['status'] = $response['details']['status'];
                    $data['requestId'] = $request_id;
                    $data['amount'] = $amount;
                    $data['accountNumber'] = $accountNumber;
                    $data['email'] = $email;
                    $data['customerName'] =$customerName;
                    $data['user_id'] = $user_id;
                    $data['date'] = Carbon::now();
                    $data['email'] = $email;
                    $data['transactionNumber'] = $response['transactionNumber'];
                    DB::table('all_payment_histories')->insert($data);
                    $notification = array(
                        'message'  => 'Your Transaction has been processing',
                        'alert-type'  => 'success'
                    );
                    return redirect()->route('dashboard')->with($notification);

            }
            elseif($response['details']['status']== 'ACCEPTED'){
                $id =AbujaPostPaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
                //insert Biller Request Id here to prepaid table
                if($id == null){
                    DB::table('abuja_post_paids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
                }
                    $data = array();
                    $data['transactionNumber'] = $response['transactionNumber'];
                    $data['amount'] = $amount;
                    $data['exchangeReference']  =  $response['details']['exchangeReference'];
                    $data['creditToken']  = $response['details']['creditToken'];
                    $data['responseMessage']  = $response['details']['responseMessage'];
                    $data['status']  = $response['details']['status'];
                    $data['customerName']      =   $customerName;
                    $data['accountNumber'] = $accountNumber;
                    $data['email'] = $email;
                    $data['date'] = Carbon::now();
                    $data['requestId']         =     $request_id;
                    $data['user_id']         =     $user_id;
                    $data = DB::table('all_payment_histories')->insert($data);
                    $selectAbujaPostPaid = AllPaymentHistory::where(['status' =>'ACCEPTED','user_id'=> $user_id])->orderBy('id','desc')->first();
                    return view('backend.electricity.abuja_electric.abuja_electric_postpaid.abuja_postpaid_accepted', compact('selectAbujaPostPaid'));
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
 public function abuja_postpaidpdf(){
    $user_id = Auth::user()->id;
    $data['pdf_details'] =AllPaymentHistory::where('user_id', $user_id)->orderBy('id','desc')->first();
    $pdf = PDF::loadView('backend.electricity.abuja_electric.abuja_electric_postpaid.abujapostpaid_pdf',$data);
    $pdf->SetProtection(['copy', 'print'], '', 'pass');
    return $pdf->stream('document.pdf');
}

//  public function ikejaPrepaidComfirmPayment(Request $request){

//     $user_id = Auth::user()->id;

//     //get a request id from  to validate user payment
//     $requestId = $request->requestId;
    
//      //get a merchant hash for authorization code
//      $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

//      //calling authorization API to get an authorization code for billers
//      $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');
//      $code = $response->header('Authorization-Code');

//     //get the parameters and save to database and share token value with the user

//     //calling validate payment API
//      $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/payment/validate', ['requestId' => $requestId,]);

    
             
//         if($response->status() == 200){
//             $data = array();
//             $data['message']  = $response['message'];
//             $data['status']  = $response['data']['status'];
//             $data['transactionReference']  = $response['data']['transactionReference'];
//             $data['transactionDate']  = $response['data']['transactionDate'];

//             DB::table('ikeja_prepaids')->where('requestId',$requestId)->update($data);

//             if($response['data']['status'] == "Failed"){
//                 $notification = array(
//                     'message'    => 'Your Payment was not successfull',
//                     'alert-type' => 'error'
//                 );
//                 return redirect()->route('dashboard')->with( $notification);
//             }
//             if($response['data']['status'] == 'Success'){


//                     //generate a request id for exchange
//                     $request_id = (rand(1000, 9999));

//                     $data = IkejaPrepaid::where('user_id',$user_id)->orderBy('id','desc')->first();
//                     $name = $data->name;
//                     $phoneNumber = $data->phone;
//                     $meterNumber = $data->meterNumber;
//                     $customerDtNumber = $data->customerDtNumber;
//                     $customerAccountType = $data->customerAccountType;
//                     $email = $data->email;
//                     $address = $data->address;
//                     $amount = $data->amount;
    
//             $response = Http::withHeaders([
//                 'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
//                 'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
//             ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
//                 'details' => [
//                 'customerName'      => $name,
//                 'meterNumber'      => $meterNumber,
//                 'customerAddress'      => $address,
//                 'phoneNumber'  =>    $phoneNumber,
//                 'customerAccountType'  => $customerAccountType,
//                 'customerDtNumber'       =>  $customerDtNumber,
//                 'contactType'       => 'TENANT',
//                 'email'       =>      $email,
//                 'amount'           =>  $amount
//                ],
//                 'id'                 => $request_id,
//                 'paymentCollectorId' => "CDL",
//                 'paymentMethod'      => 'PREPAID',
//                 'serviceId'          => 'APB'
//             ]);
         
//             $id =IkejaPrepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
//             //insert Biller Request Id here to prepaid table
//             if($id == null){
//                 DB::table('ikeja_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
//             }
//            if($response->status()== 200){

//             $billerId = IkejaPrepaid::where('requestId',$requestId)->first()['billerRequestId'];
//             if($response['details']['status']== 'PENDING'){
//                 $id =IkejaPrepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
//                 //insert Biller Request Id here to prepaid table
//                 if($id == null){
//                     DB::table('ikeja_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
//                 }
//                 //insert to pending_transaction table
//                 DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'phone'=> $phoneNumber, 'meterNumber'=>$meterNumber,'user_id' => $user_id]);
//                 $data = array();
//                 $data['status'] = $response['details']['status'];
//                 $data['requestId'] = $request_id;
//                 $data['customerName'] =$customerName;
//                 $data['user_id'] = $user_id;
//                 $data['transactionNumber'] = $response['transactionNumber'];
//                 DB::table('ikeja_prepaid_payment_histories')->insert($data);
//                 $notification = array(
//                     'message'  => 'Your Transaction has been processing',
//                     'alert-type'  => 'success'
//                 );
//                 return redirect()->route('dashboard')->with($notification);
                

//             }
//             elseif($response['details']['status']== 'ACCEPTED'){
//                 $id =IkejaPrepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
//                 //insert Biller Request Id here to prepaid table
//                 if($id == null){
//                     DB::table('ikeja_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
//                 }
//                     $data = array();
//                     $data['transactionNumber'] = $response['transactionNumber'];
//                     $data['amount'] = $amount;
//                     $data['meterNumber'] = $meterNumber;
//                     $data['exchangeReference']  =  $response['details']['exchangeReference'];
//                     $data['utilityName']  =  $response['details']['utilityName'];
//                     $data['creditToken']  = $response['details']['creditToken'];
//                     $data['tokenAmount'] = $response['details']['tokenAmount'];
//                     $data['status']  = $response['details']['status'];
//                     $data['customerName']      =   $name;
//                     $data['requestId']         =     $request_id;
//                     $data['user_id']         =     $user_id;
//                     $data = DB::table('ikeja_prepaid_payment_histories')->insert($data);

//                 $notification = array(
//                     'message'  => 'your transaction was successfull',
//                     'alert-type'  => 'success'
//                 );
//                 return redirect()->route('dashboard')->with($notification);
//             }
//             else{
//                 $notification = array(
//                     'message'  => 'Transaction was rejected',
//                     'alert-type'  => 'error'
//                 );
//                 return redirect()->route('dashboard')->with($notification);

//             }
//         }
//       }
//     }

//  }

//  public function ikejaPostpaidConfirmPayment(Request $request){
    
//     $user_id = Auth::user()->id;

//     //get a request id from  to validate user payment
//     $requestId = $request->requestId;
    
//      //get a merchant hash for authorization code
//      $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

//      //calling authorization API to get an authorization code for billers
//      $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');
//      $code = $response->header('Authorization-Code');

//     //get the parameters and save to database and share token value with the user

//     //calling validate payment API
//      $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/payment/validate', ['requestId' => $requestId,]);

    
             
//         if($response->status() == 200){
//             $data = array();
//             $data['message']  = $response['message'];
//             $data['status']  = $response['data']['status'];
//             $data['transactionReference']  = $response['data']['transactionReference'];
//             $data['transactionDate']  = $response['data']['transactionDate'];

//             DB::table('ikeja_postpaids')->where('requestId',$requestId)->update($data);

//             if($response['data']['status'] == "Failed"){
//                 $notification = array(
//                     'message'    => 'Your Payment was not successfull',
//                     'alert-type' => 'error'
//                 );
//                 return redirect()->route('dashboard')->with( $notification);
//             }
//             if($response['data']['status'] == 'Success'){
//                     //generate a request id for exchange
//                     $request_id = (rand(1000, 9999));

//                     $data = IkejaPostPaid::where('user_id',$user_id)->orderBy('id','desc')->first();
//                     $name = $data->name;
//                     $phoneNumber = $data->phone;
//                     $customerAccount = $data->customerAccount;
//                     $customerDtNumber = $data->customerDtNumber;
//                     $phoneNumber = $data->phone;
//                     $customerAccountType = $data->customerAccountType;
//                     $email = $data->email;
//                     $address = $data->address;
//                     $amount = $data->amount;
    
//             $response = Http::withHeaders([
//                 'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
//                 'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
//             ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
//                 'details' => [
//                 'customerName'      => $name,
//                 'accountNumber'      => $customerAccount,
//                 'customerAddress'      => $address,
//                 'phoneNumber'  =>    $phoneNumber,
//                 'customerAccountType'  => $customerAccountType,
//                 'customerDtNumber'       => $customerDtNumber,
//                 'contactType'       => 'LANDLORD',
//                 'email'       =>      $email,
//                 'amount'           =>  $amount
//                ],
//                 'id'                 => $request_id,
//                 'paymentCollectorId' => "CDL",
//                 'paymentMethod'      => 'POSTPAID',
//                 'serviceId'          => 'APA'
//             ]);
//            if($response->status()== 200){
//             if($response['details']['status']== 'PENDING'){
//                 $id =IkejaPostpaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
//                 //insert Biller Request Id here to prepaid table
//                 if($id == null){
//                     DB::table('ikeja_postpaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
//                 }
               
//                  //insert to pending_transaction table
//                  DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'phone'=> $phoneNumber, 'accountNumber'=>$ $customerAccount,'user_id' => $user_id]);
//                  $data = array();
//                  $data['status'] = $response['details']['status'];
//                  $data['requestId'] = $request_id;
//                  $data['customerName'] =$customerName;
//                  $data['user_id'] = $user_id;
//                  $data['transactionNumber'] = $response['transactionNumber'];
//                  DB::table('ikeja_postpaid_payment_histories')->insert($data);
//                  $notification = array(
//                      'message'  => 'Your Transaction has been processing',
//                      'alert-type'  => 'success'
//                  );
//                  return redirect()->route('dashboard')->with($notification);
//             }
//             elseif($response['details']['status']== 'ACCEPTED'){
//                 $id =IkejaPostpaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
//                 //insert Biller Request Id here to prepaid table
//                 if($id == null){
//                     DB::table('ikeja_postpaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
//                 }
//                     $data = array();
//                     $data['transactionNumber'] = $response['transactionNumber'];
//                     $data['amount'] = $amount;
//                     $data['customerName'] = $name;
//                     $data['accountNumber'] = $customerAccount;
//                     $data['exchangeReference']  =  $response['details']['exchangeReference'];
//                     $data['utilityName']  =  $response['details']['utilityName'];
//                     $data['balance'] = $response['details']['balance'];
//                     $data['status']  = $response['details']['status'];
//                     $data['requestId']         =     $request_id;
//                     $data['user_id']         =     $user_id;
   
//                     $data = DB::table('ikeja_postpaid_payment_histories')->insert($data);

//                 $notification = array(
//                     'message'  => 'your transaction was successfull',
//                     'alert-type'  => 'success'
//                 );
//                 return redirect()->route('dashboard')->with($notification);
//             }
//             else{
//                 $notification = array(
//                     'message'  => 'Transaction was rejected',
//                     'alert-type'  => 'error'
//                 );
//                 return redirect()->route('dashboard')->with($notification);

//             }
//         }
//       }
//     }
//  }

//  public function kadunaPrepaidComfirmPayment(Request $request){

//     $user_id = Auth::user()->id;

//     //get a request id from  to validate user payment
//     $requestId = $request->requestId;
    
//      //get a merchant hash for authorization code
//      $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

//      //calling authorization API to get an authorization code for billers
//      $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');
//      $code = $response->header('Authorization-Code');

//     //get the parameters and save to database and share token value with the user

//     //calling validate payment API
//      $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/payment/validate', ['requestId' => $requestId,]);

    
             
//         if($response->status() == 200){
//             $data = array();
//             $data['message']  = $response['message'];
//             $data['status']  = $response['data']['status'];
//             $data['transactionReference']  = $response['data']['transactionReference'];
//             $data['transactionDate']  = $response['data']['transactionDate'];

//             DB::table('kaduna_prepaids')->where('requestId',$requestId)->update($data);

//             if($response['data']['status'] == "Failed"){
//                 $notification = array(
//                     'message'    => 'Your Payment was not successfull',
//                     'alert-type' => 'error'
//                 );
//                 return redirect()->route('dashboard')->with( $notification);
//             }
//             if($response['data']['status'] == 'Success'){


//                     //generate a request id for exchange
//                     $request_id = (rand(1000, 9999));

//                     $data = KadunaPrepaid::where('user_id',$user_id)->orderBy('id','desc')->first();
//                     $name = $data->name;
//                     $phoneNumber = $data->phone;
//                     $meterNumber = $data->meterNumber;
//                     $tariff = $data->tariff;
//                     $email = $data->email;
//                     $address = $data->address;
//                     $amount = $data->amount;
    
//             $response = Http::withHeaders([
//                 'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
//                 'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
//             ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
//                 'details' => [
//                 'customerName'      => $name,
//                 'meterNumber'      => $meterNumber,
//                 'customerAddress'      => $address,
//                 'customerMobileNumber'  =>  $phoneNumber,
//                 'tariff'       => $tariff,
//                 'amount'           =>  $amount
//                ],
//                 'id'                 => $request_id,
//                 'paymentCollectorId' => "CDL",
//                 'paymentMethod'      => 'PREPAID',
//                 'serviceId'          => 'CDA'
//             ]);
//            if($response->status()== 200){

//             $billerId = KadunaPrepaid::where('requestId',$requestId)->first()['billerRequestId'];
//             if($response['details']['status']== 'PENDING'){
                
//             $id =KadunaPrepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
//             //insert Biller Request Id here to prepaid table
//             if($id == null){
//                 DB::table('kaduna_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
//             }
            
//                    //insert to pending_transaction table
//                    DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'phone'=> $phoneNumber, 'meterNumber'=>$ $meterNumber,'user_id' => $user_id]);
//                    $data = array();
//                    $data['status'] = $response['details']['status'];
//                    $data['requestId'] = $request_id;
//                    $data['customerName'] =$customerName;
//                    $data['user_id'] = $user_id;
//                    $data['transactionNumber'] = $response['transactionNumber'];
//                    DB::table('kaduna_prepaid_payment_histories')->insert($data);
//                    $notification = array(
//                        'message'  => 'Your Transaction has been processing',
//                        'alert-type'  => 'success'
//                    );
//                    return redirect()->route('dashboard')->with($notification);

//             }
//             elseif($response['details']['status']== 'ACCEPTED'){
                
//             $id =KadunaPrepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
//             //insert Biller Request Id here to prepaid table
//             if($id == null){
//                 DB::table('kaduna_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
//             }
//                     $data = array();
//                     $data['transactionNumber'] = $response['transactionNumber'];
//                     $data['amount'] = $amount;
//                     $data['meterNumber'] = $meterNumber;
//                     $data['responseMessage']  =  $response['details']['responseMessage'];
//                     $data['vendAmount']  =  $response['details']['vendAmount'];
//                     $data['discoExchangeReference']  = $response['details']['discoExchangeReference'];
//                     $data['token'] = $response['details']['token'];
//                     $data['status']  = $response['details']['status'];
//                     $data['customerName']      =   $name;
//                     $data['requestId']         =     $request_id;
//                     $data['user_id']         =     $user_id;
   
//                     $data = DB::table('kaduna_prepaid_payment_histories')->insert($data);

//                 $notification = array(
//                     'message'  => 'your transaction was successfull',
//                     'alert-type'  => 'success'
//                 );
//                 return redirect()->route('dashboard')->with($notification);
//             }
//             else{
//                 $notification = array(
//                     'message'  => 'Transaction was rejected',
//                     'alert-type'  => 'error'
//                 );
//                 return redirect()->route('dashboard')->with($notification);

//             }
//         }
//       }
//     }
//         $data['abujaElectricPostpaid'] = AbujaPostPaid::where('user_id',$user_id)->orderBy('id','desc')->first();
//         return view('backend.electricity.abuja_electric.abuja_electric_postpaid.abuja_propaid_confirm_payment',$data);

//     }
}
