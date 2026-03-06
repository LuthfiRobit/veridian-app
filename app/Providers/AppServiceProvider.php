<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Observers\CacheInvalidationObserver;

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


        // ─── Register CacheInvalidationObserver for all content models ───
        $modelsToObserve = [
            \App\Models\CompanyProfile::class,
            \App\Models\Service::class,
            \App\Models\Project::class,
            \App\Models\Testimonial::class,
            \App\Models\TeamMember::class,
            \App\Models\BlogPost::class,
            \App\Models\CoreValue::class,
            \App\Models\CompanyTimeline::class,
            \App\Models\Certification::class,
            \App\Models\BlogCategory::class,
            \App\Models\ProjectCategory::class,
            \App\Models\Language::class,
        ];

        foreach ($modelsToObserve as $model) {
            $model::observe(CacheInvalidationObserver::class);
        }
    }
}
