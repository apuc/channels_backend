<?php

namespace App\Providers;

use App\Extensions\Guards\ServiceGuard;
use App\Extensions\Providers\ServiceUserProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // add custom guard provider
        \Auth::provider('service', function ($app, array $config) {
            return new ServiceUserProvider($app->make('App\Models\User'), $app->make('App\Extensions\Models\ServiceAuth'));
        });

        // add custom guard
        \Auth::extend('service', function ($app, $name, array $config) {
            return new ServiceGuard(\Auth::createUserProvider($config['provider']), $app->make('request'));
        });

        Passport::tokensExpireIn(now()->addDays(3));

        Passport::refreshTokensExpireIn(now()->addDays(6));
    }
}
