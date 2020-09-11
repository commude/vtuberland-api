<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = [
        'user' => [
            'api' => 'App\Http\Controllers\User\Api',
            'web' => 'App\Http\Controllers\User\Web'
        ],
        'admin' => [
            'api' => 'App\Http\Controllers\Admin\Api',
            'web' => 'App\Http\Controllers\Admin\Web'
        ]
    ];

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = [
        'user' => '/home',
        'admin' => '/admin'
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapUserApiRoutes();
        $this->mapUserWebRoutes();

        $this->mapAdminApiRoutes();
        $this->mapAdminWebRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapUserWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace['user']['web'])
            ->group(base_path('routes/user-web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapUserApiRoutes()
    {
        $version = config('app.api_version');
        Route::prefix("api/{$version}")
            ->middleware('api')
            ->namespace($this->namespace['user']['api'])
            ->group(base_path('routes/user-api.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminWebRoutes()
    {
        Route::middleware('web')
            ->prefix('admin')
            ->name('admin.')
            ->namespace($this->namespace['admin']['web'])
            ->group(base_path('routes/admin-web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminApiRoutes()
    {
        $version = config('app.api_version');
        Route::prefix("admin/api/{$version}")
            ->middleware('api')
            ->namespace($this->namespace['admin']['api'])
            ->group(base_path('routes/admin-api.php'));
    }
}
