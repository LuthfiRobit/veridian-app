<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceBenefit;
use App\Models\ServiceProcess;
use App\Models\ServicePricing;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Service 1
        $service1 = Service::create([
            'icon_class' => 'bi bi-translate',
            'image_main' => 'assets/img/services/translation.jpg',
            'sort_order' => 1,
            'is_active' => true,
            'is_featured' => true,
        ]);

        $service1->translations()->createMany([
            [
                'locale' => 'en',
                'name' => 'Document Translation',
                'slug' => 'document-translation',
                'short_desc' => 'Professional translation services for all types of documents.',
                'content' => '<p>High quality document translation...</p>',
                'meta_title' => 'Document Translation',
                'meta_desc' => 'Best document translation services.',
            ],
            [
                'locale' => 'id',
                'name' => 'Terjemahan Dokumen',
                'slug' => 'terjemahan-dokumen',
                'short_desc' => 'Layanan terjemahan profesional untuk semua jenis dokumen.',
                'content' => '<p>Terjemahan dokumen berkualitas tinggi...</p>',
                'meta_title' => 'Terjemahan Dokumen',
                'meta_desc' => 'Layanan terjemahan dokumen terbaik.',
            ],
        ]);

        // Details for Service 1
        $benefit1 = ServiceBenefit::create([
            'id_service' => $service1->id_service,
            'icon_class' => 'bi bi-check',
            'sort_order' => 1,
        ]);

        $benefit1->translations()->createMany([
            ['locale' => 'en', 'title' => 'Accuracy', 'description' => '100% accurate translations.'],
            ['locale' => 'id', 'title' => 'Akurasi', 'description' => 'Terjemahan 100% akurat.'],
        ]);

        $process1 = ServiceProcess::create([
            'id_service' => $service1->id_service,
            'step_number' => 1,
        ]);

        $process1->translations()->createMany([
            ['locale' => 'en', 'title' => 'Analysis', 'description' => 'We analyze your document.'],
            ['locale' => 'id', 'title' => 'Analisis', 'description' => 'Kami menganalisis dokumen Anda.'],
        ]);

        $pricing1 = ServicePricing::create([
            'id_service' => $service1->id_service,
            'is_featured' => true,
            'sort_order' => 1,
        ]);

        $pricing1->translations()->createMany([
            [
                'locale' => 'en',
                'name' => 'Standard',
                'price_label' => '$100', // Dummy price
                'unit_label' => 'per page',
                'features_list' => ['Basic formatting', 'Proofreading']
            ],
            [
                'locale' => 'id',
                'name' => 'Standar',
                'price_label' => 'Rp 100.000', // Dummy price
                'unit_label' => 'per halaman',
                'features_list' => ['Pemformatan dasar', 'Koreksi']
            ],
        ]);

        // Service 2
        $service2 = Service::create([
            'icon_class' => 'bi bi-mic',
            'image_main' => 'assets/img/services/dubbing.jpg',
            'sort_order' => 2,
            'is_active' => true,
            'is_featured' => false,
        ]);

        $service2->translations()->createMany([
            [
                'locale' => 'en',
                'name' => 'Voice Over & Dubbing',
                'slug' => 'voice-over-dubbing',
                'short_desc' => 'Professional voice over services.',
                'content' => '<p>Top notch voice talents...</p>',
                'meta_title' => 'Voice Over',
                'meta_desc' => 'Professional voice over.',
            ],
            [
                'locale' => 'id',
                'name' => 'Pengisi Suara & Sulih Suara',
                'slug' => 'pengisi-suara-sulih-suara',
                'short_desc' => 'Layanan pengisi suara profesional.',
                'content' => '<p>Talenta suara terbaik...</p>',
                'meta_title' => 'Pengisi Suara',
                'meta_desc' => 'Pengisi suara profesional.',
            ],
        ]);

        // Details for Service 2
        $benefit2 = ServiceBenefit::create([
            'id_service' => $service2->id_service,
            'icon_class' => 'bi bi-soundwave',
            'sort_order' => 1,
        ]);

        $benefit2->translations()->createMany([
            ['locale' => 'en', 'title' => 'Clarity', 'description' => 'Crystal clear audio.'],
            ['locale' => 'id', 'title' => 'Kejernihan', 'description' => 'Audio sejernih kristal.'],
        ]);
    }
}
