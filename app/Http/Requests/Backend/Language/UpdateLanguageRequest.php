<?php

namespace App\Http\Requests\Backend\Language;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('language'); // Route parameter name resource
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:languages,code,' . $id . ',id_language',
            'icon' => 'nullable|string|max:255',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
}
