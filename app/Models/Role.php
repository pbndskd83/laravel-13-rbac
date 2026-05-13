<?php

namespace App\Models;

// CONSISTENCY: Extending the core Spatie model ensures we inherit all of 
// Spatie's relationship logic and query scopes while allowing custom attributes.
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    /**
     * The attributes that are mass assignable.
     * 
     * OVERRIDE: We redeclare the $fillable array to include our custom 
     * 'description' column, allowing it to be saved via mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'guard_name', 
        'description',
    ];
}