<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Http;
use Auth;
use App\Models\User;
use App\Models\KadunaPrepaid;
class KadunaElectricController extends Controller
{
    public function kadunaElectricView(){
        return view('backend.electricity.kaduna_electricity.kaduna_prepaid_view');


    }

    public function kadunaElectricBuyToken(Request $request){
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
            'serviceId' => 'CDA'
        ]);
  
        if($response->status() == 200  ){
            $name = $response['details']['customerName'];
            $address = $response['details']['customerAddress'];
            $meterNumber = $response['details']['meterNumber'];
            $tariff = $response['details']['tariff'];


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
             $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$userEmailAddress"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/kaduna_prepaid/make/payment");

              //call a create payment Api
              $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
                'amount'        => $amount,
                'custName'      => $name,
                'custEmail'     => $userEmailAddress,
                'currency'      => 'NGN',
                'phoneNumber'   =>   $mobileNumber,
                'callbackUrl'   =>  'http://localhost/Ebill/services/public/kaduna_prepaid/make/payment',
                'hash'          =>  $TRANSACTION_HASH,
                'requestId'     =>  $requestId,
                'narration'     =>  'Payment for Kaduna Electric prepaid',]);

             if($response->status() == 200){
                $paymentUrl = $response->header('Payment-Url');
                //insert customer details into prepaid table
                $data = new KadunaPrepaid();
                $data->name = $name;
                $data->address =  $address;
                $data->meterNumber = $meterNumber;
                $data->email = $userEmailAddress;
                $data->phone = $mobileNumber;
                $data->tariff = $tariff;
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

    public function kadunaPrepaidPayment(){
        $requestId =$_GET['requestId'];
        $user_id = KadunaPrepaid::where('requestId',$requestId)->first()['user_id'];

        // $requestId =KadunaPrepaid::where('user_id',$user_id)->orderBy('id','desc')->first()['requestId'];

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

            DB::table('kaduna_prepaids')->where('requestId',$requestId)->update($data);

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

                    $data = KadunaPrepaid::where('user_id',$user_id)->orderBy('id','desc')->first();
                    $name = $data->name;
                    $phoneNumber = $data->phone;
                    $meterNumber = $data->meterNumber;
                    $tariff = $data->tariff;
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
                'customerMobileNumber'  =>  $phoneNumber,
                'tariff'       => $tariff,
                'amount'           =>  $amount
               ],
                'id'                 => $request_id,
                'paymentCollectorId' => "CDL",
                'paymentMethod'      => 'PREPAID',
                'serviceId'          => 'CDA'
            ]);
           if($response->status()== 200){

            $billerId = KadunaPrepaid::where('requestId',$requestId)->first()['billerRequestId'];
            if($response['details']['status']== 'PENDING'){
                
            $id =KadunaPrepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
            //insert Biller Request Id here to prepaid table
            if($id == null){
                DB::table('kaduna_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
            }
            
                   //insert to pending_transaction table
                   DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'phone'=> $phoneNumber, 'meterNumber'=>$ $meterNumber,'user_id' => $user_id]);
                   $data = array();
                   $data['status'] = $response['details']['status'];
                   $data['requestId'] = $request_id;
                   $data['customerName'] =$customerName;
                   $data['meterNumber'] = $meterNumber;
                   $data['email'] = $email;
                   $data['date'] = Carbon::now();
                   $data['user_id'] = $user_id;
                   $data['transactionNumber'] = $response['transactionNumber'];
                   DB::table('all_payment_histories')->insert($data);
                   $notification = array(
                    'message'  => 'your transaction has been proccessing',
                    'alert-type'  => 'success'
                );
                return redirect()->route('dashboard')->with($notification);
            }
            elseif($response['details']['status']== 'ACCEPTED'){
                
            $id =KadunaPrepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
            //insert Biller Request Id here to prepaid table
            if($id == null){
                DB::table('kaduna_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
            }
                    $data = array();
                    $data['transactionNumber'] = $response['transactionNumber'];
                    $data['amount'] = $amount;
                    $data['meterNumber'] = $meterNumber;
                    $data['responseMessage']  =  $response['details']['responseMessage'];
                    $data['token'] = $response['details']['token'];
                    $data['status']  = $response['details']['status'];
                    $data['customerName']      =   $name;
                    $data['email'] = $email;
                    $data['date'] = Carbon::now();
                    $data['requestId']         =     $request_id;
                    $data['user_id']         =     $user_id;
                    $data = DB::table('all_payment_histories')->insert($data);
                    $selectKadunaPrepaid = AllPaymentHistory::where(['status' =>'ACCEPTED','user_id'=> $user_id])->orderBy('id','desc')->first();
                   return view('backend.electricity.kaduna_electricity.kaduna_acceptedTrans', compact('selectKadunaPrepaid'));
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


    public function kadunaPrePaidPDF(){
        $user_id = Auth::user()->id;
        $data['pdf_details'] =AllPaymentHistory::where('user_id', $user_id)->orderBy('id','desc')->first();
        $pdf = PDF::loadView('backend.electricity.kaduna_electricity.kadunaprepaid_pdf',$data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');

    }
  
}
