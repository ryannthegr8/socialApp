<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // Auth service provider

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
        // Pagination
        Paginator::useBootstrapFive();

        // Gate for only allowing admins to do a particular action.
        Gate::define('visitAdminPages',function($user){
            return $user->isAdmin === 1;
        });
    }
}
