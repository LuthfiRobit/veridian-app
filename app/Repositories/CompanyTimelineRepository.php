<?php

namespace App\Repositories;

use App\Models\CompanyTimeline;
use App\Interfaces\CompanyTimelineRepositoryInterface;

class CompanyTimelineRepository implements CompanyTimelineRepositoryInterface
{
    protected $model;

    public function __construct(CompanyTimeline $model)
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
