<?php

namespace App\Services;

use App\Interfaces\ProjectRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectService
{
    protected $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getAllProjects()
    {
        return $this->projectRepository->getAllProjects();
    }

    public function getProjectById($id)
    {
        return $this->projectRepository->getProjectById($id);
    }

    public function createProject(array $data)
    {
        DB::beginTransaction();
        try {
            Log::info('Project Create Payload:', $data);

            // Pre-process translations
            $translations = $data['translations'] ?? [];
            $translations = array_filter($translations, function ($translationData) {
                return !empty($translationData['title']);
            });

            if (!empty($translations)) {
                foreach ($translations as $locale => $translationData) {
                    if (empty($translationData['slug'])) {
                        $translations[$locale]['slug'] = Str::slug($translationData['title']);
                    }
                }
            }

            // 1. Create main project record
            $projectData = $data;
            unset($projectData['translations']);

            // Handle Image Upload
            if (isset($projectData['image_thumbnail']) && $projectData['image_thumbnail'] instanceof \Illuminate\Http\UploadedFile) {
                $file = $projectData['image_thumbnail'];
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('projects', $filename, 'public');
                $projectData['image_thumbnail'] = 'storage/' . $path;
            }

            $projectData['created_by'] = auth()->id();
            $project = $this->projectRepository->createProject($projectData);

            // 2. Handle Translations
            if (!empty($translations)) {
                foreach ($translations as $locale => $translationData) {
                    $project->translateOrNew($locale)->fill($translationData);
                }
                $project->save();
            }

            // Log Activity
            activity()
                ->performedOn($project)
                ->causedBy(auth()->user())
                ->log('Created Project');

            DB::commit();
            return $project;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Create Project Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateProject($id, array $data)
    {
        DB::beginTransaction();
        try {
            // Pre-process translations
            $translations = $data['translations'] ?? [];
            $translations = array_filter($translations, function ($translationData) {
                return !empty($translationData['title']);
            });

            if (!empty($translations)) {
                foreach ($translations as $locale => $translationData) {
                    if (empty($translationData['slug'])) {
                        $translations[$locale]['slug'] = Str::slug($translationData['title']);
                    }
                }
            }

            // 1. Update main record
            $projectData = $data;
            unset($projectData['translations']);

            // Handle Image Upload
            if (isset($projectData['image_thumbnail']) && $projectData['image_thumbnail'] instanceof \Illuminate\Http\UploadedFile) {
                $oldProject = $this->projectRepository->getProjectById($id);
                if ($oldProject->image_thumbnail) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $oldProject->image_thumbnail));
                }

                $file = $projectData['image_thumbnail'];
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('projects', $filename, 'public');
                $projectData['image_thumbnail'] = 'storage/' . $path;
            }

            $projectData['updated_by'] = auth()->id();
            $project = $this->projectRepository->updateProject($id, $projectData);

            // 2. Handle Translations
            if (!empty($translations)) {
                foreach ($translations as $locale => $translationData) {
                    $project->translateOrNew($locale)->fill($translationData);
                }
                $project->save();
            }

            // Log Activity
            activity()
                ->performedOn($project)
                ->causedBy(auth()->user())
                ->log('Updated Project');

            DB::commit();
            return $project;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update Project Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteProject($id)
    {
        $project = $this->projectRepository->getProjectById($id);

        if ($project->image_thumbnail) {
            Storage::disk('public')->delete(str_replace('storage/', '', $project->image_thumbnail));
        }

        foreach ($project->images as $image) {
            if ($image->image_path) {
                Storage::disk('public')->delete(str_replace('storage/', '', $image->image_path));
            }
        }

        $deletedProject = $this->projectRepository->deleteProject($id);

        // Log Activity
        activity()
            ->performedOn($deletedProject)
            ->causedBy(auth()->user())
            ->log('Deleted Project');

        return $deletedProject;
    }
}
