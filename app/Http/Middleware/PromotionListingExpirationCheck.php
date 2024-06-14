<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;

class PromotionListingExpirationCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $promotion_check_time = promotionCheckTime();
        if ($promotion_check_time->isToday()) {
            Artisan::call('promotion:check');
            forgetCache('promotion_check_time');
        }

        return $next($request);
    }
}
