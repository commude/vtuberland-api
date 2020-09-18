<?php

namespace App\Http\Middleware;

use Closure;

class IpLimitation
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
        $whitelist = config('app.adminwhitelist');
        $ipAddresses = explode(';', $whitelist);

        if(!in_array($request->ip(), $ipAddresses)) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}