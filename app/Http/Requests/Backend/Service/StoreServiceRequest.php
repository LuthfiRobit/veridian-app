<?php

namespace App\Http\Requests\Backend\Service;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get available languages
        $languages = \App\Models\Language::where('is_active', true)->get();
        $defaultCode = \App\Models\Language::getDefaultCode();

        $rules = [
            'icon_class' => 'nullable|string|max:255',
            'image_main' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => [
                'integer',
                'min:1',
                \Illuminate\Validation\Rule::unique('services', 'sort_order')
            ],
            'is_active' => 'boolean',
            'translations' => 'array',
        ];

        foreach ($languages as $language) {
            $code = $language->code;
            if ($code === $defaultCode) {
                $rules["translations.{$code}.name"] = 'required|string|max:255';
            } else {
                $rules["translations.{$code}.name"] = 'nullable|string|max:255';
            }
            $rules["translations.{$code}.slug"] = 'nullable|string|max:255';
            $rules["translations.{$code}.short_desc"] = 'nullable|string';
            $rules["translations.{$code}.content"] = 'nullable|string';
            $rules["translations.{$code}.meta_title"] = 'nullable|string|max:255';
            $rules["translations.{$code}.meta_desc"] = 'nullable|string|max:255';
        }

        return $rules;
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        \Illuminate\Support\Facades\Log::error('Service Validation Failed:', $validator->errors()->toArray());
        parent::failedValidation($validator);
    }
}
