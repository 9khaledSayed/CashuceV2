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
        $company = $request->route('company') ?? '';
        view()->share('company', $request->route('company'));
        URL::defaults(['company' => $request->route('company')]);

        return $next($request);
    }
}
