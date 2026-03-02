<?php

namespace App\Services;

use App\Models\BlogPost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostService
{
    public function createPost(array $data)
    {
        DB::beginTransaction();
        try {
            Log::info('BlogPost Create Payload:', $data);

            $translations = $data['translations'] ?? [];
            $translations = array_filter($translations, function ($t) {
                return !empty($t['title']);
            });

            if (!empty($translations)) {
                foreach ($translations as $locale => $tData) {
                    if (empty($tData['slug'])) {
                        $translations[$locale]['slug'] = Str::slug($tData['title']);
                    }
                }
            }

            $postData = $data;
            unset($postData['translations']);

            if (isset($postData['image_featured']) && $postData['image_featured'] instanceof \Illuminate\Http\UploadedFile) {
                $file = $postData['image_featured'];
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('blog', $filename, 'public');
                $postData['image_featured'] = 'storage/' . $path;
            }

            $postData['id_author'] = auth()->id();
            $postData['created_by'] = auth()->id();

            if ($postData['status'] === 'published' && empty($postData['published_at'])) {
                $postData['published_at'] = now();
            } elseif ($postData['status'] === 'draft') {
                $postData['published_at'] = null;
            }

            $post = BlogPost::create($postData);

            if (!empty($translations)) {
                foreach ($translations as $locale => $tData) {
                    $post->translateOrNew($locale)->fill($tData);
                }
                $post->save();
            }

            activity()
                ->performedOn($post)
                ->causedBy(auth()->user())
                ->log('Created Blog Post');

            DB::commit();
            return $post;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Create Blog Post Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updatePost(BlogPost $post, array $data)
    {
        DB::beginTransaction();
        try {
            $translations = $data['translations'] ?? [];
            $translations = array_filter($translations, function ($t) {
                return !empty($t['title']);
            });

            if (!empty($translations)) {
                foreach ($translations as $locale => $tData) {
                    if (empty($tData['slug'])) {
                        $translations[$locale]['slug'] = Str::slug($tData['title']);
                    }
                }
            }

            $postData = $data;
            unset($postData['translations']);

            if (isset($postData['image_featured']) && $postData['image_featured'] instanceof \Illuminate\Http\UploadedFile) {
                if ($post->image_featured) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $post->image_featured));
                }

                $file = $postData['image_featured'];
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('blog', $filename, 'public');
                $postData['image_featured'] = 'storage/' . $path;
            }

            $postData['updated_by'] = auth()->id();

            if ($postData['status'] === 'published' && empty($postData['published_at'])) {
                $postData['published_at'] = $post->published_at ?? now();
            } elseif ($postData['status'] === 'draft') {
                $postData['published_at'] = null;
            }

            $post->update($postData);

            if (!empty($translations)) {
                foreach ($translations as $locale => $tData) {
                    $post->translateOrNew($locale)->fill($tData);
                }
                $post->save();
            }

            activity()
                ->performedOn($post)
                ->causedBy(auth()->user())
                ->log('Updated Blog Post');

            DB::commit();
            return $post;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update Blog Post Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deletePost(BlogPost $post)
    {
        DB::beginTransaction();
        try {
            if ($post->image_featured) {
                Storage::disk('public')->delete(str_replace('storage/', '', $post->image_featured));
            }

            $post->delete();

            activity()
                ->performedOn($post)
                ->causedBy(auth()->user())
                ->log('Deleted Blog Post');

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delete Blog Post Failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
