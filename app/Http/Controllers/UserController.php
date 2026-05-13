<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index(Request $request): View
    {
        $this->authorize('viewAny', User::class);

        $data = $this->userService->getPaginatedUsers(
            $request->query('search'), 
            10
        );

        return view('users.index', compact('data'));
    }

    public function create(): View
    {
        $this->authorize('create', User::class);
        
        $roles = Role::pluck('name', 'name')->all();
        
        return view('users.form', [
            'roles'    => $roles,
            'user'     => null, // Tells the form we are creating
            'userRole' => []    // Empty roles for create mode
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $data = $request->validated();
        $superAdminRole = config('rbac.super_admin');

        // SECURITY FIX: Prevent Privilege Escalation
        // Ensure that a user without Super Admin privileges cannot inject the 
        // Super Admin role into the request array to escalate a new user's permissions.
        if (isset($data['roles']) && in_array($superAdminRole, $data['roles'])) {
            if (!$request->user()->hasRole($superAdminRole)) {
                abort(403, 'UNAUTHORIZED TO ASSIGN SUPER ADMIN ROLE');
            }
        }

        $this->userService->createUser($data);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function show(User $user): View
    {
        $this->authorize('view', $user);
        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        $roles = Role::pluck('name', 'name')->all();
        
        // Get simple array of role names for the form
        $userRole = $user->roles->pluck('name')->toArray();

        return view('users.form', compact('user', 'roles', 'userRole'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $data = $request->validated();
        $superAdminRole = config('rbac.super_admin');

        // SECURITY FIX: Prevent Privilege Escalation
        // Ensure non-Super-Admins cannot maliciously edit an existing user 
        // and assign them the Super Admin role.
        if (isset($data['roles']) && in_array($superAdminRole, $data['roles'])) {
            if (!$request->user()->hasRole($superAdminRole)) {
                abort(403, 'UNAUTHORIZED TO ASSIGN SUPER ADMIN ROLE');
            }
        }

        // LOGIC FIX: Prevent overwriting password with blank input
        // If the password field is sent but empty, unset it so the Service/Eloquent 
        // does not replace the existing hashed password with an empty string.
        if (empty($data['password'])) {
            unset($data['password']);
        }

        // If roles are missing (e.g., hidden by permissions), preserve existing roles
        if (!$request->has('roles')) {
            unset($data['roles']); 
        }

        $this->userService->updateUser($user, $data);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        try {
            $this->userService->deleteUser($user);
            
            return redirect()->route('users.index')
                ->with('success', 'User deleted successfully');
                
        } catch (\Exception $e) {
            // Handle cases where Super Admin cannot be deleted
            return back()->with('error', $e->getMessage());
        }
    }
}