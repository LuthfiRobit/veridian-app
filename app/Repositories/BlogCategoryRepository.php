<?php

namespace App\Repositories;

use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Builder;

class BlogCategoryRepository
{
    /**
     * Get a query builder for DataTables.
     * Selects specific columns and eager loads translations to prevent N+1.
     *
     * @return Builder
     */
    public function getForDataTable(): Builder
    {
        return BlogCategory::with('translations')->latest();
    }

    /**
     * Get all active categories for use in forms/dropdowns.
     */
    public function getActiveForDropdown()
    {
        return BlogCategory::where('is_active', true)
            ->with('translations')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id_blog_category,
                    'name' => $category->name,
                ];
            })
            ->pluck('name', 'id');
    }
}
