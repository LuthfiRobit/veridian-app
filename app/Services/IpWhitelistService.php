<?php

namespace App\Services;

use App\Interfaces\IpWhitelistRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class IpWhitelistService
{
    protected $ipWhitelistRepository;

    public function __construct(IpWhitelistRepositoryInterface $ipWhitelistRepository)
    {
        $this->ipWhitelistRepository = $ipWhitelistRepository;
    }

    public function getAllIpWhitelists()
    {
        return $this->ipWhitelistRepository->getAllIpWhitelists();
    }

    public function getIpWhitelistById($id)
    {
        return $this->ipWhitelistRepository->getIpWhitelistById($id);
    }

    public function createIpWhitelist(array $data)
    {
        // Add creator info if not present (handled by Trait usually but good to ensure data integrity)
        $data['created_by'] = auth()->id();

        $ip = $this->ipWhitelistRepository->createIpWhitelist($data);

        // Clear Cache
        Cache::forget('ip_whitelist_active');

        // Log Activity
        activity()
            ->performedOn($ip)
            ->causedBy(auth()->user())
            ->withProperties(['ip_address' => $ip->ip_address, 'label' => $ip->label])
            ->log('Created IP Whitelist');

        return $ip;
    }

    public function updateIpWhitelist($id, array $data)
    {
        $data['updated_by'] = auth()->id();

        $ip = $this->ipWhitelistRepository->updateIpWhitelist($id, $data);

        // Clear Cache
        Cache::forget('ip_whitelist_active');

        // Log Activity
        activity()
            ->performedOn($ip)
            ->causedBy(auth()->user())
            ->withProperties(['ip_address' => $ip->ip_address, 'changes' => $data])
            ->log('Updated IP Whitelist');

        return $ip;
    }

    public function deleteIpWhitelist($id)
    {
        $ip = $this->ipWhitelistRepository->deleteIpWhitelist($id);

        // Clear Cache
        Cache::forget('ip_whitelist_active');

        // Log Activity
        activity()
            ->performedOn($ip)
            ->causedBy(auth()->user())
            ->withProperties(['ip_address' => $ip->ip_address])
            ->log('Deleted IP Whitelist');

        return $ip;
    }
}
