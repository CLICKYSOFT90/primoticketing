<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class WebsiteAuth
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
        $isAuthenticatedAdmin = (Auth::guard('web')->check() && Auth::guard('web')->user()->id);

        //This will be excecuted if the new authentication fails.
        if (! $isAuthenticatedAdmin)
            return redirect(route('login_page',['url'=>$request->route()->parameters()['url']]));
        return $next($request);
        //return $next($request);
    }
}
