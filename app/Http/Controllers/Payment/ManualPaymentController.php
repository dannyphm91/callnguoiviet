<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Traits\PaymentTrait;
use App\Models\ManualPayment;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\MembershipUpgradeNotification;
use Illuminate\Http\Request;
use Modules\Plan\Entities\Plan;

class ManualPaymentController extends Controller
{
    use PaymentTrait;

    public function paymentPlace(Request $request)
    {
        $plan = session('plan');
        $price = $plan->price;
        $usd_amount = currencyConversion($price);
        $payment = ManualPayment::findOrFail($request->payment_id);

        if (session('payperads')) {
            // Transaction create
            Transaction::create([
                'order_id' => rand(1000, 999999999),
                'transaction_id' => uniqid('tr_'),
                'plan_id' => $plan->id,
                'user_id' => auth('user')->id(),
                'payment_provider' => 'offline',
                'amount' => $price,
                'currency_symbol' => config('templatecookie.currency_symbol'),
                'usd_amount' => $usd_amount,
                'payment_status' => 'unpaid',
                'manual_payment_id' => $payment->id,
            ]);

            return $this->storeAdsData();
        } else {
            // Transaction create
            Transaction::create([
                'order_id' => rand(1000, 999999999),
                'transaction_id' => uniqid('tr_'),
                'plan_id' => $plan->id,
                'user_id' => auth('user')->id(),
                'payment_provider' => 'offline',
                'amount' => $price,
                'currency_symbol' => config('templatecookie.currency_symbol'),
                'usd_amount' => $usd_amount,
                'payment_status' => 'unpaid',
                'manual_payment_id' => $payment->id,
            ]);
        }
        // forget sessions
        $this->forgetSessions();

        // redirect to customer billing
        session()->flash('success', 'Payment is placed waiting for approval');

        return redirect()->route('frontend.plans-billing')->send();
    }

    public function markPaid(Transaction $order)
    {
        $order->update(['payment_status' => 'paid']);
        $plan = Plan::findOrFail($order->plan_id);

        // Plan benefit attach to user
        $this->userPlanInfoUpdate($plan, $order->user_id);

        // create notification and send mail to customer
        if (checkMailConfig()) {
            $user = User::findOrFail($order->user_id);
            if (checkSetup('mail')) {
                $user->notify(new MembershipUpgradeNotification($user, $plan->label));
            }
        }

        session()->flash('success', 'Payment marked as paid.');

        return back();
    }

    public function walletPaymentPlace(Request $request)
    {
        // plan and user affiliate
        $plan = session('plan');
        $user_affiliate = authUser()?->affiliate;
        $wallet_balance = $user_affiliate?->balance ?? 0;

        // price and usd amount
        $price = $plan->price;
        $usd_amount = currencyConversion($price);

        // check wallet balance and redirect back
        if (! $user_affiliate || $wallet_balance < $price) {
            session()->flash('error', "You don't have enough balance in your wallet to purchase this plan.");

            return back();
        }

        // Transaction create
        $order = Transaction::create([
            'order_id' => rand(1000, 999999999),
            'transaction_id' => uniqid('tr_'),
            'plan_id' => $plan->id,
            'user_id' => auth('user')->id(),
            'payment_provider' => 'wallet_balance',
            'amount' => $price,
            'currency_symbol' => config('templatecookie.currency_symbol'),
            'usd_amount' => $usd_amount,
            'payment_status' => 'paid',
        ]);

        // Plan benefit attach to user
        $this->userPlanInfoUpdate($plan, $order->user_id);

        // update affiliate balance
        $user_affiliate->update(['balance' => $wallet_balance - $price]);

        // create notification and send mail to customer
        if (checkMailConfig()) {
            $user = User::findOrFail($order->user_id);
            if (checkSetup('mail')) {
                $user->notify(new MembershipUpgradeNotification($user, $plan->label));
            }
        }

        // forget sessions
        $this->forgetSessions();

        // redirect to customer billing
        session()->flash('success', 'Payment is placed successfully from your wallet balance.');

        return redirect()->route('frontend.plans-billing')->send();
    }
}
