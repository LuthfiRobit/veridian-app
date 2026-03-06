<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Cache;

class BlogController extends Controller
{
    public function index($locale)
    {
        $fallback = config('app.fallback_locale');

        // Categories are cached (used for filter sidebar)
        $categories = Cache::remember("blog_categories_{$locale}", 3600, function () use ($locale, $fallback) {
            return BlogCategory::where('is_active', true)
                ->with([
                    'translations' => function ($query) use ($locale, $fallback) {
                        $query->where('locale', $locale)->orWhere('locale', $fallback);
                    }
                ])
                ->get();
        });

        // Blog posts are paginated — not cached to preserve pagination state
        $posts = BlogPost::where('status', 'published')
            ->with([
                'translations' => function ($query) use ($locale, $fallback) {
                    $query->where('locale', $locale)->orWhere('locale', $fallback);
                },
                'category',
                'category.translations' => function ($query) use ($locale, $fallback) {
                    $query->where('locale', $locale)->orWhere('locale', $fallback);
                },
                'author'
            ])
            ->orderBy('published_at', 'desc')
            ->paginate(6);

        return view('frontend.blog.index', compact('posts', 'categories', 'locale', 'fallback'));
    }

    public function show($locale, $slug)
    {
        $cacheKey = "blog_detail_{$locale}_{$slug}";

        $data = Cache::remember($cacheKey, 3600, function () use ($locale, $slug) {
            $fallback = config('app.fallback_locale');

            $post = BlogPost::whereTranslation('slug', $slug)
                ->where('status', 'published')
                ->with([
                    'translations' => function ($query) use ($locale, $fallback) {
                        $query->where('locale', $locale)->orWhere('locale', $fallback);
                    },
                    'category',
                    'category.translations' => function ($query) use ($locale, $fallback) {
                        $query->where('locale', $locale)->orWhere('locale', $fallback);
                    },
                    'author'
                ])
                ->firstOrFail();

            $relatedPosts = BlogPost::where('status', 'published')
                ->where('id_blog_category', $post->id_blog_category)
                ->where('id_blog_post', '!=', $post->id_blog_post)
                ->with([
                    'translations' => function ($query) use ($locale, $fallback) {
                        $query->where('locale', $locale)->orWhere('locale', $fallback);
                    },
                    'category',
                    'category.translations' => function ($query) use ($locale, $fallback) {
                        $query->where('locale', $locale)->orWhere('locale', $fallback);
                    }
                ])
                ->orderBy('published_at', 'desc')
                ->take(3)
                ->get();

            return compact('post', 'relatedPosts', 'locale', 'fallback');
        });

        // Increment views outside cache (always count real visits)
        $post = $data['post'];
        $post->timestamps = false; // Don't trigger observer for views_count
        $post->increment('views_count');
        $post->timestamps = true;

        // Register slug in the cache slug registry for invalidation
        $slugs = Cache::get('cached_blog_slugs', []);
        if (!in_array($slug, $slugs)) {
            $slugs[] = $slug;
            Cache::put('cached_blog_slugs', $slugs, 3600);
        }

        return view('frontend.blog.show', $data);
    }
}
