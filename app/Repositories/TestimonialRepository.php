<?php

namespace App\Repositories;

use App\Models\Testimonial;
use App\Interfaces\TestimonialRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TestimonialRepository implements TestimonialRepositoryInterface
{
    protected $model;

    public function __construct(Testimonial $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with(['translations', 'project.translations'])->orderBy('sort_order', 'asc')->get();
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
