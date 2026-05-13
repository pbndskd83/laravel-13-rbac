<?php

namespace App\Models;

// CONSISTENCY: Extending the core Spatie model keeps the authorization logic intact.
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    /**
     * The attributes that are mass assignable.
     * 
     * OVERRIDE: Just like the Role model, we add 'description' to the fillable 
     * array so we can attach human-readable explanations to our permissions.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'guard_name', 
        'description',
    ];
}