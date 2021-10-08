<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Http;
use Auth;
use App\Models\User;

class KedcoController extends Controller
{

    public function kedcoPrepaidView(){
        return view('backend.electricity.kedco_electircity.kedco_prepaid_view');
    }


    public function kedCoBuyToken(Request $request){
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
        ],
            'serviceId' => 'AVC'
        ]);
dd($response->json());
        if($response->status() == 200 & $response['errorMessage' ]== null){
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
}



