<?php

namespace App\Http\Requests\Backend\CompanyProfile;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Language;

class UpdateCompanyProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $defaultCode = Language::getDefaultCode();

        return [
            // Stats
            'stat_projects' => 'required|string|max:50',
            'stat_clients' => 'required|string|max:50',
            'stat_retention' => 'required|string|max:50',
            'stat_experience' => 'required|string|max:50',
            'stat_languages' => 'required|string|max:50',
            'stat_satisfaction' => 'required|string|max:50',

            // Contact Info
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'whatsapp' => 'nullable|string|max:50',
            'google_maps_url' => 'nullable|url|max:500',

            // Social Media
            'social_facebook' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
            'social_tiktok' => 'nullable|url|max:255',

            // Images
            'about_image_main' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'about_image_secondary' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            // Status
            'is_active' => 'required|boolean',

            // Translations
            'translations' => 'required|array',
            'translations.*.hero_badge' => 'nullable|string|max:255',
            'translations.*.hero_title' => 'nullable|string|max:255',
            'translations.*.hero_description' => 'nullable|string',
            'translations.*.about_title' => 'nullable|string|max:255',
            'translations.*.about_subtitle' => 'nullable|string|max:255',
            'translations.*.about_lead_text' => 'nullable|string',
            'translations.*.about_description' => 'nullable|string',
            'translations.*.mission_title' => 'nullable|string|max:255',
            'translations.*.mission_description' => 'nullable|string',
            'translations.*.vision_title' => 'nullable|string|max:255',
            'translations.*.vision_description' => 'nullable|string',
            'translations.*.footer_description' => 'nullable|string',

            // Default language required
            "translations.{$defaultCode}.hero_title" => 'required|string|max:255',
            "translations.{$defaultCode}.hero_description" => 'required|string',
            "translations.{$defaultCode}.about_title" => 'required|string|max:255',
            "translations.{$defaultCode}.about_lead_text" => 'required|string',
            "translations.{$defaultCode}.mission_title" => 'required|string|max:255',
            "translations.{$defaultCode}.mission_description" => 'required|string',
            "translations.{$defaultCode}.vision_title" => 'required|string|max:255',
            "translations.{$defaultCode}.vision_description" => 'required|string',
        ];
    }
}
