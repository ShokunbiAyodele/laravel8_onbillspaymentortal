<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Http;
use Auth;
use App\Models\User;
use App\Models\newGotvSubValidate;
use App\Models\newDSTVSubValidate;
use App\Models\gotvSuscriptionDetails;
use App\Models\dstvSuscriptionDetails;
use App\Models\dstvaddonsproduct;
use App\Models\AllPaymentHistory;
use Carbon\Carbon;
use DB;
use PDF;

class MultichoiceController extends Controller
{
    public function gotvdetailsView(){

        $response = Http::withHeaders([
            'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
            'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        ])->post('http://132.145.231.191/vasb2b/dev/Api/proxy',[
            'details' => ['requestType' => 'FIND_STANDALONE_PRODUCTS',
        ],
            'serviceId' => 'AQC'
        ]);

        $gotvDetails = $response['details']['items'];
          foreach($gotvDetails as $gotv){
         $Product = newGotvSubValidate::where('code',$gotv['code'])->orderBy('id')->first();
         if($Product == null){
                $data =new newGotvSubValidate();
                $data->code = $gotv['code'];
                $data->price = $gotv['availablePricingOptions'][0]['price'];
                $data->date = Carbon::now();
                $data->name = $gotv['name'];
                $data->description = $gotv['description'];
                $data->save();
             }
          }

        return view('backend.multichoice.gotv_sub.gotv_sub_view',compact('gotvDetails'));
    }
    public function gotvGetProductAmount(Request $request){
        $Product = newGotvSubValidate::where('code',$request->productsCode)->first()['price'];
        return response()->json($Product);
    }

    public function gotvSubPurchase(Request $request){
        $user_id = Auth::user()->id;
        $smartCard = $request->smartCard;
        $productsCode = $request->productsCode;
        $amount = $request->amount;
        $mobileNumber = $request->phone;
        //get gotvsub package id
        $new_sub = newGotvSubValidate::where('code',$productsCode)->first();
     

         //insert a phone in users table
        $phone = User::where('id',$user_id)->first()['phone'];
        if($phone == null){
            User:: where('id',$user_id)->update(['phone' => $mobileNumber]);
        }
       
        // $data = array(
        //     'smartCard' => $smartCard,
        //     'productsCode' => $request->productsCode,
        //     'amount'  => $amount,
        //     'phone' => $mobileNumber,
        // );
        // dd($data);

         //validate smartCard Number//
          $response = Http::withHeaders([
            'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
            'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        ])->post('http://132.145.231.191/vasb2b/dev/Api/proxy',[
            'details' => ['number' => $smartCard,
            'requestType' => 'VALIDATE_DEVICE_NUMBER',
        ],
            'serviceId' => 'AQC'
        ]);

        if($response->status() == 200){
            $firstName = $response['details']['firstName'];
            $lastName = $response['details']['lastName'];
            $invoicePeriod = $response['details']['invoicePeriod'];
            $customerNumber = $response['details']['customerNumber'];
            $dueDate = $response['details']['dueDate'];

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
             $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$userEmailAddress"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/gotv/purchase/pdf_details");

              //call a create payment Api
              $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
                'amount'        => $amount,
                'custName'      => $firstName,
                'custEmail'     => $userEmailAddress,
                'currency'      => 'NGN',
                'phoneNumber'   =>   $mobileNumber,
                'callbackUrl'   =>  'http://localhost/Ebill/services/public/gotv/purchase/pdf_details',
                'hash'          =>  $TRANSACTION_HASH,
                'requestId'     =>  $requestId,
                'narration'     =>  'Payment for'. $new_sub->name.' susbscription',]);
             if($response->status() == 200){
                $paymentUrl = $response->header('Payment-Url');
                //insert customer details into prepaid table
                $data = new gotvSuscriptionDetails();
                $data->firstName = $firstName;
                $data->lastName = $lastName;
                $data->smartCard = $smartCard;
                $data->email = $userEmailAddress;
                $data->phone = $mobileNumber;
                $data->invoicePeriod = $invoicePeriod;
                $data->customerNumber = $customerNumber;
                $data->productsCode = $productsCode;
                $data->dueDate = $dueDate;
                $data->gotv_sub_val_id =$new_sub->id;
                $data->amount = $amount;
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


    public function gotvSubPurchase_pdf_Details(){
        // $user_id = Auth::user()->id;
        $requestId =$_GET['requestId'];
        $user_id = gotvSuscriptionDetails::where('requestId',$requestId)->first()['user_id'] ;
        
          //get a request id from  to validate user payment
    $gotv_details = gotvSuscriptionDetails::where('user_id',$user_id)->orderBy('id','desc')->first();
    
    $paymentRequestId = $gotv_details->requestId;
    
     //get a merchant hash for authorization code
     $MERCHANT_HASH = hash("sha512","BILLSPAY|y2FBE9XaSWg7eneH7BahtwraNs3VNXWraHjKBVgKTg7puyLkSE|".date('Y-m-d'));

     //calling authorization API to get an authorization code for billers
     $response = Http::withOptions(['verify' => false,])->withToken('BILLSPAY'.' '.$MERCHANT_HASH)->get('https://v2napi.com/VASPay/authorization');
     $code = $response->header('Authorization-Code');
  
    //get the parameters and save to database and share token value with the user

    //calling validate payment API
     $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/payment/validate', ['requestId' => $paymentRequestId ,]);
        if($response->status() == 200){
            $data = array();
            $data['message']  = $response['message'];
            $data['status']  = $response['data']['status'];
            $data['transactionReference']  = $response['data']['transactionReference'];
            $data['transactionDate']  = $response['data']['transactionDate'];

            DB::table('gotv_suscription_details')->where('requestId', $paymentRequestId)->update($data);

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
                    $customerName = $gotv_details->firstName;
                    $smartCard = $gotv_details->smartCard;
                    $customerNumber = $gotv_details->customerNumber;
                    $amount = $gotv_details->amount;
                    $email = $gotv_details->email;
                    $invoicePeriod = $gotv_details->invoicePeriod;
                    $productCode = $gotv_details->productCode;
                
                    
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
                'serviceId'          => 'AQC'
            ]);
           if($response->status()== 200){
            if($response['details']['status']== 'PENDING'){
               
                $id =gotvSuscriptionDetails::where('requestId',$paymentRequestId)->orderBy('id','desc')->first()['billerRequestId'];
                //insert Biller Request Id here to prepaid table
                if($id == null){
                    DB::table('gotv_suscription_details')->where('requestId',$paymentRequestId)->update(['billerRequestId' => $request_id]);
                }
            //insert to pending_transaction table
            DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'smartCard'=>$smartCard,'user_id' => $user_id]);
            $data = array();
            $data['status'] = $response['details']['status'];
            $data['requestId'] = $request_id;
            $data['customerName'] =$customerName;
            $data['accountNumber'] =$customerNumber;
            $data['smartCard'] = $smartCard;
            $data['email'] = $email;
            $data['date'] = Carbon::now();
            $data['amount'] = $amount;
            $data['user_id'] = $user_id;
            DB::table('all_payment_histories')->insert($data);
            $notification = array(
                'message'  => 'Your Transaction has been processing',
                'alert-type'  => 'success'
            );
            return redirect()->route('dashboard')->with($notification);
            }
            elseif($response['details']['status']== 'ACCEPTED'){
                $id =gotvSuscriptionDetails::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
                //insert Biller Request Id here to prepaid table
                if($id == null){
                    DB::table('gotv_suscription_details')->where('requestId',$requestId)->update(['billerRequestId' => $request_id,'user_id' => $user_id]);
                }
                    $data = array();
                    $data['accountNumber'] = $customerNumber;
                    $data['amount'] = $amount;
                    $data['smartCard'] = $smartCard;
                     $data['exchangeReference']  =  $response['details']['exchangeReference'];
                     $data['status']  = $response['details']['status'];
                    $data['customerName']      =   $customerName;
                    $data['email'] = $email;
                    $data['date'] = Carbon::now();
                    $data['requestId']         =     $request_id;
                    $data['user_id']         =     $user_id;
                    $data = DB::table('all_payment_histories')->insert($data);
                    $selectgotvsyb = AllPaymentHistory::where(['status' =>'ACCEPTED','user_id'=> $user_id])->orderBy('id','desc')->first();
                    return view('backend.multichoice.gotv_sub.gotv_pdf_sub_details', compact('selectgotvsyb'));
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
    else{
        $notification = array(
            'message'  => 'Problem Encountered, please try again later',
            'alert-type'  => 'error'
        );
        return redirect()->back()->with($notification);
    }
        
    }


    public function gotv_getpdfdetaails(){
        $user_id = Auth::user()->id;
        $data['pdf_details'] =AllPaymentHistory::where('user_id', $user_id)->orderBy('id','desc')->first();
        $pdf = PDF::loadView('backend.multichoice.gotv_sub.gotvsb_pdf',$data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }


    //DSTV FUNCTION HERE
    public function  dstvdetailsView(){
        $response = Http::withHeaders([
            'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
            'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        ])->post('http://132.145.231.191/vasb2b/dev/Api/proxy',[
            'details' => ['requestType' => 'FIND_STANDALONE_PRODUCTS',
        ],
            'serviceId' => 'AQA'
        ]);
    
        if($response->status() == 200){
            $DstvDetails = $response['details']['items'];
            // dd($DstvDetails);
        
            foreach($DstvDetails as $eachDstv){
                //  dd($DstvDetails);
                $Product = newDSTVSubValidate::where('code',$eachDstv['code'])->orderBy('id')->first();
                if($Product == null){
                       $data =new newDSTVSubValidate();
                       $data->code = $eachDstv['code'];
                       $data->price = $eachDstv['availablePricingOptions'][0]['price'];
                       $data->date = Carbon::now();
                       $data->name = $eachDstv['name'];
                       $data->description = $eachDstv['description'];
                       $data->save();
                    }
                 }
               
                 return view('backend.multichoice.dstv_subscription.dstv_sub_view',compact('DstvDetails'));
        }
    }

    public function dstvGetProductAmount(Request $request){
        // $Product = newDSTVSubValidate::select('price')->where('code',$request->code)->first();
        $price = DB::table('new_d_s_t_v_sub_validates')->where('code',$request->productsCode )->value('price');
        return response()->json($price);

    }

    
    public function dstvSubPurchase(Request $request){
        $user_id = Auth::user()->id;
        $smartCard = $request->smartCard;
        $productsCode = $request->productsCode;
        $productCode = $request->productCode;
        $amount = $request->amount;
        $other_amount = $request->other_amount;
      
       
        $mobileNumber = $request->phone;

        $amount =($amount != null) ? $amount : $other_amount;
        $productsCode =($productsCode != null) ? $productsCode : $productCode;
      
             //get gotvsub package id
        $new_sub = newDSTVSubValidate::where('code',$productsCode)->first();
         //insert a phone in users table
        $phone = User::where('id',$user_id)->first()['phone'];
        if($phone == null){
            User:: where('id',$user_id)->update(['phone' => $mobileNumber]);
        }
       
        // $data = array(
        //     'smartCard' => $smartCard,
        //     'productsCode' => $request->productsCode,
        //     'amount'  => $amount,
        //     'phone' => $mobileNumber,
        // );
        // dd($data);

         //validate smartCard Number//
          $response = Http::withHeaders([
            'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
            'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        ])->post('http://132.145.231.191/vasb2b/dev/Api/proxy',[
            'details' => ['number' => $smartCard,
            'requestType' => 'VALIDATE_DEVICE_NUMBER',
        ],
            'serviceId' => 'AQA'
        ]);
        if($response->status() == 200){
            $firstName = $response['details']['firstName'];
            $lastName = $response['details']['lastName'];
            $invoicePeriod = $response['details']['invoicePeriod'];
            $customerNumber = $response['details']['customerNumber'];

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
             $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$userEmailAddress"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/dstv/purchase/pdf_details");

              //call a create payment Api
              $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
                'amount'        => $amount,
                'custName'      => $firstName,
                'custEmail'     => $userEmailAddress,
                'currency'      => 'NGN',
                'phoneNumber'   =>   $mobileNumber,
                'callbackUrl'   =>  'http://localhost/Ebill/services/public/dstv/purchase/pdf_details',
                'hash'          =>  $TRANSACTION_HASH,
                'requestId'     =>  $requestId,
                'narration'     =>  'Payment for'. $new_sub->name.' susbscription',]);
             if($response->status() == 200){
                $paymentUrl = $response->header('Payment-Url');
                //insert customer details into prepaid table
                $data = new dstvSuscriptionDetails();
                $data->firstName = $firstName;
                $data->lastName = $lastName;
                $data->smartCard = $smartCard;
                $data->email = $userEmailAddress;
                $data->phone = $mobileNumber;
                $data->invoicePeriod = $invoicePeriod;
                $data->customerNumber = $customerNumber;
                $data->productsCode = $productsCode;
                $data->dstv_sub_val_id =$new_sub->id;
                $data->amount = $amount;
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

    public function dstvSubPurchase_pdf_Details(){
        $requestId =$_GET['requestId'];
        $user_id = dstvSuscriptionDetails::where('requestId',$requestId)->first()['user_id'] ;
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
                    $email = $dstv_details->email;
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
            $data['email'] = $email;
            $data['date'] = Carbon::now();
            $data['amount'] = $amount;
            $data['user_id'] = $user_id;
            DB::table('all_payment_histories')->insert($data);
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
                     $data['exchangeReference']  =  $response['details']['exchangeReference'];
                     $data['status']  = $response['details']['status'];
                    $data['customerName']      =   $customerName;
                    $data['email'] = $email;
                    $data['requestId']         =     $request_id;
                    $data['date']         =     Carbon::now();
                    $data['user_id']         =     $user_id;
                    $data = DB::table('all_payment_histories')->insert($data);
                    $selectdstvSub = AllPaymentHistory::where(['status' =>'ACCEPTED','user_id'=> $user_id])->orderBy('id','desc')->first();
                    return view('backend.multihoice.dstv_subscription.dstv_pdf_sub_details', compact('selectdstvSub'));
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

    public function dstvSubgetpdf(){
        $user_id = Auth::user()->id;
        $data['pdf_details'] =AllPaymentHistory::where('user_id', $user_id)->orderBy('id','desc')->first();
        $pdf = PDF::loadView('backend.multihoice.dstv_subscription.dstvsub_pdf',$data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');

    }


    //get add on Package for dstv function
    public function dstv_getaddOnPackage(Request $request){
        $response = Http::withHeaders([
            'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
            'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        ])->post('http://132.145.231.191/vasb2b/dev/Api/proxy',[
            'details' => [
                'primaryProductCode' => $request->ProductAddons,
                'requestType' => 'FIND_PRODUCT_ADDONS',
        ],
            'serviceId' => 'AQA'
        ]);
        $productPackage = $response['details']['items'];
        foreach($productPackage as $addonsproduct){
            $product = newDSTVSubValidate::where('code',$addonsproduct['code'])->orderBy('id')->first();
            if($product == null){
                   $data =new newDSTVSubValidate();
                   $data->code = $addonsproduct['code'];
                   $data->price = $addonsproduct['availablePricingOptions'][0]['price'];
                   $data->date = Carbon::now();
                   $data->name = $addonsproduct['name'];
                   $data->description = $addonsproduct['description'];
                   $data->save();
                }
        }
        return response()->json($productPackage);
    }

    public function dstvGetPackageAmount(Request $request){
        $price = DB::table('dstvaddonsproducts')->where('code',$request->amountcode )->value('price');
        return response()->json($price);

    }
}
