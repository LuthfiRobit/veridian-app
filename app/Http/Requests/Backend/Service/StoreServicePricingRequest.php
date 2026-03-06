<?php

namespace App\Http\Requests\Backend\Service;

use Illuminate\Foundation\Http\FormRequest;

class StoreServicePricingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'sort_order' => [
                'integer',
                'min:1',
                \Illuminate\Validation\Rule::unique('service_pricings', 'sort_order')
                    ->where('id_service', $this->route('service')->id_service ?? $this->route('service'))
            ],
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'translations' => 'array',
        ];

        $languages = \App\Models\Language::where('is_active', true)->get();
        $defaultCode = \App\Models\Language::getDefaultCode();
        foreach ($languages as $language) {
            $code = $language->code;
            if ($code === $defaultCode) {
                $rules["translations.{$code}.name"] = 'required|string|max:255';
            } else {
                $rules["translations.{$code}.name"] = 'nullable|string|max:255';
            }
            $rules["translations.{$code}.price_label"] = 'nullable|string|max:255';
            $rules["translations.{$code}.unit_label"] = 'nullable|string|max:50';
            $rules["translations.{$code}.features_raw"] = 'nullable|string';
        }

        return $rules;
    }
}
