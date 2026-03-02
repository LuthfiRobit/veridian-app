<?php

namespace Database\Seeders;

use App\Models\IpWhitelist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IpWhitelistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IpWhitelist::firstOrCreate(
            ['ip_address' => '127.0.0.1'],
            ['label' => 'Localhost IPv4', 'is_active' => true]
        );

        IpWhitelist::firstOrCreate(
            ['ip_address' => '::1'],
            ['label' => 'Localhost IPv6', 'is_active' => true]
        );
    }
}
