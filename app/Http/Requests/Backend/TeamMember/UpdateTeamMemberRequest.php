<?php

namespace App\Http\Requests\Backend\TeamMember;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Language;

class UpdateTeamMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_photo' => 'nullable',
            'email' => 'nullable|email|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ];

        $languages = Language::where('is_active', true)->get();
        $defaultCode = \App\Models\Language::getDefaultCode();

        foreach ($languages as $language) {
            $code = $language->code;
            if ($code === $defaultCode) {
                $rules["translations.{$code}.position"] = 'required|string|max:255';
            } else {
                $rules["translations.{$code}.position"] = 'nullable|string|max:255';
            }
            $rules["translations.{$code}.department"] = 'nullable|string|max:255';
            $rules["translations.{$code}.bio"] = 'nullable|string';
        }

        return $rules;
    }
}
