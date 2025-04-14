<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('aftersales', function (User $user) {
            return $user->role === 'aftersales';
        });

        Gate::define('technicians', function (User $user) {
            return $user->role === 'teknisi';
        });

        Gate::define('marketing', function (User $user) {
            return $user->role === 'marketing';
        });

        Gate::define('managerMarketing', function (User $user) {
            return $user->role === 'manager_marketing';
        });

        Gate::define('aftersalesOrManagerMarketing', function (User $user) {
            return $user->role === 'aftersales' || $user->role === 'manager_marketing';
        });

        Gate::define('marketingOrManagerMarketing', function (User $user) {
            return $user->role === 'marketing' || $user->role === 'manager_marketing';
        });
    }
}
