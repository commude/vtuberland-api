<?php

namespace App\Http\Middleware;

use Closure;

class Paginate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $perPage = (int) $request->query('per_page', 10);
        if ($perPage < 1) {
            $perPage = 10;
        }
        $request->query->set('per_page', $perPage);

        $order = $request->query('order');
        if ($order != 'desc') {
            $order = 'asc';
        }
        $request->query->set('order', $order);

        return $next($request);
    }
}
