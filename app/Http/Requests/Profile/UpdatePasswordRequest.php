<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Validates that the provided current password matches the authenticated user's actual password
            'current_password' => ['required', 'current_password'],
            
            // Requires the new password to be confirmed (must match 'password_confirmation' field) and at least 8 chars
            'password'         => ['required', 'confirmed', 'min:8'],
        ];
    }
}