<?php

namespace App\Http\Requests\Backend\Language;

use Illuminate\Foundation\Http\FormRequest;

class StoreLanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:languages,code',
            'icon' => 'nullable|string|max:255',
            'is_default' => [
                'boolean',
                function ($attribute, $value, $fail) {
                    if ($value && \App\Models\Language::where('is_default', true)->exists()) {
                        $fail('A default language already exists.');
                    }
                }
            ],
            'is_active' => 'boolean',
        ];
    }
}
