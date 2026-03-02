<?php

namespace App\Http\Requests\Backend\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $translations = $this->input('translations', []);

        foreach ($translations as $locale => $tData) {
            if (empty($tData['slug']) && !empty($tData['title'])) {
                $translations[$locale]['slug'] = \Illuminate\Support\Str::slug($tData['title']);
            }
        }

        $this->merge([
            'translations' => $translations,
        ]);
    }

    public function rules(): array
    {
        $id = $this->route('project'); // Get project ID from route
        $languages = Cache::rememberForever('active_languages', function () {
            return \App\Models\Language::where('is_active', true)->get();
        });

        $defaultCode = \App\Models\Language::getDefaultCode();

        $rules = [
            'id_project_category' => 'required|exists:project_categories,id_project_category',
            'client_name' => 'required|string|max:255',
            'completion_date' => 'required|date',
            'project_url' => 'nullable|url|max:255',
            'image_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => [
                'integer',
                'min:1',
                \Illuminate\Validation\Rule::unique('projects', 'sort_order')->ignore($id, 'id_project')
            ],
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'translations' => 'array',
        ];

        foreach ($languages as $language) {
            $code = $language->code;
            if ($code === $defaultCode) {
                $rules["translations.{$code}.title"] = 'required|string|max:255';
            } else {
                $rules["translations.{$code}.title"] = 'nullable|string|max:255';
            }
            $rules["translations.{$code}.slug"] = 'nullable|string|max:255';
            $rules["translations.{$code}.subtitle"] = 'nullable|string|max:255';
            $rules["translations.{$code}.description"] = 'nullable|string';
            $rules["translations.{$code}.content"] = 'nullable|string';
            $rules["translations.{$code}.challenge"] = 'nullable|string';
            $rules["translations.{$code}.solution"] = 'nullable|string';
            $rules["translations.{$code}.result"] = 'nullable|string';
            $rules["translations.{$code}.tech_stack"] = 'nullable|array';
            $rules["translations.{$code}.meta_title"] = 'nullable|string|max:255';
            $rules["translations.{$code}.meta_desc"] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
