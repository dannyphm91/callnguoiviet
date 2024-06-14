<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Traits\PaymentTrait;
use App\Models\Transaction;
use App\Notifications\MembershipUpgradeNotification;
use Illuminate\Http\Request;
use Modules\Currency\Entities\Currency;
use Modules\Plan\Entities\Plan;

class FreePlanPurchaseController extends Controller
{
    use PaymentTrait;

    /**
     * check user is authenticated
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * check user is authenticated
     *
     * @return void
     */
    public function purchaseFreePlan(Request $request)
    {
        $plan = Plan::findOrFail($request->plan);

        if ($plan->price == 0) {

            $user = auth()->user();

            // check free plan already buy
            $already_purchase = $this->checkAlreadyPurchase($plan, $user);
            if ($already_purchase) {
                flashWarning(__('you_have_purchased_this_free_plan_cant_buy_it_again'));

                return redirect()->back();
            }

            $this->cancelSubscriptionPlan();
            $this->userPlanInfoUpdate($plan, $user->id);
            $this->makeTransaction($plan);

            storePlanInformation();
            $this->forgetSessions();

            // create notification and send mail to customer
            if (checkMailConfig()) {
                $user = auth('user')->user();
                if (checkSetup('mail')) {
                    $user->notify(new MembershipUpgradeNotification($user, $plan->label));
                }
            }

            flashSuccess(__('plan_successfully_purchased'));

            return redirect()->route('frontend.plans-billing')->send();
        } else {
            flashWarning(__('its_not_a_free_plan'));

            return back();
        }
    }

    public function makeTransaction($plan = null, $amount = 0, $payment_type = 'subscription_based')
    {
        if (isset($plan) && isset($plan->price)) {
            $amount = $plan->price;
        }

        $fromRate = Currency::whereCode(config('templatecookie.currency'))->first()->rate;
        $toRate = Currency::whereCode('USD')->first()->rate;
        $rate = $fromRate / $toRate;

        return Transaction::create([
            'order_id' => uniqid(),
            'transaction_id' => uniqid('tr_'),
            'plan_id' => $plan->id,
            'user_id' => auth()->id(),
            'payment_provider' => 'offline',
            'amount' => $amount,
            'currency_symbol' => config('templatecookie.currency_symbol'),
            'usd_amount' => $amount * $rate,
            'payment_status' => 'paid',
        ]);
    }

    public function checkAlreadyPurchase(object $plan, object $user): bool
    {
        $order = Transaction::where('user_id', $user->id)->where('plan_id', $plan->id)->where('amount', 0)->first();
        if ($order) {
            return true;
        } else {
            return false;
        }
    }
}
