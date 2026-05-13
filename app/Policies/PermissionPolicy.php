<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;

class PermissionPolicy
{
    /**
     * Determine whether the user can view the permissions list.
     */
    public function viewAny(User $user): bool
    {
        // Critical for security: restricts visibility of the system's permission structure
        // to highly privileged users only.
        return $user->hasPermissionTo('permission-list');
    }

    /**
     * Determine whether the user can view a specific permission.
     */
    public function view(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo('permission-list');
    }

    /**
     * Determine whether the user can create new permissions.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('permission-create');
    }

    /**
     * Determine whether the user can update existing permissions.
     */
    public function update(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo('permission-edit');
    }

    /**
     * Determine whether the user can delete permissions.
     */
    public function delete(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo('permission-delete');
    }
}