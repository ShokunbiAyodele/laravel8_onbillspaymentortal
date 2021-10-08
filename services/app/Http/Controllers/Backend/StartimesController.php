<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Http;
use Auth;
use App\Models\User;
use App\Models\startimesSuscriptionDetails;
use App\Models\startimestransactionHistory;
use App\Models\AllPaymentHistory;
use Carbon\Carbon;
use DB;
use PDF;

class StartimesController extends Controller
{
    public function startimesdetailsView(){
        return view('backend.startime.startime_purchase_view');

    }


    public function startimesSubPurchase(Request $request){
        $user_id = Auth::user()->id;
        $smartCard = $request->smartCard;
        $amount = $request->amount;
        $mobileNumber = $request->phone;
      
         //insert a phone in users table
        $phone = User::where('id',$user_id)->first()['phone'];
        if($phone == null){
            User:: where('id',$user_id)->update(['phone' => $mobileNumber]);
        }
       
        // $data = array(
        //     'smartCard' => $smartCard,
        //     'amount'  => $amount,
        //     'phone' => $mobileNumber,
        // );
        // dd($data);

         //validate smartCard Number//
          $response = Http::withHeaders([
            'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
            'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        ])->post('http://132.145.231.191/vasb2b/dev/Api/proxy',[
            'details' => ['smartCardNumber' => $smartCard,
        ],
            'serviceId' => 'AWA'
        ]);
   
        if($response->status() == 200){
            $smartCard = $response['details']['smartCardNumber'];

               //call a payment gateway API for an authorization code 
               $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

               $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');

                if($response->status() == 200){
                    //get user email address  and name
                    $user = User::where('id', $user_id)->first();
                    //get the authorozation code on the header
                    $code = $response->header('Authorization-Code');

             //get a request id for the transaction
             $requestId =(string)(rand(10000, 99999));
             //create a hash
             $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$user->email"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/startimes/purchase/pdf_details");

              //call a create payment Api
              $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
                'amount'        => $amount,
                'custName'      => $user->name,
                'custEmail'     => $user->email,
                'currency'      => 'NGN',
                'phoneNumber'   =>   $mobileNumber,
                'callbackUrl'   =>  'http://localhost/Ebill/services/public/startimes/purchase/pdf_details',
                'hash'          =>  $TRANSACTION_HASH,
                'requestId'     =>  $requestId,
                'narration'     =>  'Payment for startimes susbscription',]);
             if($response->status() == 200){
                $paymentUrl = $response->header('Payment-Url');
                //insert customer details into prepaid table
                $data = new startimesSuscriptionDetails();
                $data->name = $user->name;
                $data->smartCard = $smartCard;
                $data->email =  $user->email;
                $data->phone = $mobileNumber;
                $data->amount = $amount;
                $data->date = Carbon::now();
                $data->requestId = $requestId;
                $data->user_id   = $user_id;
                $data->save();
                return Redirect::to($paymentUrl);
   
                }

            }
            else{
                $notification = array(
                    'message'  => 'Error Encountered,please try again later',
                    'alert-type'  => 'error'
                );
                return redirect()->back()->with($notification);

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

    public function startimesSubPurchase_pdf_Details(){
        
        $requestId =$_GET['requestId'];
        $user_id = startimesSuscriptionDetails::where('requestId',$requestId)->first()['user_id'];
        //get a request id from  to validate user payment
        $startimesDetails = startimesSuscriptionDetails::where('user_id',$user_id)->orderBy('id','desc')->first();

        $paymentRequestId = $startimesDetails->requestId;
     //get a merchant hash for authorization code
     $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

     //calling authorization API to get an authorization code for billers
     $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');
     $code = $response->header('Authorization-Code');

        //calling validate payment API
        $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/payment/validate', ['requestId' => $paymentRequestId ,]);

            if($response->status() == 200){
                $data = array();
                $data['message']  = $response['message'];
                $data['status']  = $response['data']['status'];
                $data['transactionReference']  = $response['data']['transactionReference'];
                $data['transactionDate']  = $response['data']['transactionDate'];
                DB::table('startimes_suscription_details')->where('requestId', $paymentRequestId)->update($data);
    
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
            $response = Http::withHeaders([
                'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
                'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
            ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
                'details' => [
                    'smartCardNumber' => $startimesDetails->smartCard,
                    'amount' => $startimesDetails->amount
               ],
                'id'                 => $request_id,
                'paymentCollectorId' => "CDL",
                'paymentMethod'      => 'PREPAID',
                'serviceId'          => 'AWA'
            ]);

            if($response->status()== 200){
                if($response['details']['status']== 'PENDING'){
                   
                    $id =startimesSuscriptionDetails::where('requestId',$paymentRequestId)->orderBy('id','desc')->first()['billerRequestId'];
                    //insert Biller Request Id here to prepaid table
                    if($id == null){
                        DB::table('startimes_suscription_details')->where('requestId',$paymentRequestId)->update(['billerRequestId' => $request_id]);
                    }
                //insert to pending_transaction table
                DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'smartCard'=>$startimesDetails->smartCard,'user_id' => $user_id]);
                $data = array();
                $data['status'] = $response['details']['status'];
                $data['exchangeReference'] = $response['details']['exchangeReference'];
                $data['transactionNumber'] = $response['transactionNumber'];
                $data['requestId'] = $request_id;
                $data['transactionDate'] = Carbon::now();
                $data['email'] = $startimesDetails->email;
                $data['customerName'] =$startimesDetails->name;
                $data['smartCard'] = $startimesDetails->smartCard;
                $data['amount'] = $startimesDetails->amount;
                $data['user_id'] = $user_id;
                DB::table('all_payment_histories')->insert($data);
                $notification = array(
                    'message'  => 'Your Transaction has been processing',
                    'alert-type'  => 'success'
                );
                return redirect()->route('dashboard')->with($notification);
                }
                elseif($response['details']['status']== 'ACCEPTED'){
                    $id =startimesSuscriptionDetails::where('requestId',$paymentRequestId)->orderBy('id','desc')->first()['billerRequestId'];
                    //insert Biller Request Id here to prepaid table
                    if($id == null){
                        DB::table('startimes_suscription_details')->where('requestId',$paymentRequestId)->update(['billerRequestId' => $request_id]);
                    }
                        $data = array();
                        $data['status'] = $response['details']['status'];
                        $data['date'] = Carbon::now();
                        $data['transactionNumber'] = $response['transactionNumber'];
                        $data['exchangeReference'] = $response['details']['exchangeReference'];
                        $data['returnMessage'] = $response['details']['returnMessage'];
                        $data['requestId'] = $request_id;
                        $data['email'] = $startimesDetails->email;
                        $data['customerName'] =$startimesDetails->name;
                        $data['smartCard'] = $startimesDetails->smartCard;
                        $data['amount'] = $startimesDetails->amount;
                        $data['user_id']         =     $user_id;
                        $data = DB::table('all_payment_histories')->insert($data);
                        $data = array();
                       $data['selectStartimes'] = AllPaymentHistory::where(['status' =>'ACCEPTED','user_id'=> $user_id])->orderBy('id','desc')->first();
                       return view('backend.startime.startime_accepted_details',$data);
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

    public function startimespdfDetails(){
        $user_id = Auth::user()->id;
        $data['pdf_details'] =AllPaymentHistory::where('user_id', $user_id)->orderBy('id','desc')->first();
        $pdf = PDF::loadView('backend.startime.startimes_pdf_details',$data);
    	$pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }
}
