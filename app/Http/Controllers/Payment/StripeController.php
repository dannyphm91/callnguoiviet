<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Traits\PaymentTrait;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Stripe;

class StripeController extends Controller
{
    use PaymentTrait;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $plan = session('plan');
        $converted_amount = currencyConversion($plan->price);

        session(['order_payment' => [
            'payment_provider' => 'stripe',
            'amount' => $converted_amount,
            'currency_symbol' => '$',
            'usd_amount' => $converted_amount,
        ]]);

        try {
            Stripe::setApiKey(config('templatecookie.stripe_secret'));

            $charge = Charge::create([
                'amount' => session('stripe_amount'),
                'currency' => 'USD',
                'source' => $request->stripeToken,
                'description' => 'Payment for '.$plan->label.' plan'.' in '.config('app.name'),
            ]);

            session(['transaction_id' => $charge->id ?? null]);
            $this->orderPlacing();
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
