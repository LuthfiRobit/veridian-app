<?php

namespace App\Services;

use App\Interfaces\ServiceRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ServiceService
{
    protected $serviceRepository;

    public function __construct(ServiceRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function getAllServices()
    {
        return $this->serviceRepository->getAllServices();
    }

    public function getServiceById($id)
    {
        return $this->serviceRepository->getServiceById($id);
    }

    public function createService(array $data)
    {
        DB::beginTransaction();
        try {
            Log::info('Service Create Payload:', $data);

            // Pre-process translations to ensure slugs exist AND filter out empty ones
            $translations = $data['translations'] ?? [];

            // CRITICAL: Remove translations with empty name (prevents duplication)
            $translations = array_filter($translations, function ($translationData) {
                return !empty($translationData['name']);
            });

            if (!empty($translations)) {
                foreach ($translations as $locale => $translationData) {
                    if (empty($translationData['slug'])) {
                        $translations[$locale]['slug'] = Str::slug($translationData['name']);
                    }
                }
            }

            // 1. Create the main service record (Exclude translations to prevent double-handling)
            $serviceData = $data;
            unset($serviceData['translations']);

            // Handle Image Upload
            if (isset($serviceData['image_main']) && $serviceData['image_main'] instanceof \Illuminate\Http\UploadedFile) {
                $file = $serviceData['image_main'];
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('services', $filename, 'public');
                $serviceData['image_main'] = $path;
            }

            $serviceData['created_by'] = auth()->id();
            $service = $this->serviceRepository->createService($serviceData);

            // 2. Handle Translations (only non-empty ones)
            if (!empty($translations)) {
                Log::info('Starting translation save loop');
                foreach ($translations as $locale => $translationData) {
                    Log::info("Processing locale: {$locale}", $translationData);
                    $translation = $service->translateOrNew($locale);
                    Log::info("Before fill - Locale: {$locale}, Translation object locale: " . ($translation->locale ?? 'NULL'));
                    $translation->fill($translationData);
                    Log::info("After fill - Name: {$translation->name}, Slug: {$translation->slug}");
                }
                Log::info('About to save service with translations');
                $service->save(); // Save translations
                Log::info('Service saved. Checking translations in DB...');
            }

            // Log Activity
            activity()
                ->performedOn($service)
                ->causedBy(auth()->user())
                ->log('Created Service');

            DB::commit();
            return $service;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Create Service Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateService($id, array $data)
    {
        DB::beginTransaction();
        try {
            // Pre-process translations to ensure slugs exist AND filter out empty ones
            $translations = $data['translations'] ?? [];

            // CRITICAL: Remove translations with empty name (prevents duplication)
            $translations = array_filter($translations, function ($translationData) {
                return !empty($translationData['name']);
            });

            if (!empty($translations)) {
                foreach ($translations as $locale => $translationData) {
                    if (empty($translationData['slug'])) {
                        $translations[$locale]['slug'] = Str::slug($translationData['name']);
                    }
                }
            }

            // 1. Update main record
            $serviceData = $data;
            unset($serviceData['translations']);

            // Handle Image Upload
            if (isset($serviceData['image_main']) && $serviceData['image_main'] instanceof \Illuminate\Http\UploadedFile) {
                $file = $serviceData['image_main'];
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('services', $filename, 'public');
                $serviceData['image_main'] = $path;

                // TODO: Delete old image if needed (requires fetching old service data first)
            }

            $serviceData['updated_by'] = auth()->id();
            $service = $this->serviceRepository->updateService($id, $serviceData);

            // 2. Handle Translations (only non-empty ones)
            if (!empty($translations)) {
                foreach ($translations as $locale => $translationData) {
                    $service->translateOrNew($locale)->fill($translationData);
                }
                $service->save();
            }

            // Log Activity
            activity()
                ->performedOn($service)
                ->causedBy(auth()->user())
                ->log('Updated Service');

            DB::commit();
            return $service;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update Service Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteService($id)
    {
        $service = $this->serviceRepository->deleteService($id);

        // Log Activity
        activity()
            ->performedOn($service)
            ->causedBy(auth()->user())
            ->log('Deleted Service');

        return $service;
    }
}
