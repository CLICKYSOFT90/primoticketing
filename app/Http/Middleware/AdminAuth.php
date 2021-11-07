<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth
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
        $isAuthenticatedAdmin = (Auth::guard('admin')->check() && Auth::guard('admin')->user()->id  && Auth::guard('admin')->user()->active) ;
        //This will be excecuted if the new authentication fails.
        if (! $isAuthenticatedAdmin)
            return redirect(route('admin.login'));
        return $next($request);
        //return $next($request);
    }
}
