<?php

namespace App\Services;

use App\Interfaces\CertificationRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CertificationService
{
    protected $repository;

    public function __construct(CertificationRepositoryInterface $repository)
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
                        'name' => $translation['name'] ?? null,
                        'description' => $translation['description'] ?? null,
                    ];
                }
            }

            $certData = [
                'icon_class' => $data['icon_class'] ?? 'bi bi-patch-check',
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active' => $data['is_active'] ?? true,
            ];

            $certData = array_merge($certData, $translations);
            $cert = $this->repository->create($certData);

            activity()
                ->performedOn($cert)
                ->causedBy(auth()->user())
                ->log('Created Certification');

            DB::commit();
            return $cert;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating certification: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        $cert = $this->repository->findById($id);
        if (!$cert) {
            throw new \Exception("Certification not found.");
        }

        DB::beginTransaction();
        try {
            $translations = [];
            if (isset($data['translations']) && is_array($data['translations'])) {
                foreach ($data['translations'] as $locale => $translation) {
                    $translations[$locale] = [
                        'name' => $translation['name'] ?? null,
                        'description' => $translation['description'] ?? null,
                    ];
                }
            }

            $certData = [
                'icon_class' => $data['icon_class'] ?? $cert->icon_class,
                'sort_order' => $data['sort_order'] ?? $cert->sort_order,
                'is_active' => $data['is_active'] ?? $cert->is_active,
            ];

            $certData = array_merge($certData, $translations);
            $this->repository->update($id, $certData);
            $updated = $this->repository->findById($id);

            activity()
                ->performedOn($updated)
                ->causedBy(auth()->user())
                ->log('Updated Certification');

            DB::commit();
            return $updated;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating certification: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function delete($id)
    {
        $cert = $this->repository->findById($id);
        if ($cert) {
            $deleted = $this->repository->delete($id);

            activity()
                ->performedOn($cert)
                ->causedBy(auth()->user())
                ->log('Deleted Certification');

            return $deleted;
        }
        return false;
    }
}
