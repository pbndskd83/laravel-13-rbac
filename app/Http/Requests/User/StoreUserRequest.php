<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],

            // Ensure these pass through $request->validated()
            'phone'    => ['nullable', 'string', 'max:20'],
            'address'  => ['nullable', 'string', 'max:255'],

            // Standardized avatar validation
            'avatar'   => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'status'   => ['required', 'boolean'],

            // Sometimes used (e.g., hidden behind @can authorization in UI)
            'roles'    => ['sometimes', 'array'],
            
            // Prevent Database Injection: Verify the roles exist in the database
            'roles.*'  => ['exists:roles,name'],
        ];
    }
}