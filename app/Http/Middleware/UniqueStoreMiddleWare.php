<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class UniqueStoreMiddleWare
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
        //dd(Config::all());
        $route_param = (!empty($request->route()->parameters()['url'])) ? $request->route()->parameters()['url'] : "";
        if($route_param==""){
            return redirect(url(""));
        }

       // dd($route_param);
       // dd($route_param['url']);
        return $next($request,$route_param = $request->route()->parameters()['url']);
    }
}
