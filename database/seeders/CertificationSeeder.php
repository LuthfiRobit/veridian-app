<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Certification;

class CertificationSeeder extends Seeder
{
    public function run(): void
    {
        $certs = [
            [
                'icon_class' => 'bi bi-patch-check',
                'sort_order' => 1,
                'en' => ['name' => 'ISO 9001:2015', 'description' => 'Quality Management Systems'],
                'id' => ['name' => 'ISO 9001:2015', 'description' => 'Sistem Manajemen Mutu'],
            ],
            [
                'icon_class' => 'bi bi-translate',
                'sort_order' => 2,
                'en' => ['name' => 'ISO 17100:2015', 'description' => 'Translation Services — Requirements'],
                'id' => ['name' => 'ISO 17100:2015', 'description' => 'Layanan Terjemahan — Persyaratan'],
            ],
            [
                'icon_class' => 'bi bi-shield-check',
                'sort_order' => 3,
                'en' => ['name' => 'ISO 27001', 'description' => 'Information Security Management'],
                'id' => ['name' => 'ISO 27001', 'description' => 'Manajemen Keamanan Informasi'],
            ],
            [
                'icon_class' => 'bi bi-award',
                'sort_order' => 4,
                'en' => ['name' => 'ATA Certified', 'description' => 'American Translators Association'],
                'id' => ['name' => 'Bersertifikat ATA', 'description' => 'American Translators Association'],
            ],
        ];

        foreach ($certs as $c) {
            $cert = Certification::create([
                'icon_class' => $c['icon_class'],
                'sort_order' => $c['sort_order'],
                'is_active' => true,
            ]);

            $cert->translations()->createMany([
                array_merge(['locale' => 'en'], $c['en']),
                array_merge(['locale' => 'id'], $c['id'])
            ]);
        }
    }
}
