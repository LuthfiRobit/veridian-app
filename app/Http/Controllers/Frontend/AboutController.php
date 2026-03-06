<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use App\Models\CoreValue;
use App\Models\CompanyTimeline;
use App\Models\Certification;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Cache;

class AboutController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        $data = Cache::remember("about_page_{$locale}", 3600, function () use ($locale) {
            $fallback = config('app.fallback_locale');

            // Core Values (active, ordered)
            $coreValues = CoreValue::with([
                'translations' => function ($query) use ($locale, $fallback) {
                    $query->where('locale', $locale)->orWhere('locale', $fallback);
                }
            ])
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get();

            // Timeline (active, ordered by year desc, then sort_order)
            $timelines = CompanyTimeline::with([
                'translations' => function ($query) use ($locale, $fallback) {
                    $query->where('locale', $locale)->orWhere('locale', $fallback);
                }
            ])
                ->where('is_active', true)
                ->orderBy('year', 'desc')
                ->orderBy('sort_order', 'asc')
                ->get();

            // Certifications (active, ordered)
            $certifications = Certification::with([
                'translations' => function ($query) use ($locale, $fallback) {
                    $query->where('locale', $locale)->orWhere('locale', $fallback);
                }
            ])
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get();

            return compact('coreValues', 'timelines', 'certifications');
        });

        return view('frontend.about.index', $data);
    }

    public function team()
    {
        $locale = app()->getLocale();

        $data = Cache::remember("team_page_{$locale}", 3600, function () use ($locale) {
            $fallback = config('app.fallback_locale');

            // Team Members (active, ordered)
            $teamMembers = TeamMember::with([
                'translations' => function ($query) use ($locale, $fallback) {
                    $query->where('locale', $locale)->orWhere('locale', $fallback);
                }
            ])
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get();

            return compact('teamMembers');
        });

        return view('frontend.about.team', $data);
    }
}
