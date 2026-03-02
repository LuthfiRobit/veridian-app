<?php

namespace App\Interfaces;

interface InquiryRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function delete($id);
    public function markAsRead($id);
}
