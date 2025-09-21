<?php

namespace App\Http\Middleware;

use Closure;
use redirect;
use Illuminate\Support\Facades\Auth;

class validateLoggedInUser
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
            return redirect('dashboard')->with('success','You are already logged in');
        }
        else 
        {
            return $next($request);
        }

        return $next($request);
    }
}
