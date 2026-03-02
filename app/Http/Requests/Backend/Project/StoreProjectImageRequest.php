<?php

namespace App\Http\Requests\Backend\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image_path' => 'required|image|max:2048',
            'is_hero' => 'boolean',
            'sort_order' => 'integer',
            'translations.*.caption' => 'nullable|string|max:255',
        ];
    }
}
