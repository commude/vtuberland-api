<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
* @OA\Info(
*      version="1.0.0",
*      title="VTuberland - API SPECIFICATIONS",
*      description="An API documentation used for VTuberland App",
* )
*  @OA\Server(
*      url="http://localhost:8000/api/v1/",
*      description="Localhost Server"
*  )
*
*  @OA\Server(
*      url="https://vtuberland.test/api/v1/",
*      description="Local Virtual Server"
*  )
*
*  @OA\Server(
*      url="http://vtuberland.commude.biz/api/v1/",
*      description="Dev Server"
*  )
*/
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
