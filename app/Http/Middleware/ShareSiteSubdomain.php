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

        view()->share('company', $request->route('company'));
        URL::defaults(['company' => $request->route('company')]);
        $route = $request->route();
        $route->forgetParameter('company');

        return $next($request);
    }
}
