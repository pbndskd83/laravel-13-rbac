<?php

namespace App\Providers;

// Models & Policies
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Policies\UserPolicy;
use App\Policies\RolePolicy;
use App\Policies\PermissionPolicy;

// Core Framework
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // ----------------------------------------------------------------
        // 1. SUPER ADMIN BYPASS (GOD MODE)
        // ----------------------------------------------------------------
        // This intercepts every single permission check.
        // If the user has the 'Super Admin' role, it instantly approves access.
        Gate::before(function ($user, $ability) {
            if ($user->hasRole(config('rbac.super_admin'))) {
                return true; 
            }
        });
    }
}