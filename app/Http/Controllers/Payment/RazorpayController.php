<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Traits\PaymentTrait;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    use PaymentTrait;

    public function payment(Request $request)
    {
        $plan = session('plan');
        $converted_amount = currencyConversion($plan->price);
        $amount = currencyConversion($plan->price, null, 'INR', 1);

        session(['order_payment' => [
            'payment_provider' => 'razorpay',
            'amount' => $amount,
            'currency_symbol' => '₹',
            'usd_amount' => $converted_amount,
        ]]);

        $input = $request->all();
        $api = new Api(config('templatecookie.razorpay_key'), config('templatecookie.razorpay_secret'));

        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if (count($input) && ! empty($input['razorpay_payment_id'])) {
            try {
                $payment->capture(['amount' => $payment['amount']]);

                session(['transaction_id' => $input['razorpay_payment_id'] ?? null]);
                $this->orderPlacing();
            } catch (\Exception $e) {
                return $e->getMessage();
                session()->put('error', $e->getMessage());

                return redirect()->back();
            }
        }
    }
}
