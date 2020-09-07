<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addYear());
        Passport::refreshTokensExpireIn(Carbon::now()->addYear());
        // Passport::personalAccessClientId(
        //     config('passport.personal_access_client.id')
        // );
        // Passport::personalAccessClientSecret(
        //     config('passport.personal_access_client.secret')
        // );
    }
}
