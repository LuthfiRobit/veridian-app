<?php

namespace App\Http\Requests\Backend\Certification;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Language;

class UpdateCertificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $defaultCode = Language::getDefaultCode();

        return [
            'icon_class' => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',

            'translations' => 'required|array',
            'translations.*.name' => 'nullable|string|max:255',
            'translations.*.description' => 'nullable|string|max:500',

            "translations.{$defaultCode}.name" => 'required|string|max:255',
            "translations.{$defaultCode}.description" => 'required|string|max:500',
        ];
    }
}
