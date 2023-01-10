<?php

namespace App\Services;

use App\Models\Payment;

class PaymentService
{
    /**
     * Initialize Payment
     * 
     */
    public function initializePayment()
    {
        $email = auth()->user()->email;
        $curl = curl_init();
        $amount = env('AMOUNT');
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.paystack.co/transaction/initialize',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "email": "' . $email .'",
            "amount": "'.$amount.'",
            "callback_url" : "' .env('APP_URL').'/student/payment"
        }',
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer '.env('PAYSTACK_SK_KEY')
          ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);

        $decoded_response = json_decode($response);
        return $decoded_response;
        
    }


    /**
     * store transaction
     */

     public function storeTransaction(){
        $transaction_response = $this->initializePayment();
        if(!$transaction_response->status){
            return false;
        }

        $payment  = new Payment();
        $payment->user_id = auth()->user()->id;
        $payment->reference_no = $transaction_response->data->reference;
        $payment->amount = env('AMOUNT');
        $payment->status = 'success';
        if($payment->save()){
            return $transaction_response;
        }
      
     }
}
