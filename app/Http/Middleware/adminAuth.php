<?php

namespace App\Http\Middleware;

use Closure;
use redirect;
use Illuminate\Support\Facades\Auth;

class adminAuth
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
        if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->status=='1') {
            return $next($request);
        } else {
            return redirect('admin/auth')->with('error_message','Please login to proceed');
        }

        return $next($request);
    }
}
