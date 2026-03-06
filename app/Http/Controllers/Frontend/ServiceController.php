<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    public function show($locale, $slug)
    {
        $cacheKey = "service_detail_{$locale}_{$slug}";

        $data = Cache::remember($cacheKey, 3600, function () use ($locale, $slug) {
            $fallback = config('app.fallback_locale');

            // Retrieve the service based on the slug
            // Note: whereTranslation uses current app locale. 
            // If we want to support slugs from other locales, we'd use whereHas('translations', ...)
            $service = Service::whereTranslation('slug', $slug)
                ->where('is_active', true)
                ->with([
                    'translations', // Better to load all if using fallbacks extensively
                    'benefits' => function ($query) {
                        $query->where('is_active', true)->orderBy('sort_order', 'asc');
                    },
                    'benefits.translations',
                    'processes' => function ($query) {
                        $query->where('is_active', true)->orderBy('step_number', 'asc');
                    },
                    'processes.translations',
                    'pricings' => function ($query) {
                        $query->where('is_active', true)->orderBy('sort_order', 'asc');
                    },
                    'pricings.translations'
                ])
                ->firstOrFail();

            // Fetch all active services for the sidebar menu
            $allServices = Service::with([
                'translations' => function ($query) use ($locale, $fallback) {
                    $query->where('locale', $locale)->orWhere('locale', $fallback);
                }
            ])
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get();

            return compact('service', 'allServices');
        });

        // Register slug in the cache slug registry for invalidation
        $slugs = Cache::get('cached_service_slugs', []);
        if (!in_array($slug, $slugs)) {
            $slugs[] = $slug;
            Cache::put('cached_service_slugs', $slugs, 3600);
        }

        return view('frontend.services.show', $data);
    }
}
