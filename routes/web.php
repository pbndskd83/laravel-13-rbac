<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SettingController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// -----------------------------------------------------------------------------
// 1. Public Routes
// -----------------------------------------------------------------------------
Route::get('/', function () {
    return view('welcome');
});

// Laravel UI / Breeze / Jetstream Auth Routes
Auth::routes();

// -----------------------------------------------------------------------------
// 2. Protected Routes (Requires Authentication)
// -----------------------------------------------------------------------------
Route::middleware(['auth'])->group(function () {

    /**
     * Dashboard / Home
     */
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard');

    /**
     * User Profile Self-Management
     * Prefixed with /profile | Named profile.*
     */
    Route::controller(ProfileController::class)
        ->prefix('profile')
        ->name('profile.')
        ->group(function () {
            Route::get('/', 'show')->name('show');
            Route::get('/edit', 'edit')->name('edit');
            Route::patch('/', 'update')->name('update');
            Route::put('/password', 'updatePassword')->name('password.update');
        });

    /**
     * Administrative & RBAC Management
     * Prefixed with /admin | Handled by Policies in Controllers
     */
    Route::prefix('admin')->group(function () {
        
        // Settings Management (Requires specific 'manage-settings' permission/gate)
        Route::middleware(['can:manage-settings'])->group(function () {
            
            Route::get('/settings', [SettingController::class, 'edit'])->name('admin.settings.edit');
            Route::patch('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
            
            // Global Reset
            Route::delete('/settings/reset', [SettingController::class, 'reset'])->name('admin.settings.reset');
            
            // Section-wise Reset
            Route::delete('/settings/reset/{section}', [SettingController::class, 'resetSection'])->name('admin.settings.reset.section');
        });

        // Resourceful Routes for RBAC
        Route::resources([
            'permissions' => PermissionController::class,
            'roles'       => RoleController::class,
            'users'       => UserController::class,
        ]);
        
    }); // <-- Correctly placed closing brace for the 'admin' prefix group
});

/*
|--------------------------------------------------------------------------
| Diagnostics / Debug
|--------------------------------------------------------------------------
| Uncomment this route to verify Spatie RBAC cache and configs.
|--------------------------------------------------------------------------
*/
// Route::get('/debug-role', function() {
//     $user = auth()->user();
//     return [
//         'User Name'             => $user->name,
//         'Config Role Name'      => config('rbac.super_admin'),
//         'Has Config Role?'      => $user->hasRole(config('rbac.super_admin')),
//         'Permissions'           => $user->getAllPermissions()->pluck('name'),
//     ];
// });