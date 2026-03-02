<?php

namespace App\Http\Requests\Backend\Blog;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPostRequest extends FormRequest
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
        $rules = [
            'id_blog_category' => 'required|exists:blog_categories,id_blog_category',
            'image_featured' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'reading_time' => 'nullable|integer|min:1',
            'translations' => 'array',
        ];

        $languages = cache()->rememberForever('active_languages', function () {
            return \App\Models\Language::where('is_active', true)->get();
        });

        $defaultCode = \App\Models\Language::getDefaultCode();

        foreach ($languages as $lang) {
            $code = $lang->code;
            if ($code === $defaultCode) {
                $rules["translations.{$code}.title"] = 'required|string|max:255';
                $rules["translations.{$code}.slug"] = 'required|string|max:255|unique:blog_post_translations,slug';
                $rules["translations.{$code}.content"] = 'required|string';
            } else {
                $rules["translations.{$code}.title"] = 'nullable|string|max:255';
                $rules["translations.{$code}.slug"] = 'nullable|string|max:255|unique:blog_post_translations,slug';
                $rules["translations.{$code}.content"] = 'nullable|string';
            }
            $rules["translations.{$code}.excerpt"] = 'nullable|string';
            $rules["translations.{$code}.meta_title"] = 'nullable|string|max:255';
            $rules["translations.{$code}.meta_desc"] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
