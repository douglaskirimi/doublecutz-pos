<?php

namespace App\Http\Controllers\payments\mpesa;

use App\Http\Controllers\payments\mpesa\MPESAResponsesController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use App\Models\MpesaPayments;

class MpesaTransactionsController extends Controller
{
        public function generateAccessToken()
    {
        $consumer_key=env('MPESA_CONSUMER_KEY');
        $consumer_secret=env('MPESA_CONSUMER_SECRET');
        $credentials = base64_encode(env('MPESA_CONSUMER_KEY').":".env('MPESA_CONSUMER_SECRET'));
        // dd($credentials);
        $url = env('ACCESS_TOKEN_SANDBOX_URL');
        $curl = curl_init();

        if (curl_errno($curl)) { 
            print curl_error($curl); 
        } 
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials));
        curl_setopt($curl, CURLOPT_HEADER,0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $data=json_decode(curl_exec($curl));
        $access_token = $data->access_token;
        // dd($access_token);
        curl_close($curl);
        return $access_token;  
    }
        public function lipaNaMpesaPassword()
    {
        $lipa_time = Carbon::rawParse('now')->format('YmdHms');
        $BusinessShortCode = env('MPESA_STK_SHORTCODE');
        $passkey = env('MPESA_PASSKEY');
        $timestamp =$lipa_time;
        $lipa_na_mpesa_password = base64_encode($BusinessShortCode.$passkey.$timestamp);
    }

public function stkPush(Request $request) {
    // dd($request);
    $phone = ltrim($request->mpesa_number,0);
    $customer_payment_number = '254' . $phone;
    $service_fees = $request->service_fees;
    $data = $request;

    $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateAccessToken()));
    $curl_post_data = [
        //Fill in the request parameters with valid values
        'BusinessShortCode' => 174379,
        'Password' => $this->lipaNaMpesaPassword(),
        'Timestamp' => Carbon::rawParse('now')->format('YmdHms'),
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => '1',
        'PartyA' => '254758319193', //$customer_payment_number, // replace this with your phone number
        'PartyB' => 174379,
        'PhoneNumber' => '0758319193', // replace this with your phone number
        'CallBackURL' => 'https://kinyozi-point-of-sale.herokuapp.com/api/responses',
        'AccountReference' => "The Glitters Barbershop",
        'TransactionDesc' => "Testing stk push on sandbox"
    ];

    $data_string = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $curl_response = curl_exec($curl);      
    $stkPullResponse = json_decode($curl_response);
    dd($stkPullResponse);
    $stkResCode  = $stkPullResponse->ResponseCode;


    if ($stkResCode == 0) {
    Log::info($stkPullResponse->CustomerMessage);
    // return view('pages.transactions.completeTransaction',compact('data'))->with('data',$data);
    return redirect()->route('payment.complete')->with('data',$data);
}
       else{
        } 
        return redirect()->action([TransactionController::class, 'new_transaction']);
}

 public function mpesaRes(Request $request) {
// die("");
       $response =json_decode($request->getContent(),true);
        $Item = $response['Body']['stkCallback']['CallbackMetadata']['Item'];
        $metadata = array(
            'MerchantRequestID' => $response['Body']['stkCallback']['MerchantRequestID'],
            'CheckoutRequestID' => $response['Body']['stkCallback']['CheckoutRequestID'],
            'ResultCode' => $response['Body']['stkCallback']['ResultCode'],
            'ResultDesc' => $response['Body']['stkCallback']['ResultDesc'],
        );
    
        $mpesaData = array_column($Item, 'Value', 'Name');
        $mpesaData = array_merge($metadata, $mpesaData);
        
        if($mpesaData['ResultCode']==0) {
            $newTransaction = new MpesaPayments;   
        
            $newTransaction->MerchantRequestID = $mpesaData['MerchantRequestID'];
            $newTransaction->CheckoutRequestID = $mpesaData['CheckoutRequestID'];
            $newTransaction->ResultCode = $mpesaData['ResultCode'];
            $newTransaction->ResultDesc = $mpesaData['ResultDesc'];
            $newTransaction->Amount = $mpesaData['Amount'];
            $newTransaction->MpesaReceiptNumber = $mpesaData['MpesaReceiptNumber'].rand(0,9999);            
            $newTransaction->Status = "Success";

           $transaction_date = $mpesaData['TransactionDate'];
           $formatedDateTime = date("Y-m-d", strtotime($transaction_date)); 

            $newTransaction->TransactionDate = $formatedDateTime;

            // die($newTransaction->TransactionDate);
            $newTransaction->PhoneNumber = $mpesaData['PhoneNumber'];
           $m = $newTransaction->save();
        
            if($m==1) {
              Log::info("Transaction completed successfully!");
              return response()->json($mpesaData);
            }
            else{
               Log::info("Error");
            }
    
        }
        elseif($mpesaData['ResultCode']==1) {
            Log::info("Error Occurred. Try again!");
            return   response()->json(array('feedback'=>'Transaction failed! We are sorry, try again!'));
        }
    return response()->json("retry!");
}
    }
