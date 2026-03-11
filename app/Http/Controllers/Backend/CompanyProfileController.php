<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\Language;
use App\Http\Requests\Backend\CompanyProfile\UpdateCompanyProfileRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class CompanyProfileController extends Controller
{
    public function edit()
    {
        $profile = CompanyProfile::singleton();
        $profile->load('translations');
        $sortedLanguages = Language::where('is_active', true)->orderBy('is_default', 'desc')->get();

        return view('backend.company-profile.edit', compact('profile', 'sortedLanguages'));
    }

    public function update(UpdateCompanyProfileRequest $request)
    {
        try {
            $profile = CompanyProfile::singleton();
            $data = $request->validated();

            // Handle about_image_main
            if ($request->hasFile('about_image_main')) {
                if ($profile->about_image_main) {
                    Storage::disk('public')->delete($profile->about_image_main);
                }
                $data['about_image_main'] = $request->file('about_image_main')->store('company-profile', 'public');
            }
            if ($request->boolean('remove_about_image_main') && $profile->about_image_main) {
                Storage::disk('public')->delete($profile->about_image_main);
                $data['about_image_main'] = null;
            }

            // Handle about_image_secondary
            if ($request->hasFile('about_image_secondary')) {
                if ($profile->about_image_secondary) {
                    Storage::disk('public')->delete($profile->about_image_secondary);
                }
                $data['about_image_secondary'] = $request->file('about_image_secondary')->store('company-profile', 'public');
            }
            if ($request->boolean('remove_about_image_secondary') && $profile->about_image_secondary) {
                Storage::disk('public')->delete($profile->about_image_secondary);
                $data['about_image_secondary'] = null;
            }

            // Update non-translatable fields
            $profile->update([
                'stat_projects' => $data['stat_projects'] ?? $profile->stat_projects,
                'stat_clients' => $data['stat_clients'] ?? $profile->stat_clients,
                'stat_retention' => $data['stat_retention'] ?? $profile->stat_retention,
                'stat_experience' => $data['stat_experience'] ?? $profile->stat_experience,
                'stat_languages' => $data['stat_languages'] ?? $profile->stat_languages,
                'stat_satisfaction' => $data['stat_satisfaction'] ?? $profile->stat_satisfaction,
                'address' => $data['address'] ?? $profile->address,
                'phone' => $data['phone'] ?? $profile->phone,
                'email' => $data['email'] ?? $profile->email,
                'whatsapp' => $data['whatsapp'] ?? $profile->whatsapp,
                'google_maps_url' => $data['google_maps_url'] ?? $profile->google_maps_url,
                'social_facebook' => $data['social_facebook'] ?? $profile->social_facebook,
                'social_instagram' => $data['social_instagram'] ?? $profile->social_instagram,
                'social_twitter' => $data['social_twitter'] ?? $profile->social_twitter,
                'social_linkedin' => $data['social_linkedin'] ?? $profile->social_linkedin,
                'social_youtube' => $data['social_youtube'] ?? $profile->social_youtube,
                'social_tiktok' => $data['social_tiktok'] ?? $profile->social_tiktok,
                'about_image_main' => $data['about_image_main'] ?? $profile->about_image_main,
                'about_image_secondary' => $data['about_image_secondary'] ?? $profile->about_image_secondary,
                'is_active' => (int) $request->input('is_active', 1),
            ]);

            // Save translations
            if (isset($data['translations'])) {
                foreach ($data['translations'] as $locale => $translationData) {
                    $profile->translateOrNew($locale)->fill($translationData);
                }
                $profile->save();
            }

            // Invalidate frontend caches for all locales
            $locales = Language::where('is_active', true)->pluck('code');
            foreach ($locales as $loc) {
                Cache::forget("company_profile_{$loc}");
                Cache::forget("home_page_{$loc}");
                Cache::forget("about_page_{$loc}");
                Cache::forget("footer_services_{$loc}");
            }

            activity()
                ->performedOn($profile)
                ->causedBy(auth()->user())
                ->log('Updated Company Profile Settings');

            return redirect()->route('admin.company-profile.edit')->with('success', 'Company profile updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
