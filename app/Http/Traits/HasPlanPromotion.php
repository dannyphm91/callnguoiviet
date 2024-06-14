<?php

namespace App\Http\Traits;

use App\Models\UserPlan;

trait HasPlanPromotion
{
    public function promotePlan($request, $ad, $user_id)
    {
        $user_plan_data = UserPlan::where('user_id', $user_id)->first();
        $plan = $user_plan_data->currentPlan;
        $current_date = now();

        $ad->featured = $request->featured ? $request->featured : 0;
        if ($request->featured) {
            if ($plan->featured_duration < 1) {
                $expire_date = now()->addYears(20);
            } else {
                $expire_date = now()->addDays($plan->featured_duration);
            }

            $ad->featured_at = $current_date;
            $ad->featured_till = $expire_date;
        }

        $ad->urgent = $request->urgent ? $request->urgent : 0;
        if ($request->urgent) {
            if ($plan->urgent_duration < 1) {
                $expire_date = now()->addYears(20);
            } else {
                $expire_date = now()->addDays($plan->urgent_duration);
            }

            $ad->urgent_at = $current_date;
            $ad->urgent_till = $expire_date;
        }

        $ad->highlight = $request->highlight ? $request->highlight : 0;
        if ($request->highlight) {
            if ($plan->highlight_duration < 1) {
                $expire_date = now()->addYears(20);
            } else {
                $expire_date = now()->addDays($plan->highlight_duration);
            }

            $ad->highlight_at = $current_date;
            $ad->highlight_till = $expire_date;
        }

        $ad->top = $request->top ? $request->top : 0;
        if ($request->top) {
            if ($plan->top_duration < 1) {
                $expire_date = now()->addYears(20);
            } else {
                $expire_date = now()->addDays($plan->top_duration);
            }

            $ad->top_at = $current_date;
            $ad->top_till = $expire_date;
        }

        $ad->bump_up = $request->bump_up ? $request->bump_up : 0;
        if ($request->bump_up) {
            if ($plan->bump_up_duration < 1) {
                $expire_date = now()->addYears(20);
            } else {
                $expire_date = now()->addDays($plan->bump_up_duration);
            }

            $ad->bump_up_at = $current_date;
            $ad->bump_up_till = $expire_date;
        }

        return $ad;
    }
}
