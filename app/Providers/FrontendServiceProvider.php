<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Language;

class FrontendServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * Handles caching of language data for the header language switcher.
     * Uses request-singleton to avoid repeated cache lookups.
     */
    public function boot(): void
    {
        // ─── View Composer: Share company + footer services (cached) ───
        View::composer(['frontend.*', 'layouts.*'], function ($view) {
            static $resolved = [];

            $locale = app()->getLocale();
            $cacheKeyLocale = "composer_{$locale}";

            if (!isset($resolved[$cacheKeyLocale])) {
                $fallback = config('app.fallback_locale');

                $company = Cache::remember("company_profile_{$locale}", 3600, function () use ($locale, $fallback) {
                    // Use singleton() for robustness, and eager load translations
                    $profile = \App\Models\CompanyProfile::singleton();
                    $profile->load([
                        'translations' => function ($query) use ($locale, $fallback) {
                            $query->where('locale', $locale)->orWhere('locale', $fallback);
                        }
                    ]);
                    return $profile;
                });

                $footerServices = Cache::remember("footer_services_{$locale}", 3600, function () use ($locale, $fallback) {
                    return \App\Models\Service::with([
                        'translations' => function ($query) use ($locale, $fallback) {
                            $query->where('locale', $locale)->orWhere('locale', $fallback);
                        }
                    ])->where('is_active', true)->orderBy('sort_order')->take(5)->get();
                });

                $resolved[$cacheKeyLocale] = compact('company', 'footerServices');
            }

            $view->with($resolved[$cacheKeyLocale]);
        });
    }
}
