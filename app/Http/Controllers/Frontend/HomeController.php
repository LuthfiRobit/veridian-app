<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $locale = app()->getLocale();

        $data = Cache::remember("home_page_{$locale}", 3600, function () use ($locale) {
            $fallback = config('app.fallback_locale');

            // 1. Services (Limit 4 for Home)
            $services = Service::with([
                'translations' => function ($query) use ($locale, $fallback) {
                    $query->where('locale', $locale)->orWhere('locale', $fallback);
                }
            ])
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->take(4)
                ->get();

            // 2. Portfolio Categories (ALL active for filter tabs)
            $portfolioCategories = \App\Models\ProjectCategory::with(['translations'])
                ->where('is_active', true)
                ->orderBy('id_project_category')
                ->get();

            // 3. Portfolio Projects (Limit 6, including images + category)
            $projects = Project::with([
                'translations' => function ($query) use ($locale, $fallback) {
                    $query->where('locale', $locale)->orWhere('locale', $fallback);
                },
                'category',
                'category.translations' => function ($query) use ($locale, $fallback) {
                    $query->where('locale', $locale)->orWhere('locale', $fallback);
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
                'translations' => function ($query) use ($locale, $fallback) {
                    $query->where('locale', $locale)->orWhere('locale', $fallback);
                }
            ])
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get();

            // 5. Core Values for Why Us Section
            $coreValues = \App\Models\CoreValue::with([
                'translations' => function ($query) use ($locale, $fallback) {
                    $query->where('locale', $locale)->orWhere('locale', $fallback);
                }
            ])
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->take(3)
                ->get();

            return compact(
                'services',
                'projects',
                'portfolioCategories',
                'testimonials',
                'coreValues'
            );
        });

        return view('frontend.home', $data);
    }
}
