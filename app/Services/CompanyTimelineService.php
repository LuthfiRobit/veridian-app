<?php

namespace App\Services;

use App\Interfaces\CompanyTimelineRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompanyTimelineService
{
    protected $repository;

    public function __construct(CompanyTimelineRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function findById($id)
    {
        return $this->repository->findById($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $translations = [];
            if (isset($data['translations']) && is_array($data['translations'])) {
                foreach ($data['translations'] as $locale => $translation) {
                    $translations[$locale] = [
                        'title' => $translation['title'] ?? null,
                        'description' => $translation['description'] ?? null,
                    ];
                }
            }

            $timelineData = [
                'year' => $data['year'] ?? '',
                'icon_class' => $data['icon_class'] ?? 'bi bi-flag',
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active' => $data['is_active'] ?? true,
            ];

            $timelineData = array_merge($timelineData, $translations);
            $timeline = $this->repository->create($timelineData);

            DB::commit();
            return $timeline;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating company timeline: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        $timeline = $this->repository->findById($id);
        if (!$timeline) {
            throw new \Exception("Company Timeline not found.");
        }

        DB::beginTransaction();
        try {
            $translations = [];
            if (isset($data['translations']) && is_array($data['translations'])) {
                foreach ($data['translations'] as $locale => $translation) {
                    $translations[$locale] = [
                        'title' => $translation['title'] ?? null,
                        'description' => $translation['description'] ?? null,
                    ];
                }
            }

            $timelineData = [
                'year' => $data['year'] ?? $timeline->year,
                'icon_class' => $data['icon_class'] ?? $timeline->icon_class,
                'sort_order' => $data['sort_order'] ?? $timeline->sort_order,
                'is_active' => $data['is_active'] ?? $timeline->is_active,
            ];

            $timelineData = array_merge($timelineData, $translations);
            $this->repository->update($id, $timelineData);
            $updated = $this->repository->findById($id);

            DB::commit();
            return $updated;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating company timeline: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function delete($id)
    {
        $timeline = $this->repository->findById($id);
        if ($timeline) {
            return $this->repository->delete($id);
        }
        return false;
    }
}
