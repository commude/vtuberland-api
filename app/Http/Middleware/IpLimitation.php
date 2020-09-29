<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

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
            Log::error("Invalid IP address");
            return redirect()->route('home');
        }

        return $next($request);
    }
}