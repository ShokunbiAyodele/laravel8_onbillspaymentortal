<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Auth;
use App\Models\User;
use App\Models\startimesSuscriptionDetails;
use App\Models\startimestransactionHistory;
use App\Models\smilesRecharge;  
use App\Models\SmileBundlePackage;  
use App\Models\SmileBundle;
use App\Models\smilesrechargestransaction_histories; 
use App\Models\smilesBundletransaction_histories; 
use Carbon\Carbon;
use Redirect;
use PDF;
use DB;

class SmillesController extends Controller
{
    public function smilesDetailsView(){
        return view('backend.smiles_recharge.smiles_recharge_purchase');

    }

    public function smilesSubPurchase(Request $request){

            $user_id = Auth::user()->id;
            $accountId = $request->accountId;
            $amount = $request->amount;
            $mobileNumber = $request->phone;
          
             //insert a phone in users table
            $phone = User::where('id',$user_id)->first()['phone'];
            if($phone == null){
                User:: where('id',$user_id)->update(['phone' => $mobileNumber]);
            }
           
            // $data = array(
            //     'accountId' => $accountId,
            //     'amount'  => $amount,
            //     'phone' => $mobileNumber,
            // );
            // dd($data);
    
             //validate smartCard Number//
              $response = Http::withHeaders([
                'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
                'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
            ])->post('http://132.145.231.191/vasb2b/dev/Api/proxy',[
                'details' => ['customerAccountId' => $accountId,
                               'requestType' => 'VALIDATE_ACCOUNT',
            ],
                'serviceId' => 'ANA'
            ]);
    
            if($response->status() == 200){
                $firstName = $response['details']['firstName'];
                $lastName = $response['details']['lastName'];
                $middleName = $response['details']['middleName'];
    
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
                 $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$user->email"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/smiles_recharge/purchase");
    
                  //call a create payment Api
                  $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
                    'amount'        => $amount,
                    'custName'      => $user->name,
                    'custEmail'     => $user->email,
                    'currency'      => 'NGN',
                    'phoneNumber'   =>   $mobileNumber,
                    'callbackUrl'   =>  'http://localhost/Ebill/services/public/smiles_recharge/purchase',
                    'hash'          =>  $TRANSACTION_HASH,
                    'requestId'     =>  $requestId,
                    'narration'     =>  'Payment for startimes susbscription',]);
                   
                 if($response->status() == 200){
                    $paymentUrl = $response->header('Payment-Url');
                    //insert customer details into prepaid table
                    $data = new smilesRecharge();
                    $data->name = $firstName . ' '.$middleName .' '. $lastName;
                    $data->accountId = $accountId;
                    $data->email =  $user->email;
                    $data->phone = $mobileNumber;
                    $data->amount = $amount;
                    $data->date_created = Carbon::now();
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

    public function smilesRechargePayment(){
        $requestId =$_GET['requestId'];
        $user_id = smilesRecharge::where('requestId',$requestId)->first()['user_id'];
        //get a request id from  to validate user payment
        $smilesRechargesDetails = smilesRecharge::where('user_id',$user_id)->orderBy('id','desc')->first();

        $paymentRequestId = $smilesRechargesDetails->requestId;
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
                DB::table('smiles_recharges')->where('requestId', $paymentRequestId)->update($data);

                
                if($response['data']['status'] == "Failed"){
                  
                    $notification = array(
                        'message'    => 'Your Payment was not successfull',
                        'alert-type' => 'error'
                    );
                    return redirect()->route('dashboard')->with( $notification);
                }
                if($response['data']['status'] == 'Success'){
                    $counter++;
                  
                 //generate a request id for exchange
            $request_id = (rand(1000, 9999));  
                
            $response = Http::withHeaders([
                'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
                'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
            ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
                'details' => [
                    'customerAccountId' => $smilesRechargesDetails->accountId,
                    'amount' => $smilesRechargesDetails->amount
               ],
                'id'                 => $request_id,
                'paymentCollectorId' => "CDL",
                'paymentMethod'      => 'PREPAID',
                'serviceId'          => 'ANA'
            ]);

            if($response->status()== 200){
                if($response['details']['status']== 'PENDING'){
                   
                    $id =smilesRecharge::where('requestId',$paymentRequestId)->orderBy('id','desc')->first()['billerRequestId'];
                    //insert Biller Request Id here to prepaid table
                    if($id == null){
                        DB::table('smiles_recharges')->where('requestId',$paymentRequestId)->update(['billerRequestId' => $request_id]);
                    }
                //insert to pending_transaction table
                DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'smartCard'=>$smilesRechargesDetails->accountId,'user_id' => $user_id]);
                $data = array();
                $data['status'] = $response['details']['status'];
                $data['transactionNumber'] = $response['transactionNumber'];
                $data['requestId'] = $request_id;
                $data['transactionDate'] = Carbon::now();
                $data['email'] = $smilesRechargesDetails->email;
                $data['customerName'] =$smilesRechargesDetails->name;
                $data['accountId'] = $smilesRechargesDetails->accountId;
                $data['amount'] = $smilesRechargesDetails->amount;
                $data['user_id'] = $user_id;
                DB::table('smilesrechargestransaction_histories')->insert($data);
                $notification = array(
                    'message'  => 'Your Transaction has been processing',
                    'alert-type'  => 'success'
                );
                return redirect()->route('dashboard')->with($notification);
                }
                elseif($response['details']['status']== 'ACCEPTED'){
                    $counter = 1;
                    $id =smilesRecharge::where('requestId',$paymentRequestId)->orderBy('id','desc')->first()['billerRequestId'];
                    //insert Biller Request Id here to prepaid table
                    if($id == null){
                        DB::table('smiles_recharges')->where('requestId',$paymentRequestId)->update(['billerRequestId' => $request_id]);
                    }
                        $data = array();
                        $data['status'] = $response['details']['status'];
                        $data['transactionDate'] = Carbon::now();
                        $data['transactionNumber'] = $response['transactionNumber'];
                        $data['exchangeReference'] = $response['details']['exchangeReference'];
                        $data['requestId'] = $request_id;
                        $data['email'] = $smilesRechargesDetails->email;
                        $data['customerName'] =$smilesRechargesDetails->name;
                        $data['accountId'] = $smilesRechargesDetails->accountId;
                        $data['amount'] = $smilesRechargesDetails->amount;
                        $data['user_id']         =     $user_id;
                       DB::table('smilesrechargestransaction_histories')->insert($data);

                          
                       $selectsmiles = smilesrechargestransaction_histories::where(['status' =>'ACCEPTED','user_id'=> $user_id])->orderBy('id','desc')->first();
                       return view('backend.smiles_recharge.smiles_recharge_purchasepdf', compact('selectsmiles'));
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

    public function smilesRechargepdfDetails(){
        $user_id = Auth::user()->id;

        $data['pdf_details'] =smilesrechargestransaction_histories::where('user_id', $user_id)->orderBy('id','desc')->first();
        $pdf = PDF::loadView('backend.smiles_recharge.smiles_rechargepdf_details',$data);
    	$pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }


    public function smilesBundleDetailsView(){
        return view('backend.smiles_bundle.smiles_bundle_purchase');

    }

    public function smilesBundlegetPackage(Request $request){
        //get smiles bundle package
        $response = Http::withHeaders([
            'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
            'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        ])->post('http://132.145.231.191/vasb2b/dev/Api/proxy',[
            'details' => ['customerAccountId' => $request->accountId,
                           'requestType' => 'GET_BUNDLES',
        ],
            'serviceId' => 'ANB'
        ]);

        $responsedetails = $response['details']['bundles'];

        foreach($responsedetails as $bundlesmile){
            $bundle =  SmileBundlePackage::where(['typeCode' =>$bundlesmile['typeCode']])->orderBy('id','desc')->first();
            if($bundle == null){
                $data = new SmileBundlePackage();
                $data->typeCode = $bundlesmile['typeCode'];
                $data->amount = $bundlesmile['amount'];
                $data->date = Carbon::now();
                $data->description = $bundlesmile['description'];
                $data->save();
            }
        }   
        return response()->json($responsedetails);
    }




    public function smilesBundleSubPurchase(Request $request){

        $user_id = Auth::user()->id;
        $accountId = $request->accountId;
        $amount = $request->amount;
        $mobileNumber = $request->phone;
      
         //insert a phone in users table
        $phone = User::where('id',$user_id)->first()['phone'];
        if($phone == null){
            User:: where('id',$user_id)->update(['phone' => $mobileNumber]);
        }
       
        // $data = array(
        //     'accountId' => $accountId,
        //     'amount'  => $amount,
        //     'phone' => $mobileNumber,
        // );
        // dd($data);

         //validate smartCard Number//
          $response = Http::withHeaders([
            'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
            'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        ])->post('http://132.145.231.191/vasb2b/dev/Api/proxy',[
            'details' => ['customerAccountId' => $accountId,
                           'requestType' => 'VALIDATE_ACCOUNT',
        ],
            'serviceId' => 'ANB'
        ]);
        if($response->status() == 200){
            $firstName = $response['details']['firstName'];
            $lastName = $response['details']['lastName'];
            $middleName = $response['details']['middleName'];

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
             $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$user->email"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/smiles_bundle/purchase");

              //call a create payment Api
              $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
                'amount'        => $amount,
                'custName'      => $user->name,
                'custEmail'     => $user->email,
                'currency'      => 'NGN',
                'phoneNumber'   =>   $mobileNumber,
                'callbackUrl'   =>  'http://localhost/Ebill/services/public/smiles_bundle/purchase',
                'hash'          =>  $TRANSACTION_HASH,
                'requestId'     =>  $requestId,
                'narration'     =>  'Payment for startimes susbscription',]);
               
             if($response->status() == 200){
                $paymentUrl = $response->header('Payment-Url');
                //insert customer details into prepaid table
                $data = new SmileBundle();
                $data->name = $firstName . ' '.$middleName .' '. $lastName;
                $data->accountId = $accountId;
                $data->email =  $user->email;
                $data->mobileNumber = $mobileNumber;
                $data->amount = $amount;
                $data->date_created = Carbon::now();
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

    public function smilesBundlePayment(){
       
        $requestId =$_GET['requestId'];
        $user_id = SmileBundle::where('requestId',$requestId)->first()['user_id'];
         //get a request id from  to validate user payment
         $smilesBundleDetails = SmileBundle::where('user_id',$user_id)->orderBy('id','desc')->first();
 
         $paymentRequestId = $smilesBundleDetails->requestId;
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
                 DB::table('smiles_recharges')->where('requestId', $paymentRequestId)->update($data);
 
                 
                 if($response['data']['status'] == "Failed"){
                   
                     $notification = array(
                         'message'    => 'Your Payment was not successfull',
                         'alert-type' => 'error'
                     );
                     return redirect()->route('dashboard')->with( $notification);
                 }
                 if($response['data']['status'] == 'Success'){
                     $counter++;
                   
                  //generate a request id for exchange
             $request_id = (rand(1000, 9999));  
                 
             $response = Http::withHeaders([
                 'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
                 'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
             ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
                 'details' => [
                     'customerAccountId' => $smilesBundleDetails->accountId,
                     'amount' => $smilesBundleDetails->amount
                ],
                 'id'                 => $request_id,
                 'paymentCollectorId' => "CDL",
                 'paymentMethod'      => 'PREPAID',
                 'serviceId'          => 'ANA'
             ]);
 
             if($response->status()== 200){
                 if($response['details']['status']== 'PENDING'){
                    
                     $id =SmileBundle::where('requestId',$paymentRequestId)->orderBy('id','desc')->first()['billerRequestId'];
                     //insert Biller Request Id here to prepaid table
                     if($id == null){
                         DB::table('smile_bundles')->where('requestId',$paymentRequestId)->update(['billerRequestId' => $request_id]);
                     }
                 //insert to pending_transaction table
                 DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'smartCard'=>$smilesBundleDetails->accountId,'user_id' => $user_id]);
                 $data = array();
                 $data['status'] = $response['details']['status'];
                 $data['transactionNumber'] = $response['transactionNumber'];
                 $data['requestId'] = $request_id;
                 $data['transactionDate'] = Carbon::now();
                 $data['email'] = $smilesBundleDetails->email;
                 $data['customerName'] =$smilesBundleDetails->name;
                 $data['accountId'] = $smilesBundleDetails->accountId;
                 $data['amount'] = $smilesBundleDetails->amount;
                 $data['user_id'] = $user_id;
                 DB::table('smiles_bundletransaction_histories')->insert($data);
                 $notification = array(
                     'message'  => 'Your Transaction has been processing',
                     'alert-type'  => 'success'
                 );
                 return redirect()->route('dashboard')->with($notification);
                 }
                 elseif($response['details']['status']== 'ACCEPTED'){
                     $counter = 1;
                     $id =SmileBundle::where('requestId',$paymentRequestId)->orderBy('id','desc')->first()['billerRequestId'];
                     //insert Biller Request Id here to prepaid table
                     if($id == null){
                         DB::table('smile_bundles')->where('requestId',$paymentRequestId)->update(['billerRequestId' => $request_id]);
                     }
                         $data = array();
                         $data['status'] = $response['details']['status'];
                         $data['transactionDate'] = Carbon::now();
                         $data['transactionNumber'] = $response['transactionNumber'];
                         $data['exchangeReference'] = $response['details']['exchangeReference'];
                         $data['requestId'] = $request_id;
                         $data['email'] = $smilesBundleDetails->email;
                         $data['customerName'] =$smilesBundleDetails->name;
                         $data['accountId'] = $smilesBundleDetails->accountId;
                         $data['amount'] = $smilesBundleDetails->amount;
                         $data['user_id']         =     $user_id;
                        DB::table('smiles_bundletransaction_histories')->insert($data);
                        $selectsmilesBundle = smilesBundletransaction_histories::where(['status' =>'ACCEPTED','user_id'=> $user_id])->orderBy('id','desc')->first();
                        return view('backend.smiles_bundle.smiles_bundle_purchasepdf', compact('selectsmilesBundle'));
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
     

     public function smilesBundlepdfDetails(){
        $user_id = Auth::user()->id;

        $data['pdf_details'] =smilesBundletransaction_histories::where('user_id', $user_id)->orderBy('id','desc')->first();
        $pdf = PDF::loadView('backend.smiles_bundle.smiles_bundlepdf_details',$data);
    	$pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');

     }
}
