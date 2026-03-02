<?php

namespace App\Repositories;

use App\Interfaces\LanguageRepositoryInterface;
use App\Models\Language;
use Illuminate\Support\Facades\DB;

class LanguageRepository implements LanguageRepositoryInterface
{
    public function getAll()
    {
        return Language::query();
    }

    public function findById($id)
    {
        return Language::findOrFail($id);
    }

    public function create(array $data)
    {
        return Language::create($data);
    }

    public function update($id, array $data)
    {
        $language = Language::findOrFail($id);
        $language->update($data);
        return $language;
    }

    public function delete($id)
    {
        return Language::destroy($id);
    }

    public function setDefault($id)
    {
        DB::transaction(function () use ($id) {
            Language::where('is_default', true)->update(['is_default' => false]);
            Language::where('id_language', $id)->update(['is_default' => true]);
        });
    }
}
