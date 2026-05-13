<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     * 
     * Access Control: Restricts access to the complete user directory.
     * Only users or roles with the explicit 'user-list' permission can view the listing,
     * effectively preventing lower-level staff or unauthorized users from seeing team directories.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('user-list');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Authorizes viewing a specific user's details. 
        // Note: For finer granularity, consider implementing a 'user-show' permission 
        // if viewing lists and viewing profiles need separate access levels.
        return $user->hasPermissionTo('user-list');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Validates if the user possesses the permission to create new users.
        return $user->hasPermissionTo('user-create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Validates if the user possesses the permission to modify existing users.
        return $user->hasPermissionTo('user-edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // RBAC Best Practice: Prevent users from deleting their own account 
        // to avoid locking themselves out or causing orphan data issues.
        if ($user->id === $model->id) {
            return false;
        }
        
        // Only allow deletion if the user explicitly has the 'user-delete' permission.
        return $user->hasPermissionTo('user-delete');
    }
}