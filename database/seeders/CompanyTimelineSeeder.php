<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyTimeline;

class CompanyTimelineSeeder extends Seeder
{
    public function run(): void
    {
        $milestones = [
            [
                'year' => '2009',
                'icon_class' => 'bi bi-flag',
                'sort_order' => 1,
                'en' => ['title' => 'Company Founded', 'description' => 'Veridian Solutions was established with a mission to bridge language gaps in business communication.'],
                'id' => ['title' => 'Perusahaan Didirikan', 'description' => 'Veridian Solutions didirikan dengan misi menjembatani kesenjangan bahasa dalam komunikasi bisnis.'],
            ],
            [
                'year' => '2012',
                'icon_class' => 'bi bi-globe',
                'sort_order' => 2,
                'en' => ['title' => 'International Expansion', 'description' => 'Expanded services to cover 25+ languages and opened our first international office.'],
                'id' => ['title' => 'Ekspansi Internasional', 'description' => 'Memperluas layanan untuk mencakup 25+ bahasa dan membuka kantor internasional pertama.'],
            ],
            [
                'year' => '2015',
                'icon_class' => 'bi bi-patch-check',
                'sort_order' => 3,
                'en' => ['title' => 'ISO Certification', 'description' => 'Achieved ISO 9001:2015 and ISO 17100:2015 certifications for quality management and translation services.'],
                'id' => ['title' => 'Sertifikasi ISO', 'description' => 'Meraih sertifikasi ISO 9001:2015 dan ISO 17100:2015 untuk manajemen mutu dan layanan terjemahan.'],
            ],
            [
                'year' => '2018',
                'icon_class' => 'bi bi-camera-video',
                'sort_order' => 4,
                'en' => ['title' => 'Multimedia Services', 'description' => 'Launched professional dubbing and subtitling services for film, TV, and digital content.'],
                'id' => ['title' => 'Layanan Multimedia', 'description' => 'Meluncurkan layanan dubbing dan subtitling profesional untuk film, TV, dan konten digital.'],
            ],
            [
                'year' => '2020',
                'icon_class' => 'bi bi-trophy',
                'sort_order' => 5,
                'en' => ['title' => '500+ Projects Milestone', 'description' => 'Completed over 500 projects for clients across 30+ countries worldwide.'],
                'id' => ['title' => 'Pencapaian 500+ Proyek', 'description' => 'Menyelesaikan lebih dari 500 proyek untuk klien di 30+ negara di seluruh dunia.'],
            ],
            [
                'year' => '2022',
                'icon_class' => 'bi bi-lightbulb',
                'sort_order' => 6,
                'en' => ['title' => 'AI Integration', 'description' => 'Integrated AI-powered translation tools to enhance efficiency while maintaining human quality standards.'],
                'id' => ['title' => 'Integrasi AI', 'description' => 'Mengintegrasikan alat terjemahan bertenaga AI untuk meningkatkan efisiensi sambil mempertahankan standar kualitas manusia.'],
            ],
            [
                'year' => '2024',
                'icon_class' => 'bi bi-rocket-takeoff',
                'sort_order' => 7,
                'en' => ['title' => 'Global Leadership', 'description' => 'Recognized as a leading language service provider in Southeast Asia with 50+ supported languages.'],
                'id' => ['title' => 'Kepemimpinan Global', 'description' => 'Diakui sebagai penyedia layanan bahasa terkemuka di Asia Tenggara dengan 50+ bahasa yang didukung.'],
            ],
        ];

        foreach ($milestones as $m) {
            $timeline = CompanyTimeline::create([
                'year' => $m['year'],
                'icon_class' => $m['icon_class'],
                'sort_order' => $m['sort_order'],
                'is_active' => true,
            ]);

            $timeline->translateOrNew('en')->fill($m['en']);
            $timeline->translateOrNew('id')->fill($m['id']);
            $timeline->save();
        }
    }
}
