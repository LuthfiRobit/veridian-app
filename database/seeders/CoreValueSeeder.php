<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CoreValue;

class CoreValueSeeder extends Seeder
{
    public function run(): void
    {
        $values = [
            [
                'icon_class' => 'bi bi-shield-check',
                'sort_order' => 1,
                'en' => ['title' => 'Accuracy & Quality', 'description' => 'We maintain the highest standards of accuracy with rigorous quality control processes, including multi-tier review and proofreading by native speakers.'],
                'id' => ['title' => 'Akurasi & Kualitas', 'description' => 'Kami menjaga standar akurasi tertinggi dengan proses kontrol kualitas yang ketat, termasuk review multi-tingkat dan proofreading oleh penutur asli.'],
            ],
            [
                'icon_class' => 'bi bi-people',
                'sort_order' => 2,
                'en' => ['title' => 'Cultural Sensitivity', 'description' => 'Our translations go beyond words — we ensure cultural nuances, idioms, and context are properly adapted for your target audience.'],
                'id' => ['title' => 'Sensitivitas Budaya', 'description' => 'Terjemahan kami melampaui kata-kata — kami memastikan nuansa budaya, idiom, dan konteks diadaptasi dengan tepat untuk audiens target Anda.'],
            ],
            [
                'icon_class' => 'bi bi-clock',
                'sort_order' => 3,
                'en' => ['title' => 'Timely Delivery', 'description' => 'We understand the importance of deadlines. Our efficient project management ensures on-time delivery without compromising quality.'],
                'id' => ['title' => 'Pengiriman Tepat Waktu', 'description' => 'Kami memahami pentingnya tenggat waktu. Manajemen proyek kami yang efisien memastikan pengiriman tepat waktu tanpa mengorbankan kualitas.'],
            ],
            [
                'icon_class' => 'bi bi-lock',
                'sort_order' => 4,
                'en' => ['title' => 'Confidentiality', 'description' => 'All projects are handled with strict confidentiality. We use secure systems and NDAs to protect your sensitive information.'],
                'id' => ['title' => 'Kerahasiaan', 'description' => 'Semua proyek ditangani dengan kerahasiaan ketat. Kami menggunakan sistem aman dan NDA untuk melindungi informasi sensitif Anda.'],
            ],
            [
                'icon_class' => 'bi bi-lightbulb',
                'sort_order' => 5,
                'en' => ['title' => 'Innovation', 'description' => 'We leverage cutting-edge translation technology and AI-assisted tools to enhance efficiency while maintaining human expertise.'],
                'id' => ['title' => 'Inovasi', 'description' => 'Kami memanfaatkan teknologi terjemahan terdepan dan alat berbantuan AI untuk meningkatkan efisiensi sambil mempertahankan keahlian manusia.'],
            ],
            [
                'icon_class' => 'bi bi-heart',
                'sort_order' => 6,
                'en' => ['title' => 'Client Partnership', 'description' => 'We view every client as a long-term partner. Our dedicated project managers provide personalized attention to understand your unique needs.'],
                'id' => ['title' => 'Kemitraan Klien', 'description' => 'Kami memandang setiap klien sebagai mitra jangka panjang. Manajer proyek kami yang dedikasi memberikan perhatian personal untuk memahami kebutuhan unik Anda.'],
            ],
        ];

        foreach ($values as $v) {
            $coreValue = CoreValue::create([
                'icon_class' => $v['icon_class'],
                'sort_order' => $v['sort_order'],
                'is_active' => true,
            ]);

            $coreValue->translateOrNew('en')->fill($v['en']);
            $coreValue->translateOrNew('id')->fill($v['id']);
            $coreValue->save();
        }
    }
}
