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
        $inquiry = $this->inquiryRepository->findById($id);
        $result = $this->inquiryRepository->markAsRead($id);

        activity()
            ->performedOn($inquiry)
            ->causedBy(auth()->user())
            ->log('Marked Inquiry as Read');

        return $result;
    }

    public function deleteInquiry($id)
    {
        $inquiry = $this->inquiryRepository->findById($id);
        $result = $this->inquiryRepository->delete($id);

        activity()
            ->performedOn($inquiry)
            ->causedBy(auth()->user())
            ->log('Deleted Inquiry');

        return $result;
    }
}
