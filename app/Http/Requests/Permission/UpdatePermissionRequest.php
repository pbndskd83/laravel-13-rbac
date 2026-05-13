<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Safely extract the permission ID from the route for the unique rule ignore clause
        $permissionId = $this->route('permission')->id;

        return [
            'name'        => [
                'required', 
                'max:255', 
                // Ignore the current permission's ID so saving without changing the name doesn't trigger a unique validation error
                Rule::unique('permissions', 'name')->ignore($permissionId)
            ],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
}