<?php

namespace App\Services;

use App\Models\BlogCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BlogCategoryService
{
    public function createCategory(array $data)
    {
        DB::beginTransaction();
        try {
            Log::info('BlogCategory Create Payload:', $data);

            $translations = $data['translations'] ?? [];
            $translations = array_filter($translations, function ($t) {
                return !empty($t['name']);
            });

            if (!empty($translations)) {
                foreach ($translations as $locale => $tData) {
                    if (empty($tData['slug'])) {
                        $translations[$locale]['slug'] = Str::slug($tData['name']);
                    }
                }
            }

            $categoryData = $data;
            unset($categoryData['translations']);
            $categoryData['created_by'] = auth()->id();

            $category = BlogCategory::create($categoryData);

            if (!empty($translations)) {
                foreach ($translations as $locale => $tData) {
                    $category->translateOrNew($locale)->fill($tData);
                }
                $category->save();
            }

            activity()
                ->performedOn($category)
                ->causedBy(auth()->user())
                ->log('Created Blog Category');

            DB::commit();
            return $category;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Create Blog Category Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateCategory(BlogCategory $category, array $data)
    {
        DB::beginTransaction();
        try {
            $translations = $data['translations'] ?? [];
            $translations = array_filter($translations, function ($t) {
                return !empty($t['name']);
            });

            if (!empty($translations)) {
                foreach ($translations as $locale => $tData) {
                    if (empty($tData['slug'])) {
                        $translations[$locale]['slug'] = Str::slug($tData['name']);
                    }
                }
            }

            $categoryData = $data;
            unset($categoryData['translations']);
            $categoryData['updated_by'] = auth()->id();

            $category->update($categoryData);

            if (!empty($translations)) {
                foreach ($translations as $locale => $tData) {
                    $category->translateOrNew($locale)->fill($tData);
                }
                $category->save();
            }

            activity()
                ->performedOn($category)
                ->causedBy(auth()->user())
                ->log('Updated Blog Category');

            DB::commit();
            return $category;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update Blog Category Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteCategory(BlogCategory $category)
    {
        DB::beginTransaction();
        try {
            $category->delete();

            activity()
                // Cannot performOn deleted model directly in some versions, but works if soft deleted. For hard delete, passing class/id is safer.
                ->performedOn($category)
                ->causedBy(auth()->user())
                ->log('Deleted Blog Category');

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delete Blog Category Failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
