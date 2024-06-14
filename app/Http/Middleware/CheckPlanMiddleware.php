<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPlanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // dump(session('user_plan'));

        if ($userPlan = session('user_plan')) {
            if ((int) $userPlan->ad_limit < 1) {
                session()->forget('user_plan');
                session()->put('user_plan', auth('user')->user()->userPlan);

                flashError('You have reached your listing limit. Please upgrade your plan to continue.');

                return redirect()->route('frontend.dashboard');
            }

            return $next($request);
        }

        session()->put('user_plan', auth('user')->user()->userPlan);

        flashError("You don't have any active plan. Please upgrade your plan to continue.");

        return redirect()->route('frontend.priceplan');
    }
}
