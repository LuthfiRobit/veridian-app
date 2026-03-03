<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('frontend.partials.*', function ($view) {
            $locale = app()->getLocale();

            // Share Company Profile
            $company = \App\Models\CompanyProfile::with([
                'translations' => function ($query) use ($locale) {
                    $query->where('locale', $locale)->orWhere('locale', config('app.fallback_locale'));
                }
            ])->first();

            // Share Services for Footer Links
            $footerServices = \App\Models\Service::with([
                'translations' => function ($query) use ($locale) {
                    $query->where('locale', $locale)->orWhere('locale', config('app.fallback_locale'));
                }
            ])->where('is_active', true)->orderBy('sort_order')->take(5)->get();

            $view->with(compact('company', 'footerServices'));
        });
    }
}
