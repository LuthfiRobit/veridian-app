<?php

namespace App\Repositories;

use App\Models\TeamMember;
use App\Interfaces\TeamMemberRepositoryInterface;

class TeamMemberRepository implements TeamMemberRepositoryInterface
{
    protected $model;

    public function __construct(TeamMember $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model
            ->with(['translations'])
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    public function findById($id)
    {
        return $this->model->with('translations')->findOrFail($id);
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
