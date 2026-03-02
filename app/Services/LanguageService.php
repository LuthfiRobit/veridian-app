<?php

namespace App\Services;

use App\Interfaces\LanguageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class LanguageService extends BaseService
{
    protected $languageRepository;

    public function __construct(LanguageRepositoryInterface $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function getAllLanguages()
    {
        return $this->languageRepository->getAll();
    }

    public function getLanguageById($id)
    {
        return $this->languageRepository->findById($id);
    }

    public function createLanguage(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['is_default']) && $data['is_default']) {
                $this->languageRepository->setDefault(null); // Clear existing default if needed logic handled in Repo
                // Actually repo's setDefault handles the toggle, but here we might just create first then set default
                // Let's refine: If new one is default, we unset others first
                // The repository create method is simple. We can add logic here or repository.
                // Repository pattern usually keeps logic simple. Let's rely on Repo's transactional scope if possible, 
                // but since we need to toggle, let's do it here or in repo specific method.
            }
            // For now, let's handle the is_default logic inside the repository or here.
            // Best practice: Service handles business logic.

            if (isset($data['is_default']) && $data['is_default']) {
                // We can use a method in repo to unset all defaults
                // But for now, let's keep it simple as per previous controller logic
                // We will move that logic to Repository or keep here.
                // The Blueprint says "Service Layer" for business logic.
                \App\Models\Language::where('is_default', true)->update(['is_default' => false]);
            }

            $language = $this->languageRepository->create($data);

            // Clear cached default code whenever languages change
            \App\Models\Language::clearDefaultCodeCache();

            activity()
                ->performedOn($language)
                ->log('created');

            return $language;
        });
    }

    public function updateLanguage($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            if (isset($data['is_default']) && $data['is_default']) {
                \App\Models\Language::where('is_default', true)->update(['is_default' => false]);
            }

            $language = $this->languageRepository->update($id, $data);

            // Clear cached default code whenever languages change
            \App\Models\Language::clearDefaultCodeCache();

            activity()
                ->performedOn($language)
                ->log('updated');

            return $language;
        });
    }

    public function deleteLanguage($id)
    {
        $language = $this->languageRepository->findById($id);

        if ($language->is_default) {
            throw new Exception("Cannot delete default language.");
        }

        $result = $this->languageRepository->delete($id);

        activity()
            ->performedOn($language)
            ->log('deleted');

        return $result;
    }
}
