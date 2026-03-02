<?php

namespace App\Services;

use App\Interfaces\InquiryRepositoryInterface;

class InquiryService
{
    protected $inquiryRepository;

    public function __construct(InquiryRepositoryInterface $inquiryRepository)
    {
        $this->inquiryRepository = $inquiryRepository;
    }

    public function getAllInquiries()
    {
        return $this->inquiryRepository->getAll();
    }

    public function getInquiryById($id)
    {
        return $this->inquiryRepository->findById($id);
    }

    public function markAsRead($id)
    {
        return $this->inquiryRepository->markAsRead($id);
    }

    public function deleteInquiry($id)
    {
        return $this->inquiryRepository->delete($id);
    }
}
