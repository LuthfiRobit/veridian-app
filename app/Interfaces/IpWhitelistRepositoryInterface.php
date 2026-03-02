<?php

namespace App\Interfaces;

interface IpWhitelistRepositoryInterface
{
    public function getAllIpWhitelists();
    public function getIpWhitelistById($id);
    public function createIpWhitelist(array $data);
    public function updateIpWhitelist($id, array $data);
    public function deleteIpWhitelist($id);
}
