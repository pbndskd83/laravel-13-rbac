<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Get the user ID safely from the route
        $user = $this->route('user');
        $userId = $user ? $user->id : null;

        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            
            // Ensure fields are included in validated()
            'phone'    => ['nullable', 'string', 'max:20'], 
            'address'  => ['nullable', 'string', 'max:255'],
            
            // Standardized avatar validation
            'avatar'   => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'status'   => ['required', 'boolean'],
            
            // Sometimes used (e.g., hidden behind @can authorization in UI)
            'roles'    => ['sometimes', 'array'], 
            
            // Prevent Database Injection: Verify the roles exist in the database
            'roles.*'  => ['exists:roles,name'],
            
            // Logic: Validate password as nullable so an empty input does not overwrite 
            // the user's current password. The Controller/Service should handle skipping
            // the password update if the field is empty.
            'password' => ['nullable', 'confirmed', 'min:8'],
        ];
    }
}