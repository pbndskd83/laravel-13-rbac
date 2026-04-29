<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
/*Route::get('/debug-role', function() {
    $user = auth()->user();
    return [
        'User Name' => $user->name,
        'User Email' => $user->email,
        'Has Super Admin Role?' => $user->hasRole('Super Admin'), // Check hardcoded string
        'Config Role Name' => config('rbac.super_admin'),         // Check config value
        'Has Config Role?' => $user->hasRole(config('rbac.super_admin')),
        'Permissions' => $user->getAllPermissions()->pluck('name'),
    ];
});*/
// -----------------------------------------------------------------------------
// 1. Public Routes
// -----------------------------------------------------------------------------
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes (Login, Register, Verify, Reset Password)
Auth::routes();

// -----------------------------------------------------------------------------
// 2. Protected Routes (Requires Login)
// -----------------------------------------------------------------------------
Route::middleware(['auth'])->group(function () {

    // --- Dashboard ---
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard');

    // --- User Profile (Self-Management) ---
    // Grouping these makes the code cleaner and easier to maintain
Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
    
    // URL: /profile  |  Name: profile.show
    Route::get('/', 'show')->name('show');
    
    // URL: /profile/edit  |  Name: profile.edit
    Route::get('/edit', 'edit')->name('edit');
    
    // URL: /profile  |  Name: profile.update
    Route::patch('/', 'update')->name('update');
    
    // URL: /profile/password  |  Name: profile.password.update
    Route::put('/password', 'updatePassword')->name('password.update');
    
});

    // --- Administrative & RBAC Management ---
    // Policies in the controllers handle the authorization (e.g., who can edit users)
    Route::resources([
        'permissions' => PermissionController::class,
        'roles'       => RoleController::class,
        'users'       => UserController::class,
    ]);
});