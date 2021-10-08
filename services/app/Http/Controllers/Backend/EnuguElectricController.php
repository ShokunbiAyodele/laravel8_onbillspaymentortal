<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\enuguPrepaid;
use App\Models\enuguPostpaid;
use App\Models\User;
use App\Models\AllPaymentHistory;
use Carbon\Carbon;
use Auth;
use Redirect;
use PDF;
use DB;

class EnuguElectricController extends Controller
{
    public function enuguElectricPrepaidView(){
        return view('backend.electricity.enugu_prepaid.enugu_prepaid_view');

    }


    public function enuguElectricBuyToken(Request $request){

        $user_id = Auth::user()->id; 
        $meterNumber = $request->meterNumber;
        $amount = $request->amount;
        $mobileNumber = $request->phone;

     
        //insert a phone in users table
        $phone = User::where('id',$user_id)->first()['phone'];
        if($phone == null){
            User:: where('id',$user_id)->update(['phone' => $mobileNumber]);
        }
        //call Proxy API
        $response = Http::withHeaders([
            'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
            'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        ])->post('http://132.145.231.191/vasb2b/dev/Api/proxy',[
            'details' => ['customerReference' => $meterNumber,
                         'requestType' => 'VALIDATE_METER_NUMBER'
        ],
            'serviceId' => 'BOA'
        ]);
    
     
        if($response->status() === 200){
            $customerAddress  = $response['details']['address'];
            $lastName     =  $response['details']['lastName'];
            $firstName = $response['details']['firstName'];
            $paymentPlan = $response['details']['paymentPlan'];
            $phoneNumber = $response['details']['phoneNumber'];
            $meterNumber = $response['details']['meterNumber'];
            $district = $response['details']['district'];
            $accountNumber = $response['details']['accountNumber'];

             //call a payment gateway API for an authorization code 
             $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

             $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');

            if($response->status()  == 200){
                // dd($response->headers());
                //get  Email Address
                $emailAddress = User::where('id',$user_id)->first()['email'];
                
                $code = $response->header('Authorization-Code');
               
             //get a request id for the transaction
             $requestId =(string)(rand(10000, 99999));
             //create a hash
             $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$emailAddress"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/enugu_prepaid/make/payment");
          
             //call a create payment Api
             $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
             'amount'        => $amount,
             'custName'      => $lastName,
             'custEmail'     => $emailAddress,
             'currency'      => 'NGN',
             'phoneNumber'   =>   $mobileNumber,
             'callbackUrl'   =>  'http://localhost/Ebill/services/public/enugu_prepaid/make/payment',
             'hash'          =>  $TRANSACTION_HASH,
             'requestId'     =>  $requestId,
             'narration'     =>  'Payment for Eko Electricity prepaid',]);
          
             if($response->status() == 200){
             $paymentUrl = $response->header('Payment-Url');
             //insert customer details into prepaid table
             $data = new enuguPrepaid();
             $data->name =$lastName;
             $data->paymentPlan = $paymentPlan;
             $data->district = $district;
             $data->accountNumber = $accountNumber;
             $data->email = $emailAddress;
             $data->meterNumber = $meterNumber;
             $data->date = Carbon::now();
             $data->phone    = $phoneNumber;
             $data->amount = $amount;
             $data->address = $customerAddress;
             $data->requestId = $requestId;
             $data->user_id   = $user_id;
             $data->save();

             return Redirect::to($paymentUrl);

             }

            }
        }
        else{
            $notification = array(
                'message'    => 'Validation Failed, data mot matched',
                'alert-type' => 'error'
            );
            return redirect()->back()->with( $notification);
        }

    }

    public function enuguPrepaidPayment(){
        $requestId =$_GET['requestId'];
        $user_id = enuguPrepaid::where('requestId',$requestId)->first()['user_id'];
    // $requestId =enuguPrepaid::where('user_id',$user_id)->orderBy('id','desc')->first()['requestId'];

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

            DB::table('prepaids')->where('requestId',$requestId)->update($data);

            if($response['data']['status'] == "Failed"){
                $notification = array(
                    'message'    => 'Your Payment was not successfull',
                    'alert-type' => 'error'
                );
                return redirect()->route('dashboard')->with($notification);
            }
           
            if($response['data']['status'] == "Success"){
                  //generate a request id for exchange
                  $request_id = (rand(1000, 9999));

                $data = enuguPrepaid::where('user_id',$user_id)->orderBy('id','desc')->first();
                $customerName = $data->name;
                $customerAddress = $data->address;
                $phoneNumber = $data->phone;
                $customerDistrict = $data->district;
                $meterNumber = $data->meterNumber;
                $accountNumber = $data->accountNumber;
                $amount = $data->amount;

        $response = Http::withHeaders([
            'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
            'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
            'details' => [
            'accountNumber'      => $accountNumber,
            'meterNumber'        => $meterNumber,
            'customerPhoneNumber'=> $phoneNumber,
            'customerAddress'    => $customerAddress,
            'customerDistrict'   => $customerDistrict,
            'customerName'       => $customerName,
            'amount'             =>  $amount
           ],
            'id'                 => $request_id,
            'paymentCollectorId' => "CDL",
            'paymentMethod'      => 'PREPAID',
            'serviceId'          => 'BOA'
        ]);
    
       if($response->status()== 200){
        if($response['details']['status']== 'PENDING'){
        $id =Prepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
          //insert Biller Request Id here to prepaid table
          if($id == null){
            DB::table('enugu_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
        }

        //insert to pending_transaction table
        DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'phone'=> $phoneNumber, 'meterNumber'=>$meterNumber,'user_id' => $user_id]);
        $data = array();
        $data['status'] = $response['details']['status'];
        $data['requestId'] = $request_id;
        $data['customerName'] =$customerName;
        $data['meternumber'] =$meternumber;
        $data['date'] = Carbon::now();
        $data['email'] =$email;
        $data['amount']          =     $amount;
        $data['user_id'] = $user_id;
        $data['transactionNumber'] = $response['transactionNumber'];
         DB::table('all_payment_histories')->insert($data);
        // $billerId = Prepaid::where('requestId',$requestId)->first()['billerRequestId']; 
        $notification = array(
            'message'  => 'Your Transaction has been processing',
            'alert-type'  => 'success'
        );
        return redirect()->route('dashboard')->with($notification);
        }
        elseif($response['details']['status']== 'ACCEPTED'){
         $id =enuguPrepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
        //insert Biller Request Id here to prepaid table
        if($id == null){
            DB::table('enugu_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
        }
            $data = array();
            $data['transactionNumber'] = $response['transactionNumber'];
            $data['token']  = $response['details']['token'];
            $data['exchangeReference']  = $response['details']['exchangeReference'];
            $data['status']  = $response['details']['status'];
            $data['responseMessage']  = $response['details']['responseMessage'];
            $data['customerName']      =      $request->customerName;
            $data['requestId']          =     $request_id;
            $data['meternumber'] =$meternumber;
            $data['date'] = Carbon::now();
            $data['email'] =$email;
            $data['amount']          =     $amount;
            $data['user_id']          =     $user_id;
            $data = DB::table('all_payment_histories')->insert($data);
            $selectenuguprepid = AllPaymentHistory::where(['status' =>'ACCEPTED','user_id'=> $user_id,'reuestId'=> $request_id])->orderBy('id','desc')->first();
            return view('backend.electricity.enugu_prepaid.enuguprepaid_acceptedTrans', compact('selectenuguprepid'));

           
        }
        else{
            $notification = array(
                'message'  => 'Request was Failed/Rejected',
                'alert-type'  => 'error'
            );
            return redirect()->route('dashboard')->with($notification);
            }
          }

         }

            
      }
}

public function enuguPrepaidPDF(){
    $user_id = Auth::user()->id;
    $data['pdf_details'] =AllPaymentHistory::where('user_id', $user_id)->orderBy('id','desc')->first();
    $pdf = PDF::loadView('backend.electricity.enugu_prepaid.enuguprepaid_pdf',$data);
    $pdf->SetProtection(['copy', 'print'], '', 'pass');
    return $pdf->stream('document.pdf');
     
}


    public function enuguPostpaidView(){

        return view('backend.electricity.enugu_postpaid.enugu_postpaid_view');

    }

    public function enuguPostpaidBuy(Request $request){
        
        $user_id = Auth::user()->id; 
        $accountNumber = $request->accountNumber;
        $amount = $request->amount;
        $mobileNumber = $request->phone;

        //insert a phone in users table
        $phone = User::where('id',$user_id)->first()['phone'];
        if($phone == null){
            User:: where('id',$user_id)->update(['phone' => $mobileNumber]);
        }
        //call Proxy API
        $response = Http::withHeaders([
            'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
            'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        ])->post('http://132.145.231.191/vasb2b/dev/Api/proxy',[
            'details' => ['customerReference' => $accountNumber,
                         'requestType' => 'VALIDATE_ACCOUNT_NUMBER'
        ],
            'serviceId' => 'BOB'
        ]);
   
        if($response->status() === 200){
            $customerAddress  = $response['details']['address'];
            $lastName     =  $response['details']['lastName'];
            $firstName = $response['details']['firstName'];
            $paymentPlan = $response['details']['paymentPlan'];
            $phoneNumber = $response['details']['phoneNumber'];
            $meterNumber = $response['details']['meterNumber'];
            $district = $response['details']['district'];
            $accountNumber = $response['details']['accountNumber'];

             //call a payment gateway API for an authorization code 
             $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

             $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');

            if($response->status()  == 200){
                // dd($response->headers());
                //get  Email Address
                $emailAddress = User::where('id',$user_id)->first()['email'];
                
                $code = $response->header('Authorization-Code');
               
             //get a request id for the transaction
             $requestId =(string)(rand(10000, 99999));
             //create a hash
             $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$emailAddress"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/enugu_postpaid/make/payment");
          
             //call a create payment Api
             $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
             'amount'        => $amount,
             'custName'      => $lastName,
             'custEmail'     => $emailAddress,
             'currency'      => 'NGN',
             'phoneNumber'   =>   $mobileNumber,
             'callbackUrl'   =>  'http://localhost/Ebill/services/public/enugu_postpaid/make/payment',
             'hash'          =>  $TRANSACTION_HASH,
             'requestId'     =>  $requestId,
             'narration'     =>  'Payment forEnugu Electricity postpaid',]);
          
             if($response->status() == 200){
             $paymentUrl = $response->header('Payment-Url');
             //insert customer details into prepaid table
             $data = new enuguPostpaid();
             $data->name =$lastName;
             $data->paymentPlan = $paymentPlan;
             $data->district = $district;
             $data->accountNumber = $accountNumber;
             $data->email = $emailAddress;
             $data->meterNumber = $meterNumber;
             $data->date = Carbon::now();
             $data->phone    = $phoneNumber;
             $data->amount = $amount;
             $data->address = $customerAddress;
             $data->requestId = $requestId;
             $data->user_id   = $user_id;
             $data->save();

             return Redirect::to($paymentUrl);

             }

            }
        }
        else{
            $notification = array(
                'message'    => 'Validation Failed, data mot matched',
                'alert-type' => 'error'
            );
            return redirect()->back()->with( $notification);
        }

    }

    public function EnuguPostpaidPayment(){
        
        $requestId =$_GET['requestId'];
        $user_id = enuguPostpaid::where('requestId',$requestId)->first()['user_id'];
        // $requestId =enuguPostpaid::where('user_id',$user_id)->orderBy('id','desc')->first()['requestId'];
        
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

            DB::table('enugu_postpaids')->where('requestId',$requestId)->update($data);

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

                    $data = enuguPostpaid::where('user_id',$user_id)->orderBy('id','desc')->first();
            
                    $customerName = $data->name;
                    $customerAddress = $data->address;
                    $phoneNumber = $data->phone;
                    $email = $data->email;
                    $customerDistrict = $data->district;
                    $meterNumber = $data->meterNumber;
                    $accountNumber = $data->accountNumber;
                    $amount = $data->amount;
    
            $response = Http::withHeaders([
                'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
                'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
            ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
                'details' => [
                    'accountNumber'      => $accountNumber,
                    'meterNumber'        => $meterNumber,
                    'customerPhoneNumber'=> $phoneNumber,
                    'customerAddress'    => $customerAddress,
                    'customerDistrict'   => $customerDistrict,
                    'customerName'       => $customerName,
                    'amount'             =>  $amount
               ],
                'id'                 => $request_id,
                'paymentCollectorId' => "CDL",
                'paymentMethod'      => 'POSTPAID',
                'serviceId'          => 'BOB'
            ]);
           if($response->status()== 200){

            if($response['details']['status']== 'PENDING'){
                $id =enuguPostpaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
                //insert Biller Request Id here to prepaid table
                if($id == null){
                    DB::table('enugu_postpaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id,'user_id' => $user_id]);
                }
            //insert to pending_transaction table
            DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'phone'=> $phoneNumber, 'meterNumber'=>$meterNumber,'user_id' => $user_id]);
            $data = array();
            $data['status'] = $response['details']['status'];
            $data['requestId'] = $request_id;
            $data['meterNumber'] = $meterNumber;
            $data['customerName'] =$customerName;
            $data['date'] = Carbon::now();
            $data['user_id'] = $user_id;
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
                $id =enuguPostpaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
                //insert Biller Request Id here to prepaid table
                if($id == null){
                    DB::table('enugu_postpaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id,'user_id' => $user_id]);
                }
                    $data = array();
                    $data['transactionNumber'] = $response['transactionNumber'];
                    $data['amount'] = $amount;
                    $data['accountNumber'] = $accountNumber;
                    $data['email'] = $email;
                    $data['date'] = Carbon::now();
                     $data['responseMessage'] =  $response['details']['responseMessage'];;
                     $data['exchangeReference']  =  $response['details']['exchangeReference'];
                     $data['receiptNumber']  =  $response['details']['receiptNumber'];
                     $data['meterNumber'] = $meterNumber;
                     $data['status']  = $response['details']['status'];
                    $data['customerName']      =   $name;
                    $data['requestId']         =     $request_id;
                    $data['user_id']         =     $user_id;
                    $data = DB::table('all_payment_histories')->insert($data);
                    $selectenuguPostpaid = AllPaymentHistory::where(['status' =>'ACCEPTED','user_id'=> $user_id])->orderBy('id','desc')->first();
            return view('backend.electricity.enugu_postpaid.enugpostpaid_acceptedTrans', compact('selectenuguPostpaid'));

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


    public function enuguPostpaidPDF(){
        $user_id = Auth::user()->id;
    $data['pdf_details'] =AllPaymentHistory::where('user_id', $user_id)->orderBy('id','desc')->first();
    $pdf = PDF::loadView('backend.electricity.enugu_postpaid.enugupostpaid_pdf',$data);
    $pdf->SetProtection(['copy', 'print'], '', 'pass');
    return $pdf->stream('document.pdf');

    }

}

