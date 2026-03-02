<?php

namespace App\Http\Requests\Backend\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectStatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'value' => 'required|string|max:255',
            'icon_class' => 'nullable|string|max:255',
            'sort_order' => 'integer',
            'translations' => 'array',
        ];

        $languages = \App\Models\Language::where('is_active', true)->get();
        $defaultCode = \App\Models\Language::getDefaultCode();
        foreach ($languages as $language) {
            $code = $language->code;
            if ($code === $defaultCode) {
                $rules["translations.{$code}.label"] = 'required|string|max:255';
            } else {
                $rules["translations.{$code}.label"] = 'nullable|string|max:255';
            }
        }

        return $rules;
    }
}
