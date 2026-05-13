<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

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
        // Use Bootstrap 5 styling for Laravel Pagination
        Paginator::useBootstrap();

        /*
        |--------------------------------------------------------------------------
        | Global Authorization Bypass (Super Admin)
        |--------------------------------------------------------------------------
        | This check runs before all other authorization checks. 
        | If it returns true, the user is authorized. 
        | If it returns null, it falls through to specific gate/policy checks.
        */
        Gate::before(function ($user, $ability) {
            // Check if user has the Super Admin role defined in config
            // We return null if false to allow other specific gates to evaluate
            return $user->hasRole(config('rbac.super_admin')) ? true : null;
        });

        /*
        |--------------------------------------------------------------------------
        | System Settings Gate
        |--------------------------------------------------------------------------
        | Explicit gate for managing global website configurations.
        | Access: Restricted to users with 'Super Admin' role.
        */
        Gate::define('manage-settings', function (User $user) {
            return $user->hasRole(config('rbac.super_admin'));
        });
    }
}