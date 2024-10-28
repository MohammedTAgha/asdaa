<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Super Manager
        Gate::define('super', function ($user) {
            return $user->hasRole('Super Manager');
        });

         // Super Manager
         Gate::define('create-citizens', function ($user) {
            return  $user->hasRole('Super Manager');
        });
        // Admin
        Gate::define('superandadmin', function ($user) {
            return $user->hasRole('Admin') || $user->hasRole('Super Manager');
        });

        // Admin
        Gate::define('admin', function ($user) {
            return $user->hasRole('Admin');
        });

        // Admin
        Gate::define('superandadmin', function ($user) {
            return $user->hasRole('Admin') || $user->hasRole('Super Manager');
        });
        // Region Manager
        Gate::define('view-citizens', function ($user) {
            return $user->hasRole('Region Manager') || $user->hasRole('Admin') || $user->hasRole('Super Manager');
        });

        // Region Manager
        Gate::define('regionManager', function ($user) {
        return $user->hasRole('Region Manager') ;
    });

    }
}
