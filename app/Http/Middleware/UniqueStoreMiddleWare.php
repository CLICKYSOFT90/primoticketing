<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

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
        if(Organization::where('organization_unique_url',$route_param)->where('active',1)->count() == 0){
            return redirect(url(""));
        }
        Session::put('selected_organization',$route_param );

       // dd($route_param);
       // dd($route_param['url']);
        return $next($request,$route_param = $request->route()->parameters()['url']);
    }
}
