<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

/**
 * Universal cache invalidation observer for frontend landing page data.
 *
 * Attached to all content models that feed the landing page.
 * On saved/deleted events, flushes the relevant cache keys.
 *
 * Strategy: Uses specific named cache keys instead of cache tags
 * to remain compatible with the 'database' cache driver.
 */
class CacheInvalidationObserver
{
    /**
     * All cache keys used by the frontend landing page.
     * Grouped by prefix for clarity.
     */
    protected static function getCacheKeys(): array
    {
        // Get all active locale codes for locale-specific keys
        $locales = Cache::remember('active_locale_codes', 3600, function () {
            return \App\Models\Language::where('is_active', true)
                ->pluck('code')
                ->toArray();
        });

        $keys = [
            // View composer keys (shared across pages)
            'company_profile_footer',
            'footer_services',
            'active_languages',
            'active_locale_codes',
        ];

        // Locale-specific page cache keys
        foreach ($locales as $locale) {
            $keys[] = "home_page_{$locale}";
            $keys[] = "about_page_{$locale}";
            $keys[] = "team_page_{$locale}";
            $keys[] = "blog_categories_{$locale}";
        }

        return $keys;
    }

    /**
     * Flush all frontend cache keys.
     */
    protected function flushFrontendCache(): void
    {
        $keys = static::getCacheKeys();

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        // Also forget any service/portfolio/blog detail page cache keys
        // These use dynamic slugs, so we use a pattern-based approach
        $this->flushDynamicKeys();
    }

    /**
     * Flush dynamic cache keys (service details, portfolio details, blog posts).
     * Since we can't enumerate all slug-based keys easily with the database driver,
     * we keep a registry of cached slugs.
     */
    protected function flushDynamicKeys(): void
    {
        // Flush the slug registry entries
        $servicesSlugs = Cache::get('cached_service_slugs', []);
        foreach ($servicesSlugs as $slug) {
            foreach (['id', 'en'] as $locale) {
                Cache::forget("service_detail_{$locale}_{$slug}");
            }
        }
        Cache::forget('cached_service_slugs');

        $portfolioSlugs = Cache::get('cached_portfolio_slugs', []);
        foreach ($portfolioSlugs as $slug) {
            foreach (['id', 'en'] as $locale) {
                Cache::forget("portfolio_detail_{$locale}_{$slug}");
            }
        }
        Cache::forget('cached_portfolio_slugs');

        $blogSlugs = Cache::get('cached_blog_slugs', []);
        foreach ($blogSlugs as $slug) {
            foreach (['id', 'en'] as $locale) {
                Cache::forget("blog_detail_{$locale}_{$slug}");
            }
        }
        Cache::forget('cached_blog_slugs');
    }

    /**
     * Handle the "saved" event (covers both created and updated).
     */
    public function saved($model): void
    {
        $this->flushFrontendCache();
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted($model): void
    {
        $this->flushFrontendCache();
    }
}
