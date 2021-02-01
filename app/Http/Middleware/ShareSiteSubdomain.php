<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class ShareSiteSubdomain
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

        view()->share('company_name', $request->route('company_name'));
        URL::defaults(['company_name' => $request->route('company_name')]);
        $route = $request->route();
        $route->forgetParameter('company_name');

        return $next($request);
    }
}
