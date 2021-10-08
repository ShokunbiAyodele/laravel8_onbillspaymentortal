<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\IbadanPrepaid;
use App\Models\IbadanPostpaid;
use App\Models\AllPaymentHistory;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Redirect;
use Auth;
use DB;
use PDF;

class IbadanDiscoController extends Controller
{
    public function ibadanDiscoView(){
        return view('backend.electricity.ibadan_disco.ibadan_disco_view');
    }

    public function ibadanDiscoBuyToken(Request $request){
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
            'details' => ['customerReference' => $meterNumber],
            'serviceId' => 'AUB'
        ]);

        if($response->status() == 200 &  $response['details']['customerReference'] == true){
            $firstName = $response['details']['firstName'];
            $customerType = $response['details']['customerType'];
            $meterNumber = $response['details']['customerReference'];
            $lastName = $response['details']['lastName'];

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
             $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$userEmailAddress"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/ibadan_prepaid/make/payment");

              //call a create payment Api
              $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
                'amount'        => $amount,
                'custName'      => $customerName,
                'custEmail'     => $userEmailAddress,
                'currency'      => 'NGN',
                'phoneNumber'   =>   $mobileNumber,
                'callbackUrl'   =>  'http://localhost/Ebill/services/public/ibadan_prepaid/make/payment',
                'hash'          =>  $TRANSACTION_HASH,
                'requestId'     =>  $requestId,
                'narration'     =>  'Payment for Ibadan Disco prepaid',]);

             if($response->status() == 200){
                $paymentUrl = $response->header('Payment-Url');
                //insert customer details into prepaid table
                $data = new IbadanPrepaid();
                $data->firstName = $firstName;
                $data->lastName = $lastName;
                $data->phone = $mobileNumber;
                $data->customerType =  $customerType;
                $data->meterNumber = $meterNumber;
                $data->phone = $mobileNumber;
                $data->amount = $amount;
                $data->email = $userEmailAddress;
                $data->date = Carbon::now();
                $data->requestId = $requestId;
                $data->user_id   = $user_id;
                $data->save();
                return Redirect::to($paymentUrl);
   
                }

            }
        }
        else{
            dd('Authorization failled and redirect back');
        }
    }

 
    public function  ibadanPrepaidPayment(){
        $requestId =$_GET['requestId'];
        $user_id = IbadanPrepaid::where('requestId',$requestId)->first()['user_id'];

        // $requestId =IbadanPrepaid::where('user_id',$user_id)->orderBy('id','desc')->first()['requestId'];

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

            DB::table('ibadan_prepaids')->where('requestId',$requestId)->update($data);

            if($response['data']['status'] == "Failed"){
                $notification = array(
                    'message'    => 'Your Payment was not successfull',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with( $notification);
            }
           
            if($response['data']['status'] == "Success"){
                  //generate a request id for exchange
                  $request_id = (rand(1000, 9999));

                $data = IbadanPrepaid::where('user_id',$user_id)->orderBy('id','desc')->first();
                $firstName = $data->firstName;
                $lastName = $data->lastName;
                $email = $data->email;
                $meterNumber = $data->meterNumber;
                $customerType = $data->customerType;
                $phoneNumber = $data->phone;
                $thirdPatyCode = $data->thirdPatyCode;
                $amount = $data->amount;

        $response = Http::withHeaders([
            'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
            'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
        ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
            'details' => [
            'customerReference'      =>$meterNumber,
            'customerType'  => 'PREPAID',
            'customerName'     => $firstName .' '. $lastName,
            'thirdPartyCode'     => $thirdPatyCode,
            'amount'           =>  $amount
           ],
            'id'                 => $request_id,
            'paymentCollectorId' => "CDL",
            'paymentMethod'      => 'PREPAID',
            'serviceId'          => 'AUB'
        ]);
     
       if($response->status()== 200){
        // dd($response->json());
        $billerId = IbadanPrepaid::where('requestId',$requestId)->first()['billerRequestId'];
        if($response['details']['status']== 'PENDING'){
            $id =IbadanPrepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
            //insert Biller Request Id here to prepaid table
            if($id == null){
                DB::table('ibadan_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
            }
             //insert to pending_transaction table
             DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'phone'=> $phoneNumber, 'meterNumber'=>$meterNumber,'user_id' => $user_id]);
             $data = array();
             $data['status'] = $response['details']['status'];
             $data['requestId'] = $request_id;
             $data['customerName'] =$firstName.''. $lastName;
             $data['user_id'] = $user_id;
             $data['meterNumber']  = $meterNumber;
             $data['email']  = $email;
             $data['transactionNumber'] = $response['transactionNumber'];
              DB::table('all_payment_histories')->insert($data);
             $notification = array(
                 'message'  => 'Your Transaction has been processing',
                 'alert-type'  => 'success'
             );
             return redirect()->route('dashboard')->with($notification);
        }
        elseif($response['details']['status']== 'ACCEPTED'){
            $id = IbadanPrepaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];
             //insert Biller Request Id here to prepaid table
           if($id == null){
            DB::table('ibadan_prepaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
        }
            $data = array();
            $data['transactionNumber'] = $response['transactionNumber'];
            $data['exchangeReference']  =  $response['details']['exchangeReference'];
            $data['token']  = $response['details']['token'];
            $data['meterNumber']  = $meterNumber;
            $data['status']  = $response['details']['status'];
            $data['customerName']      =      $firstName .' '.  $lastName;
            $data['requestId']         =     $request_id;
            $data['email']         =     $email;
            $data['user_id']         =     $user_id;
            $data = DB::table('all_payment_histories')->insert($data);
            $selectIbadanPrepaid = AllPaymentHistory::where(['status' =>'ACCEPTED','user_id'=> $user_id])->orderBy('id','desc')->first();
            return view('backend.electricity.ibadan_disco.ibadanprepaid_pdf', compact('selectIbadanPrepaid'));
  
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
    public function ibadan_prepaidpdf(){
        $user_id = Auth::user()->id;
        $data['pdf_details'] =AllPaymentHistory::where('user_id', $user_id)->orderBy('id','desc')->first();
        $pdf = PDF::loadView('backend.electricity.ibadan_disco.prepaid_pdf',$data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }


    //Ibadan postpaid function 
    public function ibadanDiscoPostpaidView(){
        return view('backend.electricity.ibadan_disco.ibadan_postpaid.ibadan_postpaid_view');
    }

    public function ibadanDiscoPostpaidBuy(Request $request){
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
                'details' => ['customerReference' =>  $accountNumber ],
                'serviceId' => 'AUA'
            ]);
          
            if($response->status() == 200 &  $response['details']['customerReference'] == true){
                $firstName = $response['details']['firstName'];
    
                $explodeFistName = explode(' ',$firstName);
        
                $firstName =$explodeFistName[0];
                $lastName = $explodeFistName[1];
                $thirdPartyCode = $response['details']['thirdPartyCode'];
                $customerType = $response['details']['customerType'];
                $accountNumber = $response['details']['customerReference'];
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
             $TRANSACTION_HASH = hash("sha512","BILLSPAY|".$requestId."|"."$userEmailAddress"."|".$amount."|NGN|".$mobileNumber."|http://localhost/Ebill/services/public/ibadan_postpaid/make/payment");


                 //call a create payment Api
                 $response = Http::withOptions(['verify' => false,])->withHeaders(['Authorization'=> $code,])->post('https://v2napi.com/VASPay/account/pay',[
                    'amount'        => $amount,
                    'custName'      => $firstName,
                    'custEmail'     => $userEmailAddress,
                    'currency'      => 'NGN',
                    'phoneNumber'   =>   $mobileNumber,
                    'callbackUrl'   =>  'http://localhost/Ebill/services/public/ibadan_postpaid/make/payment',
                    'hash'          =>  $TRANSACTION_HASH,
                    'requestId'     =>  $requestId,
                    'narration'     =>  'Payment for Ibadan Disco postpaid',]);

                    if($response->status() == 200){
                        $paymentUrl = $response->header('Payment-Url');
                        //insert customer details into prepaid table
                        $data = new IbadanPostpaid();
                        $data->firstName = $firstName;
                        $data->lastName = $lastName;
                        $data->customerType =  $customerType;
                        $data->thirdPartyCode =  $thirdPartyCode;
                        $data->customerReference = $accountNumber;
                        $data->phone = $mobileNumber;
                        $data->email = $userEmailAddress;
                        $data->amount = $amount;
                        $data->date = Carbon::now();
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

    public function ibadanPostpaidPayment(){
        $requestId =$_GET['requestId'];
        $user_id = IbadanPostpaid::where('requestId',$requestId)->first()['user_id'];

        // $requestId =IbadanPostpaid::where('user_id',$user_id)->orderBy('id','desc')->first()['requestId'];

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

        DB::table('ibadan_prepaids')->where('requestId',$requestId)->update($data);

        if($response['data']['status'] == "Failed"){
            $notification = array(
                'message'    => 'Your Payment was not successfull',
                'alert-type' => 'error'
            );
            return redirect()->back()->with( $notification);
        }
        if($response['data']['status'] == "Success"){
            //generate a request id for exchange
            $request_id = (rand(1000, 9999));

          $data = IbadanPostpaid::where('user_id',$user_id)->orderBy('id','desc')->first();
          $firstName = $data->firstName;
          $lastName = $data->lastName;
          $email = $data->email;
          $accountNumber = $data->customerReference;
          $customerType = $data->customerType;
          $thirdPatyCode = $data->thirdPatyCode;
          $phoneNumber = $data->phone;
          $amount = $data->amount;

  $response = Http::withHeaders([
      'MAC' => '632b046efead2c90494545b4c0a526d7e7545ca65ec6494119cd10dba8eb387b',
      'CLIENT_CODE' => 'CAPRI-DWTH8PYN9N3F',
  ])->post('http://132.145.231.191/vasb2b/dev/Api/exchange',[
      'details' => [
      'customerReference'      => $accountNumber,
      'customerType'  => $customerType,
      'customerName'     => $firstName .' '.$lastName,
      'thirdPartyCode'     => $thirdPatyCode,
      'amount'           =>  $amount
     ],
      'id'                 => $request_id,
      'paymentCollectorId' => "CDL",
      'paymentMethod'      => 'POSTPAID',
      'serviceId'          => 'AUA'
  ]);

 if($response->status()== 200){
  // dd($response->json());
  $billerId = IbadanPostpaid::where('requestId',$requestId)->first()['billerRequestId'];
  if($response['details']['status']== 'PENDING'){
    $id =IbadanPostpaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];

    if($id == null){
        DB::table('ibadan_postpaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
    }
     //insert to pending_transaction table
     DB::table('pending_accepted_transactions')->insert(['status' => $response['details']['status'], 'requestId'=>$request_id, 'phone'=> $phoneNumber, 'accountNumber'=>$accountNumber,'user_id' => $user_id]);
     $data = array();
     $data['status'] = $response['details']['status'];
     $data['requestId'] = $request_id;
     $data['customerName'] =$customerName;
     $data['accountNumber'] = $accountNumber;
     $data['user_id'] = $user_id;
     $data['email'] =$email;
     $data['date'] =Carbon::now();
     $data['transactionNumber'] = $response['transactionNumber'];
      DB::table('all_payment_histories')->insert($data);
     $notification = array(
         'message'  => 'Your Transaction has been processing',
         'alert-type'  => 'success'
     );
     return redirect()->route('dashboard')->with($notification);
  }
  elseif($response['details']['status']== 'ACCEPTED'){
    $id =IbadanPostpaid::where('requestId',$requestId)->orderBy('id','desc')->first()['billerRequestId'];

    if($id == null){
        DB::table('ibadan_postpaids')->where('requestId',$requestId)->update(['billerRequestId' => $request_id]);
    }
    $data = array();
    $data['transactionNumber'] = $response['transactionNumber'];
    $data['amount'] = $amount;
    $data['customerName'] = $firstName .' '. $lastName;
    $data['exchangeReference'] = $response['details']['exchangeReference'];
    $data['status'] = $response['details']['status'];
    $data['requestId'] = $request_id;
    $data['date'] =Carbon::now();
    $data['email'] =$email;
    $data['accountNumber'] = $accountNumber;
    $data['user_id'] = $user_id;
    $data = DB::table('all_payment_histories')->insert($data);
    $selectPostpaid = AllPaymentHistory::where(['status' =>'ACCEPTED','user_id'=> $user_id])->orderBy('id','desc')->first();
    return view('backend.electricity.ibadan_disco.ibadan_postpaid.postpaid_accepted', compact('selectPostpaid'));

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


    public function ibadan_postpaidpdf(){
        $user_id = Auth::user()->id;
        $data['pdf_details'] =AllPaymentHistory::where('user_id', $user_id)->orderBy('id','desc')->first();
        $pdf = PDF::loadView('backend.electricity.ibadan_disco.ibadan_postpaid.postpaid_pdf',$data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }
}
