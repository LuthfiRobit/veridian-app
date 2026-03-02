<?php

namespace App\Http\Requests\Backend\Service;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceBenefitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'icon_class' => 'nullable|string|max:255',
            'sort_order' => [
                'integer',
                'min:1',
                \Illuminate\Validation\Rule::unique('service_benefits', 'sort_order')
                    ->where('id_service', $this->route('service')->id_service ?? $this->route('service'))
                    ->ignore($this->route('benefit')->id_service_benefit ?? $this->route('benefit'), 'id_service_benefit')
            ],
            'is_active' => 'boolean',
            'translations' => 'array',
        ];

        $languages = \App\Models\Language::where('is_active', true)->get();
        $defaultCode = \App\Models\Language::getDefaultCode();
        foreach ($languages as $language) {
            $code = $language->code;
            if ($code === $defaultCode) {
                $rules["translations.{$code}.title"] = 'required|string|max:255';
            } else {
                $rules["translations.{$code}.title"] = 'nullable|string|max:255';
            }
            $rules["translations.{$code}.description"] = 'nullable|string';
        }

        return $rules;
    }
}
