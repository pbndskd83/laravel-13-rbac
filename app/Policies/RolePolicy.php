<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class RolePolicy
{
    /**
     * Determine whether the user can view the roles list.
     */
    public function viewAny(User $user): bool
    {
        // Ensures only admins/authorized users can view available roles.
        return $user->hasPermissionTo('role-list');
    }

    /**
     * Determine whether the user can view a specific role.
     */
    public function view(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('role-list');
    }

    /**
     * Determine whether the user can create new roles.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('role-create');
    }

    /**
     * Determine whether the user can update existing roles.
     */
    public function update(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('role-edit');
    }

    /**
     * Determine whether the user can delete roles.
     */
    public function delete(User $user, Role $role): bool
    {
        return $user->hasPermissionTo('role-delete');
    }
}