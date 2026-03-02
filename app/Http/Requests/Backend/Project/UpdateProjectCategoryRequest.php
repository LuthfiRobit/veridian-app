<?php

namespace App\Http\Requests\Backend\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $translations = $this->input('translations', []);

        foreach ($translations as $locale => $tData) {
            if (empty($tData['slug']) && !empty($tData['name'])) {
                $translations[$locale]['slug'] = \Illuminate\Support\Str::slug($tData['name']);
            }
        }

        $this->merge([
            'translations' => $translations,
        ]);
    }

    public function rules(): array
    {
        $rules = [
            'is_active' => 'required|boolean',
            'translations' => 'array',
        ];

        $categoryId = $this->route('project_category')->id_project_category ?? null;

        $languages = cache()->rememberForever('active_languages', function () {
            return \App\Models\Language::where('is_active', true)->get();
        });

        $defaultCode = \App\Models\Language::getDefaultCode();

        foreach ($languages as $lang) {
            $code = $lang->code;

            // Unique rule ignoring current translation ID if it exists
            $translationId = \App\Models\ProjectCategoryTranslation::where('id_project_category', $categoryId)
                ->where('locale', $code)
                ->value('id_project_category_translation');

            $uniqueRule = 'unique:project_category_translations,slug';
            if ($translationId) {
                $uniqueRule .= ',' . $translationId . ',id_project_category_translation';
            }

            if ($code === $defaultCode) {
                $rules["translations.{$code}.name"] = 'required|string|max:255';
                $rules["translations.{$code}.slug"] = 'required|string|max:255|' . $uniqueRule;
            } else {
                $rules["translations.{$code}.name"] = 'nullable|string|max:255';
                $rules["translations.{$code}.slug"] = 'nullable|string|max:255|' . $uniqueRule;
            }
        }

        return $rules;
    }
}
