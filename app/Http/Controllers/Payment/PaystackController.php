<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Traits\PaymentTrait;
use Illuminate\Http\Request;

class PaystackController extends Controller
{
    use PaymentTrait;

    /**
     * Redirect the User to Paystack Payment Page
     *
     * @return Url
     */
    public function redirectToGateway(Request $request)
    {
        $plan = session('plan');
        $converted_amount = currencyConversion($plan->price);
        $amount = currencyConversion($plan->price, null, 'ZAR');

        session(['order_payment' => [
            'payment_provider' => 'paystack',
            'amount' => $amount,
            'currency_symbol' => '₦',
            'usd_amount' => $converted_amount,
        ]]);

        $secret_key = config('templatecookie.paystack_public_key');
        $curl = curl_init();
        $callback_url = route('paystack.success'); // url to go to after payment

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.paystack.co/transaction/initialize',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'amount' => $amount * 100,
                'email' => auth('user')->user()->email,
                'callback_url' => $callback_url,
            ]),
            CURLOPT_HTTPHEADER => [
                'authorization: Bearer '.$secret_key, //replace this with your own test key
                'content-type: application/json',
                'cache-control: no-cache',
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if ($err) {
            return redirect()->back()->with('error', $err);
        }

        $tranx = json_decode($response, true);
        if (! $tranx['status']) {
            return redirect()->back()->with('error', $tranx['message']);
        }

        return redirect($tranx['data']['authorization_url']);
    }

    /**
     * Obtain Paystack payment information
     *
     * @return void
     */
    public function successPaystack(Request $request)
    {
        if ($request['trxref'] === $request['reference']) {
            session(['transaction_id' => $request['reference'] ?? null]);

            $this->orderPlacing();
        }

        session()->flash('error', 'Something went wrong.');

        return back();
    }
}
