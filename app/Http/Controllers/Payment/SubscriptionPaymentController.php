<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Traits\PaymentTrait;
use Illuminate\Http\Request;
use Modules\Plan\Entities\Plan;

class SubscriptionPaymentController extends Controller
{
    use PaymentTrait;

    public function subscribePlan(Request $request)
    {
        $validator = validator($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            flashError('Payment token is required');

            return back()->withErrors($validator)->withInput();
        }

        $plan = Plan::find($request->plan_id);

        $request->user()->newSubscription('default', $plan->stripe_id)->create($request->token);

        flashSuccess($plan->label.' plan subscribed successfully');

        return to_route('frontend.plans-billing');
    }

    public function cancelSubscribePlan(Request $request)
    {
        $this->authorize('cancel', $request->user()->subscription('default'));

        $subscription = $request->user()->subscription('default');

        if ($subscription) {
            $subscription->cancel();
        }

        flashSuccess('Subscription cancelled');

        return back();
    }

    public function resumeSubscribePlan(Request $request)
    {
        $this->authorize('resume', $request->user()->subscription('default'));

        $subscription = $request->user()->subscription('default');

        if ($subscription) {
            $subscription->resume();
        }

        flashSuccess('Subscription resumed');

        return back();
    }
}
