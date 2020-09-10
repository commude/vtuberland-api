<?php

namespace App\Http\Middleware;

use Closure;

class Paginate
{
    /**
     * Handle an incoming request.
     *
     * @OA\Schema(
     *  schema="links",
     *  @OA\Property(property="first", format="string", type="url", example="http://vtuberland.test/api/v1/spots?page=1"),
     *  @OA\Property(property="last", format="string", type="url", example="http://vtuberland.test/api/v1/spots?page=6"),
     *  @OA\Property(property="prev", format="string", type="url", example="http://vtuberland.test/api/v1/spots?page=1"),
     *  @OA\Property(property="next", format="string", type="url", example="http://vtuberland.test/api/v1/spots?page=3")
     * )
     *
     * @OA\Schema(
     *  schema="meta",
     *  @OA\Property(property="current_page", format="int64", type="integer", example="2"),
     *  @OA\Property(property="from", format="int64", type="integer", example="11"),
     *  @OA\Property(property="last_page", format="int64", type="integer", example="15"),
     *  @OA\Property(property="path", format="string", type="url", example="http://vtuberland.test/api/v1/spots"),
     *  @OA\Property(property="per_page", format="int64", type="integer", example="10"),
     *  @OA\Property(property="to", format="int64", type="integer", example="14"),
     *  @OA\Property(property="total", format="int64", type="integer", example="30")
     * )
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
