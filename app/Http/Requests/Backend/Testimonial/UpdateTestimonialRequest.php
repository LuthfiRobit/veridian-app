<?php

namespace App\Http\Requests\Backend\Testimonial;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestimonialRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'id_project' => 'nullable|exists:projects,id_project',
            'client_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'nullable|in:0,1',
            'sort_order' => 'nullable|integer',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_avatar' => 'nullable|boolean',
            'translations' => 'array',
        ];

        $languages = \App\Models\Language::where('is_active', true)->get();
        $defaultCode = \App\Models\Language::getDefaultCode();

        foreach ($languages as $lang) {
            $code = $lang->code;
            if ($code === $defaultCode) {
                $rules["translations.{$code}.client_position"] = 'nullable|string|max:255';
                $rules["translations.{$code}.content"] = 'required|string';
            } else {
                $rules["translations.{$code}.client_position"] = 'nullable|string|max:255';
                $rules["translations.{$code}.content"] = 'nullable|string';
            }
        }

        return $rules;
    }
}
