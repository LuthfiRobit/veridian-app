<?php

namespace App\Repositories;

use App\Models\CoreValue;
use App\Interfaces\CoreValueRepositoryInterface;

class CoreValueRepository implements CoreValueRepositoryInterface
{
    protected $model;

    public function __construct(CoreValue $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with('translations')->orderBy('sort_order', 'asc')->get();
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->model->findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
