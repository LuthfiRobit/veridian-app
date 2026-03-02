<?php

namespace App\Repositories;

use App\Interfaces\IpWhitelistRepositoryInterface;
use App\Models\IpWhitelist;

class IpWhitelistRepository implements IpWhitelistRepositoryInterface
{
    public function getAllIpWhitelists()
    {
        return IpWhitelist::orderBy('created_at', 'desc')->get();
    }

    public function getIpWhitelistById($id)
    {
        return IpWhitelist::findOrFail($id);
    }

    public function createIpWhitelist(array $data)
    {
        return IpWhitelist::create($data);
    }

    public function updateIpWhitelist($id, array $data)
    {
        $ip = IpWhitelist::findOrFail($id);
        $ip->update($data);
        return $ip;
    }

    public function deleteIpWhitelist($id)
    {
        $ip = IpWhitelist::findOrFail($id);
        $ip->delete();
        return $ip;
    }
}
