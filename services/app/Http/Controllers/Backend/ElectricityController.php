<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Prepaid;
use App\Models\Postpaid;
use App\Models\User;
use Auth;
use Redirect;

class ElectricityController extends Controller
{
    public function EkoElectricityPrePaid(){
        return view('backend.electricity.prepaid_registeration');
    }

    public function BuyElectricity(Request $request){
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
            'details' => ['meterNumber' => $meterNumber],
            'serviceId' => 'BAA'
        ]);
      
        if($response->status() === 200){
            $customerAddress  = $response['details']['customerAddress'];
            $customerName     =  $response['details']['customerName'];
            $customerDistrict = $response['details']['customerDistrict'];
           
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
             $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$emailAddress"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/prepaid/make/payment");
          
             //call a create payment Api
             $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
             'amount'        => $amount,
             'custName'      => $customerName,
             'custEmail'     => $emailAddress,
             'currency'      => 'NGN',
             'phoneNumber'   =>   $mobileNumber,
             'callbackUrl'   =>  'http://localhost/Ebill/services/public/prepaid/make/payment',
             'hash'          =>  $TRANSACTION_HASH,
             'requestId'     =>  $requestId,
             'narration'     =>  'Payment for Eko Electricity prepaid',]);
            
          
             if($response->status() == 200){
             $paymentUrl = $response->header('Payment-Url');
             //insert customer details into prepaid table
             $data = new Prepaid();
             $data->customerName = $customerName;
             $data->customerDistrict = $customerDistrict;
             $data->meterNumber = $meterNumber;
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


        //this is Postpaid function
        public function EkoElectricityPostPaid(){
            return view('backend.electricity.postpaid.postpaid_reg');
        }        

        public function BuyElectricityPostPaid(Request $request){
            $user_id = Auth::user()->id; 
            $accountNumber = $request->referenceNumber;
            $amount = $request->amount;
            $mobileNumber = $request->phone;
            
             //insert a phone in users table
        $phone = User::where('id',$user_id)->first()['phone'];
        if($phone == null){
            User:: where('id',$user_id)->update(['phone' => $mobileNumber]);
        }

        //call a proxy API
        $response = Http::withHeaders([
            'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
            'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        ])->post('http://132.145.231.191/vasb2b/dev/Api/proxy',[
            'details' => ['customerReference' => $accountNumber],
            'serviceId' => 'AVA'
        ]);

        if($response->status() === 200){
            $accountNumber  = $response['details']['accountNumber'];
            $customerName     =  $response['details']['customerName'];
            $meterNumber     =  $response['details']['meterNumber'];
            $businessUnit = $response['details']['businessUnit'];

           
             //call a payment gateway API for an authorization code 
             $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

             $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');

            if($response->status()  == 200){
                // dd($response->headers());
                //get  Email Address
                $emailAddress = User::where('id',$user_id)->first()['email'];
                
                //get the authorization code
                $code = $response->header('Authorization-Code');
               
             //get a request id for the transaction
             $requestId =(string)(rand(10000, 99999));
             //create a hash
             $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$emailAddress"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/postpaid/make/payment");
          
             //call a create payment Api
             $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
             'amount'        => $amount,
             'custName'      => $customerName,
             'custEmail'     => $emailAddress,
             'currency'      => 'NGN',
             'phoneNumber'   =>   $mobileNumber,
             'callbackUrl'   =>  'http://localhost/Ebill/services/public/postpaid/make/payment',
             'hash'          =>  $TRANSACTION_HASH,
             'requestId'     =>  $requestId,
             'narration'     =>  'Payment for Eko Electricity postpaid',]);
            //  dd($response->json());
            
             if($response->status() == 200){
             $paymentUrl = $response->header('Payment-Url');
             //insert customer details into prepaid table
             $data = new Postpaid();
             $data->customerName = $customerName;
             $data->customerReference = $accountNumber;
             $data->amount = $amount;
             $data->businessUnit = $businessUnit;
             $data->requestId = $requestId;
             $data->user_id   = $user_id;
             $data->save();
            //  dd($paymentUrl);
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

        
}
