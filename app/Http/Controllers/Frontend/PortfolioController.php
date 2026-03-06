<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;

class PortfolioController extends Controller
{
    public function show($locale, $slug)
    {
        $cacheKey = "portfolio_detail_{$locale}_{$slug}";

        $data = Cache::remember($cacheKey, 3600, function () use ($locale, $slug) {
            $fallback = config('app.fallback_locale');

            // Eager load project data to prevent N+1 issues
            $project = Project::whereTranslation('slug', $slug)
                ->where('is_active', true)
                ->with([
                    'translations' => function ($query) use ($locale, $fallback) {
                        $query->where('locale', $locale)->orWhere('locale', $fallback);
                    },
                    'category',
                    'category.translations' => function ($query) use ($locale, $fallback) {
                        $query->where('locale', $locale)->orWhere('locale', $fallback);
                    },
                    'images' => function ($query) {
                        $query->orderBy('sort_order', 'asc');
                    },
                    'images.translations' => function ($query) use ($locale, $fallback) {
                        $query->where('locale', $locale)->orWhere('locale', $fallback);
                    },
                    'stats' => function ($query) {
                        $query->orderBy('sort_order', 'asc');
                    },
                    'stats.translations' => function ($query) use ($locale, $fallback) {
                        $query->where('locale', $locale)->orWhere('locale', $fallback);
                    },
                    'features' => function ($query) {
                        $query->orderBy('sort_order', 'asc');
                    },
                    'features.translations' => function ($query) use ($locale, $fallback) {
                        $query->where('locale', $locale)->orWhere('locale', $fallback);
                    }
                ])
                ->firstOrFail();

            // Get Previous and Next Projects for navigation
            $previousProject = Project::where('is_active', true)
                ->where('id_project', '<', $project->id_project)
                ->orderBy('id_project', 'desc')
                ->first();

            $nextProject = Project::where('is_active', true)
                ->where('id_project', '>', $project->id_project)
                ->orderBy('id_project', 'asc')
                ->first();

            // Load translations for previous/next link generation
            if ($previousProject) {
                $previousProject->load([
                    'translations' => function ($query) use ($locale, $fallback) {
                        $query->where('locale', $locale)->orWhere('locale', $fallback);
                    }
                ]);
            }

            if ($nextProject) {
                $nextProject->load([
                    'translations' => function ($query) use ($locale, $fallback) {
                        $query->where('locale', $locale)->orWhere('locale', $fallback);
                    }
                ]);
            }

            return compact('project', 'previousProject', 'nextProject', 'locale', 'fallback');
        });

        // Register slug in the cache slug registry for invalidation
        $slugs = Cache::get('cached_portfolio_slugs', []);
        if (!in_array($slug, $slugs)) {
            $slugs[] = $slug;
            Cache::put('cached_portfolio_slugs', $slugs, 3600);
        }

        return view('frontend.portfolio.show', $data);
    }
}
