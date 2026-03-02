<?php

namespace App\Repositories;

use App\Models\Inquiry;
use App\Interfaces\InquiryRepositoryInterface;

class InquiryRepository implements InquiryRepositoryInterface
{
    protected $model;

    public function __construct(Inquiry $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function markAsRead($id)
    {
        $inquiry = $this->findById($id);
        $inquiry->markAsRead();
        return $inquiry;
    }
}
