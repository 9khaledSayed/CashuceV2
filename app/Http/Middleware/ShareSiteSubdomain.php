<?php

namespace App\Http\Middleware;

use Closure;

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

        return $next($request);
    }
}
