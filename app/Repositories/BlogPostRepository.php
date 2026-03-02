<?php

namespace App\Repositories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Builder;

class BlogPostRepository
{
    /**
     * Get a query builder for DataTables.
     * Eager loads translations, category, and author to prevent N+1.
     *
     * @return Builder
     */
    public function getForDataTable(): Builder
    {
        return BlogPost::with([
            'translations',
            'category' => function ($query) {
                $query->select('id_blog_category', 'badge_color')
                    ->with('translations');
            },
            'author' => function ($query) {
                $query->select('id_user', 'name', 'author_title');
            }
        ])
            ->select('blog_posts.*');
    }
}
