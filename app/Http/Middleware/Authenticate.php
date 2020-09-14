<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function adminRedirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('admin.login');
        }
    }

        /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        if (collect($guards)->contains('admin')) {
            throw new AuthenticationException('Unauthenticated.', $guards, $this->adminRedirectTo($request));
        }

        if (collect($guards)->contains('user')) {
            throw new AuthenticationException('Unauthenticated.', $guards, $this->adminRedirectTo($request));
        }

        throw new AuthenticationException('Unauthenticated.', $guards, $this->redirectTo($request));
    }
}
