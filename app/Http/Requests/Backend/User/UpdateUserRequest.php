<?php

namespace App\Http\Requests\Backend\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('user') . ',id_user',
            'password' => 'nullable|string|min:8|same:confirm-password',
            'roles' => 'required',
            'is_active' => 'boolean',
        ];
    }

    protected function prepareForValidation()
    {
        // Normalize checkbox
        $this->merge([
            'is_active' => $this->has('is_active'),
        ]);
    }
}
