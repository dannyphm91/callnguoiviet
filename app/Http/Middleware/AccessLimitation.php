<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccessLimitation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // if (auth('admin')->user()->email !== 'developer@mail.com') {
        //     session()->flash('error', 'This action is disabled for demo');

        //     return redirect()->back();
        // }

        return $next($request);
    }
}
