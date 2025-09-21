<?php

namespace App\Http\Middleware;

use Closure;
use redirect;
use Illuminate\Support\Facades\Auth;

class userAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->user_type=='U') {
            return $next($request);
        } else {
            return redirect('login')->with('error','Please login to proceed');
        }

        return $next($request);
    }
}
