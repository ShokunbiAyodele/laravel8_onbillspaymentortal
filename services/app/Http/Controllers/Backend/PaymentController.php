<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Prepaid;
use App\Models\Postpaid;
use App\Models\IbadanPrepaid;
use App\Models\AbujaPrepaid;
use App\Models\enuguPrepaid;
use App\Models\IbadanPostpaid;
use App\Models\PostpaidPaymentHistory;
use App\Models\AbujaPostPaid;
use App\Models\IkejaPrePaid;
use App\Models\enuguPostpaid;
use App\Models\pendingAcceptedTransaction;
use App\Models\newGotvSubValidate;
use App\Models\gotvSuscriptionDetails;
use App\Models\dstvSuscriptionDetails;
use App\Models\JosPrepaid;
use App\Models\AllPaymentHistory;
use App\Models\JosPostpaid;
use App\Models\IkejaPostpaid;
use App\Models\IbadanPrepaid_payment_histories;
use App\Models\IbadanPostpaid_payment_histories;
use App\Models\AbujaPostpaid_payment_histories;
use App\Models\AbujaPrepaid_payment_histories;
use App\Jobs\Heartbeat;
use Auth;
use Illuminate\Support\Facades\Http;
use DB;
use App\Models\KadunaPrePaid;


class PaymentController extends Controller
{
    public function makePrepaidPayment(Request $request){
        $requestId =$_GET['requestId'];
        $user_id = Prepaid::where('requestId',$requestId)->first()['user_id'] ;
        // dd($user_id);
       
        // $requestId =Prepaid::where('user_id',$user_id)->orderBy('id','desc')->first()['requestId'];
        
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

               
                    $data = Prepaid::where('requestId',$requestId)->orderBy('id','desc')->first();
                    $customerName = $data->customerName;
                    $customerAddress = $data->address;
                    $phoneNumber = $data->phoneNumber;
                    $customerDistrict = $data->customerDistrict;
                    $meterNumber = $data->meterNumber;
                    $amount = $data->amount;

            $response = Http::withHeaders([
                'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
                'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
            ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
                'details' => [
                'meterNumber'      => $meterNumber,
                'customerAddress'  => $customerAddress,
                'customerDistrict' => $customerDistrict,
                'customerName'     => $customerName,
                'amount'           =>  $amount
               ],
                'id'                 => $request_id,
                'paymentCollectorId' => "CDL",
                'paymentMethod'      => 'PREPAID',
                'serviceId'          => 'BAA'
            ]);
           if($response->status()== 200){
            if($response['details']['status']== 'PENDING'){
            $id =Prepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
              //insert Biller Request Id here to prepaid table
              if($id == null){
                DB::table('prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
            }

            //insert to pending_transaction table
            DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'phone'=> $phoneNumber, 'meterNumber'=>$meterNumber,'user_id' => $user_id]);
            $data = array();
            $data['status'] = $response['details']['status'];
            $data['requestId'] = $request_id;
            $data['customerName'] =$customerName;
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
             $id =Prepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
            //insert Biller Request Id here to prepaid table
            if($id == null){
                DB::table('prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
            }
                $data = array();
                $data['transactionNumber'] = $response['transactionNumber'];
                $data['standardTokenValue'] = $response['details']['standardTokenValue'];
                $data['debtAmount']  = $response['details']['debtAmount'];;
                $data['exchangeReference']  = $response['details']['exchangeReference'];
                $data['status']  = $response['details']['status'];
                $data['standardTokenAmount']  = $response['details']['standardTokenAmount'];
                $data['customerName']      =      $customerName;
                $data['customerName']      =      $meterNumber;
                $data['requestId']          =     $request_id;
                $data['user_id']          =     $user_id;
                $data = DB::table('all_payment_histories')->insert($data);
                $selectEkoPrepaid = AllPaymentHistory::where(['status' =>'ACCEPTED','user_id'=> $user_id,'requestId'=> $request_id])->orderBy('id','desc')->first();
                return view('backend.electricity.ekoElectricity_purchasepdf', compact('selectEkoPrepaid'));               
            }
            else{
                $notification = array(
                    'message'  => 'Request was Failed/Rejected',
                    'alert-type'  => 'error'
                );
                return redirect()->back()->with($notification);
            }
           }

        }

                
     }
        
    }

    public function pdfEkoPrepaid(){
        $user_id = Auth::user()->id;
        $data['pdf_details'] =AllPaymentHistory::where('user_id', $user_id)->orderBy('id','desc')->first();
        $pdf = PDF::loadView('backend.electricity.ekoprepaid_pdf',$data);
    	$pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');

    }

 
 
 //postpaid payment confirmation view

 public function makePostpaidPayment(Request $request){
    $requestId =$_GET['requestId'];
    $user_id = Postpaid::where('requestId',$requestId)->first()['user_id'];

    // $requestId =Postpaid::where('user_id',$user_id)->orderBy('id','desc')->first()['requestId'];

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

            DB::table('postpaids')->where('requestId',$requestId)->update($data);

            if($response['data']['status'] == "Failed"){
                $notification = array(
                    'message'    => 'Your Payment was not successfull',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with( $notification);
            }
            if($response['data']['status'] == "Success"){
                $data = Postpaid::where('user_id',$user_id)->orderBy('id','desc')->first();
                $accountNumber = $data->customerReference;
                $customerName = $data->customerName;
                $amount = $data->amount;
                $accountNumber = $data->customerReference;
                $phoneNumber = $data->phoneNumber;

                  //generate a request id for exchange
                  $request_id = (rand(1000, 9999));
             
        $response = Http::withHeaders([
            'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
            'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
            'details' => [
            'customerReference'      => $accountNumber,
            'amount'                 =>  $amount
           ],
            'id'                     => $request_id,
            'paymentCollectorId'     => "CDL",
            'paymentMethod'          => 'POSTPAID',
            'serviceId'               => 'AVA'
        ]);
       if($response->status()==200){
        $billerId = Postpaid::where('requestId',$requestId)->first()['billerRequestId'];
           if($response['details']['status']== 'PENDING'){
            //insert Biller Request Id here to pospaid table
           $id =postpaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
          if($id == null){
            DB::table('postpaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
        }
          //insert to pending_transaction table
          DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'accountNumber'=> $accountNumber, 'phone'=>$phoneNumber,'user_id' => $user_id]);
          $data = array();
          $data['status'] = $response['details']['status'];
          $data['requestId'] = $request_id;
          $data['customerName'] =$customerName;
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
            $id =Postpaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
            //insert Biller Request Id here to prepaid table
            if($id == null){
                DB::table('postpaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
            }
            $data = array();
            $data['transactionNumber'] = $response['transactionNumber'];
            $data['status'] = $response['details']['status'];
            $data['exchangeReference'] = $response['details']['exchangeReference'];
            $data['transactionStatus']  = $response['details']['transactionStatus'];
            $data['customerName']      =      $customerName;
            $data['accountNumber']      =      $accountNumber;
            $data['requestId']          =     $request_id;
            $data['user_id']          =     $user_id;
            $data = DB::table('all_payment_histories')->insert($data);
            $selectPostPaid =AllPaymentHistory::where(['status' =>'ACCEPTED','user_id'=> $user_id])->orderBy('id','desc')->first();
            return view('backend.postpaid.eko_postpaid_accepted', compact('selectPostPaid'));
               
        }
        else{
          $notification = array(
              'message'  => 'Request was rejected',
              'alert-type'  => 'error'
          );
          return redirect()->route('dashboard')->with($notification);
        }
           
         
       }
    
    }
            
 }

 }

 public function pdfEkoPostpaid(){
    $user_id = Auth::user()->id;
    $data['pdf_details'] =AllPaymentHistory::where('user_id', $user_id)->orderBy('id','desc')->first();
    $pdf = PDF::loadView('backend.electricity.postpaid.ekopostpaid_pdf',$data);
    $pdf->SetProtection(['copy', 'print'], '', 'pass');
    return $pdf->stream('document.pdf');
 }



public function getFinalResponseForBiller(){
    $UserId   = Auth::user()->id;
 $billerId = DB::table('pending_accepted_transactions')->select('requestId')->where(['status' => 'PENDING','user_id' => $UserId])->orderBy('id','desc')->first(); 
     //dd($billerId->billerRequestId,$billerId->phone);
     $response = Http::withHeaders([
        'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
        'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
    ])->post('http://132.145.231.191/vasb2b/dev/Api/query',[
       'id' =>$billerId->requestId,
    ]);
    $finalResponse = $response['details'];
    if($finalResponse['status'] == 'ACCEPTED' || $finalResponse['status'] == 'FAILED'){
        // $where[] = ['requestId','like',$year_id.'%'];
        DB::table('all_payment_histories')->where('requestId',$billerId->requestId)->update(['status' =>$finalResponse['status'],'status' =>$finalResponse['status'],'exchangeReference'=>$finalResponse['exchangeReference']]);
     }
      return response()->json($finalResponse);
}

public function dstvSubPurchaseConfirmPayment(Request $request){
    $requestId =$_GET['requestId'];
    $user_id = Postpaid::where('requestId',$requestId)->first()['user_id'] ;

    //get a request id from  to validate user payment
    $dstv_details = dstvSuscriptionDetails::where('user_id',$user_id)->orderBy('id','desc')->first();
    
    $paymentRequestId = $dstv_details->requestId;
 
     //get a merchant hash for authorization code
     $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

     //calling authorization API to get an authorization code for billers
     $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');
     $code = $response->header('Authorization-Code');

    //get the parameters and save to database and share token value with the user
    
    if($response->status() == 200){

          //calling validate payment API
     $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/payment/validate', ['requestId' => $paymentRequestId ,]);
        if($response->status() == 200){
            $data = array();
            $data['message']  = $response['message'];
            $data['status']  = $response['data']['status'];
            $data['transactionReference']  = $response['data']['transactionReference'];
            $data['transactionDate']  = $response['data']['transactionDate'];

            DB::table('dstv_suscription_details')->where('requestId', $paymentRequestId)->update($data);

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
                    $customerName = $dstv_details->firstName;
                    $smartCard = $dstv_details->smartCard;
                    $customerNumber = $dstv_details->customerNumber;
                    $amount = $dstv_details->amount;
                    $invoicePeriod = $dstv_details->invoicePeriod;
                    $productCode = $dstv_details->productCode;
                
                    
            $response = Http::withHeaders([
                'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
                'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
            ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
                'details' => [
                    'productsCodes' => [
                     $productCode
                    ],
                    'customerNumber'      => $customerNumber,
                    'smartcardNumber'          => $smartCard,
                    'invoicePeriod'      => $invoicePeriod,
                    'customerName'       => $customerName,
                    'amount'             =>  $amount
               ],
                'id'                 => $request_id,
                'paymentCollectorId' => "CDL",
                'paymentMethod'      => 'PREPAID',
                'serviceId'          => 'AQA'
            ]);
        
           if($response->status()== 200){
            if($response['details']['status']== 'PENDING'){
              
                $id =dstvSuscriptionDetails::where('requestId',$paymentRequestId)->orderBy('id','desc')->first()['billerRequestId'];
                //insert Biller Request Id here to prepaid table
                if($id == null){
                    DB::table('dstv_suscription_details')->where('requestId',$paymentRequestId)->update(['billerRequestId' => $request_id]);
                }
            //insert to pending_transaction table
            DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'smartCard'=>$smartCard,'user_id' => $user_id]);
            $data = array();
            $data['status'] = $response['details']['status'];
            $data['requestId'] = $request_id;
            $data['customerName'] =$customerName;
            $data['accountNumber'] =$customerNumber;
            $data['smartCard'] = $smartCard;
            $data['amount'] = $amount;
            $data['user_id'] = $user_id;
            DB::table('dstv_transaction_histories')->insert($data);
            $notification = array(
                'message'  => 'Your Transaction has been processing',
                'alert-type'  => 'success'
            );
            return redirect()->route('dashboard')->with($notification);
            }
            elseif($response['details']['status']== 'ACCEPTED'){
                $id =dstvSuscriptionDetails::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
                //insert Biller Request Id here to prepaid table
                if($id == null){
                    DB::table('dstv_transaction_histories')->where('requestId',$requestId)->update(['billerRequestId' => $request_id,'user_id' => $user_id]);
                }
                    $data = array();
                    $data['accountNumber'] = $accountNumber;
                    $data['amount'] = $amount;
                    $data['smartCard'] = $smartCard;
                     $data['customerCareReferenceId'] =  $response['details']['customerCareReferenceId'];;
                     $data['exchangeReference']  =  $response['details']['exchangeReference'];
                     $data['auditReferenceNumber']  =  $response['details']['auditReferenceNumber'];
                     $data['status']  = $response['details']['status'];
                    $data['customerName']      =   $customerName;
                    $data['requestId']         =     $request_id;
                    $data['user_id']         =     $user_id;
   
                    $data = DB::table('dstv_transaction_histories')->insert($data);

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
    else{
        $notification = array(
            'message'  => 'Problem Encountered, please try again later',
            'alert-type'  => 'error'
        );
        return redirect()->back()->with($notification);

    }

  
}

}
