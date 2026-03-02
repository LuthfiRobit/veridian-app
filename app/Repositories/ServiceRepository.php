<?php

namespace App\Repositories;

use App\Interfaces\ServiceRepositoryInterface;
use App\Models\Service;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function getAllServices()
    {
        // Eager load translations to avoid N+1 issues
        return Service::with('translations')->orderBy('sort_order', 'asc')->get();
    }

    public function getServiceById($id)
    {
        return Service::with('translations')->findOrFail($id);
    }

    public function createService(array $data)
    {
        return Service::create($data);
    }

    public function updateService($id, array $data)
    {
        $service = Service::findOrFail($id);
        $service->update($data);
        return $service;
    }

    public function deleteService($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return $service;
    }
}
