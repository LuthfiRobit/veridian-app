<?php

namespace App\Interfaces;

interface ServiceRepositoryInterface
{
    public function getAllServices();
    public function getServiceById($id);
    public function createService(array $data);
    public function updateService($id, array $data);
    public function deleteService($id);
}
