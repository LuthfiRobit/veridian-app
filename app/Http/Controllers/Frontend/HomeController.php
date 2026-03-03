<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $locale = app()->getLocale();

        // 1. Company Profile (Hero, About, Why Us, Contact)
        $company = CompanyProfile::with([
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale)->orWhere('locale', config('app.fallback_locale'));
            }
        ])->first();

        // 2. Services (Limit 4 for Home)
        $services = Service::with([
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale)->orWhere('locale', config('app.fallback_locale'));
            }
        ])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        // 3. Portfolio Categories (Fetch ALL active categories first for the filter tabs)
        $portfolioCategories = \App\Models\ProjectCategory::with(['translations'])
            ->where('is_active', true)
            ->orderBy('id_project_category')
            ->get();

        // 4. Portfolio Projects (Limit 6, including images)
        $projects = Project::with([
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale)->orWhere('locale', config('app.fallback_locale'));
            },
            'images'
        ])
            ->where('is_active', true)
            ->whereHas('category', function ($query) {
                $query->where('is_active', true);
            })
            ->latest('completion_date')
            ->take(6)
            ->get();

        // 4. Testimonials (All active for Swiper)
        $testimonials = Testimonial::with([
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale)->orWhere('locale', config('app.fallback_locale'));
            }
        ])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // 5. Core Values for Why Us Section
        $coreValues = \App\Models\CoreValue::with([
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale)->orWhere('locale', config('app.fallback_locale'));
            }
        ])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('frontend.home', compact(
            'company',
            'services',
            'projects',
            'portfolioCategories',
            'testimonials',
            'coreValues'
        ));
    }
}
