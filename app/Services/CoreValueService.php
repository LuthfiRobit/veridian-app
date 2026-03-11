<?php

namespace App\Services;

use App\Interfaces\CoreValueRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CoreValueService
{
    protected $coreValueRepository;

    public function __construct(CoreValueRepositoryInterface $coreValueRepository)
    {
        $this->coreValueRepository = $coreValueRepository;
    }

    public function getAllCoreValues()
    {
        return $this->coreValueRepository->getAll();
    }

    public function getCoreValueById($id)
    {
        return $this->coreValueRepository->findById($id);
    }

    public function createCoreValue(array $data)
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

            $coreValueData = [
                'icon_class' => $data['icon_class'] ?? 'bi bi-shield-check',
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active' => $data['is_active'] ?? true,
            ];

            $coreValueData = array_merge($coreValueData, $translations);
            $coreValue = $this->coreValueRepository->create($coreValueData);

            activity()
                ->performedOn($coreValue)
                ->causedBy(auth()->user())
                ->log('Created Core Value');

            DB::commit();
            return $coreValue;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating core value: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function updateCoreValue($id, array $data)
    {
        $coreValue = $this->coreValueRepository->findById($id);

        if (!$coreValue) {
            throw new \Exception("Core Value not found.");
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

            $coreValueData = [
                'icon_class' => $data['icon_class'] ?? $coreValue->icon_class,
                'sort_order' => $data['sort_order'] ?? $coreValue->sort_order,
                'is_active' => $data['is_active'] ?? $coreValue->is_active,
            ];

            $coreValueData = array_merge($coreValueData, $translations);
            $this->coreValueRepository->update($id, $coreValueData);

            $updatedCoreValue = $this->coreValueRepository->findById($id);

            activity()
                ->performedOn($updatedCoreValue)
                ->causedBy(auth()->user())
                ->log('Updated Core Value');

            DB::commit();
            return $updatedCoreValue;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating core value: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function deleteCoreValue($id)
    {
        $coreValue = $this->coreValueRepository->findById($id);

        if ($coreValue) {
            $deleted = $this->coreValueRepository->delete($id);

            activity()
                ->performedOn($coreValue)
                ->causedBy(auth()->user())
                ->log('Deleted Core Value');

            return $deleted;
        }

        return false;
    }
}
