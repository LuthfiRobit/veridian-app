<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Sarah Jenkins',
                'rating' => 5,
                'sort_order' => 1,
                'translations' => [
                    'en' => [
                        'client_position' => 'Marketing Director',
                        'content' => 'Veridian Solutions provided exceptional translation services for our global campaign. The nuance and cultural accuracy were spot on.',
                    ],
                    'id' => [
                        'client_position' => 'Direktur Pemasaran',
                        'content' => 'Veridian Solutions memberikan layanan terjemahan yang luar biasa untuk kampanye global kami. Nuansa dan keakuratan budayanya sangat tepat.',
                    ],
                ]
            ],
            [
                'client_name' => 'Michael Chen',
                'rating' => 5,
                'sort_order' => 2,
                'translations' => [
                    'en' => [
                        'client_position' => 'Product Manager',
                        'content' => 'Their localization team is incredibly fast and reliable. They helped us launch our mobile app in 5 new countries without a hitch.',
                    ],
                    'id' => [
                        'client_position' => 'Manajer Produk',
                        'content' => 'Tim pelokalan mereka luar biasa cepat dan dapat diandalkan. Mereka membantu kami meluncurkan aplikasi seluler di 5 negara baru tanpa hambatan.',
                    ],
                ]
            ],
            [
                'client_name' => 'Elena Rodriguez',
                'rating' => 4,
                'sort_order' => 3,
                'translations' => [
                    'en' => [
                        'client_position' => 'CEO, TechFlow',
                        'content' => 'We rely on Veridian for all our technical documentation translation. The specialized knowledge of their linguists sets them apart from the competition.',
                    ],
                    'id' => [
                        'client_position' => 'CEO, TechFlow',
                        'content' => 'Kami mengandalkan Veridian untuk semua terjemahan dokumentasi teknis kami. Pengetahuan khusus linguistik mereka membuat mereka unggul dari pesaing.',
                    ],
                ]
            ]
        ];

        foreach ($testimonials as $data) {
            $translations = $data['translations'];
            unset($data['translations']);

            $testimonial = Testimonial::create($data);

            $insertTranslations = [];
            foreach ($translations as $locale => $translation) {
                $insertTranslations[] = array_merge(['locale' => $locale], $translation);
            }
            $testimonial->translations()->createMany($insertTranslations);
        }
    }
}
