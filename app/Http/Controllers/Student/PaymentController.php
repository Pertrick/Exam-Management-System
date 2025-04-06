<?php

namespace App\Http\Controllers\Student;

use Paystack;
use App\Models\Payment;
use App\Models\AccessPin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_payments = auth()->user()->payments()->with('accessPin')->latest()->paginate(12);
        $sn = 1;
        return view('student.payment.index', compact('user_payments', 'sn'));
    }

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        try {
            $amount = config('paystack.amount') * 100; 
            $data = array(
                "amount" => $amount,
                "reference" => Str::random(7) . '_' . uniqid("paystack"),
                "email" => auth()->user()->email,
                "currency" => "NGN",
            );
            return Paystack::getAuthorizationUrl($data)->redirectNow();
        } catch (\Exception $e) {
            return redirect()->back()->withError(['msg' => 'The paystack token has expired. Please refresh the page and try again.', 'type' => 'error']);
        }
    }



    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        if ($paymentDetails['status'] == 'success') {
            $authorizationCode = $paymentDetails['data']['authorization']['authorization_code'];
            $amount = $paymentDetails['data']['amount'] / 100;  // Convert from kobo to Naira (or the smallest currency unit)
            $currency = $paymentDetails['data']['currency'];


            $accessPin = AccessPin::where('status',0)->whereNull('used_by')->whereNull('used_on')->first();


            // Now, store the payment information
            auth()->user()->payments()->create([
                'currency' => $currency,
                'amount' => $amount,
                'payment_method' => 'Paystack',
                'reference_no' => $paymentDetails['data']['reference'],
                'transaction_id' => $paymentDetails['data']['reference'],
                'status' => Payment::STATUS_SUCCESS,
                'access_pin_id' => $accessPin->id,
                'paid_at' => now(),
            ]);

            // Optionally, you can send the user to a success page
            return redirect()->route('student.payment.index')->with('success', 'Payment successful! Your transaction ID is: ' . $paymentDetails['data']['reference']);
        } else {
            
            auth()->user()->payments()->create([
                'currency' => $paymentDetails['data']['currency'],
                'amount' => $paymentDetails['data']['amount'] / 100,
                'payment_method' => 'Paystack',
                'reference_no' => $paymentDetails['data']['reference'],
                'transaction_id' => $paymentDetails['data']['reference'],
                'status' => Payment::STATUS_FAILED,
                'paid_at' => now(),
            ]);
    
            Log::error('Payment failed', [
                'user_id' => auth()->id(),
                'payment_details' => $paymentDetails,
            ]);
            return redirect()->route('student.subject.index')->with('error','Payment failed! Please try again.');
        }
    }

    public function success()
    {
        $details = auth()->user()->successPaymentpayments()->latest()->first();
        return view('student.payment.success', compact('details'));
    }

    public function failed()
    {
        return view('student.payment.failed');
    }
}
