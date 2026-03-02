<?php

namespace App\Services;

use App\Interfaces\TestimonialRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TestimonialService
{
    protected $testimonialRepository;

    public function __construct(TestimonialRepositoryInterface $testimonialRepository)
    {
        $this->testimonialRepository = $testimonialRepository;
    }

    public function getAllTestimonials()
    {
        return $this->testimonialRepository->getAll();
    }

    public function getTestimonialById($id)
    {
        return $this->testimonialRepository->findById($id);
    }

    public function createTestimonial(array $data)
    {
        DB::beginTransaction();

        try {
            // Process translations
            $translations = [];
            if (isset($data['translations']) && is_array($data['translations'])) {
                foreach ($data['translations'] as $locale => $translation) {
                    $translations[$locale] = [
                        'client_position' => $translation['client_position'] ?? null,
                        'content' => $translation['content'] ?? null,
                    ];
                }
            }

            // Handle image upload using Storage
            $avatarPath = null;
            if (isset($data['avatar'])) {
                $avatarPath = $data['avatar']->store('testimonials/avatars', 'public');
            }

            $testimonialData = [
                'id_project' => $data['id_project'] ?? null,
                'client_name' => $data['client_name'] ?? '',
                'avatar_path' => $avatarPath,
                'rating' => $data['rating'] ?? 5,
                'is_active' => $data['is_active'] ?? true,
                'sort_order' => $data['sort_order'] ?? 0,
            ];

            // Add translations to the main array for Astrotomic package to process
            $testimonialData = array_merge($testimonialData, $translations);

            $testimonial = $this->testimonialRepository->create($testimonialData);

            DB::commit();

            return $testimonial;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating testimonial: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function updateTestimonial($id, array $data)
    {
        $testimonial = $this->testimonialRepository->findById($id);

        if (!$testimonial) {
            throw new \Exception("Testimonial not found.");
        }

        DB::beginTransaction();

        try {
            // Process translations
            $translations = [];
            if (isset($data['translations']) && is_array($data['translations'])) {
                foreach ($data['translations'] as $locale => $translation) {
                    $translations[$locale] = [
                        'client_position' => $translation['client_position'] ?? null,
                        'content' => $translation['content'] ?? null,
                    ];
                }
            }

            $avatarPath = $testimonial->avatar_path;

            if (isset($data['avatar'])) {
                if ($avatarPath) {
                    Storage::disk('public')->delete($avatarPath);
                }
                $avatarPath = $data['avatar']->store('testimonials/avatars', 'public');
            } elseif (isset($data['remove_avatar']) && $data['remove_avatar'] == 1) {
                if ($avatarPath) {
                    Storage::disk('public')->delete($avatarPath);
                }
                $avatarPath = null;
            }

            $testimonialData = [
                'id_project' => $data['id_project'] ?? null,
                'client_name' => $data['client_name'] ?? $testimonial->client_name,
                'avatar_path' => $avatarPath,
                'rating' => $data['rating'] ?? $testimonial->rating,
                'is_active' => $data['is_active'] ?? $testimonial->is_active,
                'sort_order' => $data['sort_order'] ?? $testimonial->sort_order,
            ];

            $testimonialData = array_merge($testimonialData, $translations);
            $this->testimonialRepository->update($id, $testimonialData);

            // Fetch the updated testimonial
            $updatedTestimonial = $this->testimonialRepository->findById($id);

            DB::commit();

            return $updatedTestimonial;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating testimonial: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function deleteTestimonial($id)
    {
        $testimonial = $this->testimonialRepository->findById($id);

        if ($testimonial) {
            if ($testimonial->avatar_path) {
                Storage::disk('public')->delete($testimonial->avatar_path);
            }
            return $this->testimonialRepository->delete($id);
        }

        return false;
    }
}
