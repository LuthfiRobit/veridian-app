<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyProfile;

class CompanyProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profile = CompanyProfile::firstOrCreate([], [
            'stat_projects' => '500+',
            'stat_clients' => '200+',
            'stat_retention' => '95%',
            'stat_experience' => '15+',
            'stat_languages' => '50+',
            'stat_satisfaction' => '98%',

            // Contact
            'address' => 'Jakarta, Indonesia',
            'phone' => '+62 812-3456-7890',
            'email' => 'contact@veridian-solutions.com',
            'whatsapp' => '6281234567890',
            'google_maps_url' => null,

            // Social Media
            'social_facebook' => 'https://facebook.com/veridiansolutions',
            'social_instagram' => 'https://instagram.com/veridiansolutions',
            'social_twitter' => 'https://x.com/veridiansol',
            'social_linkedin' => 'https://linkedin.com/company/veridian-solutions',
            'social_youtube' => null,
            'social_tiktok' => null,

            'is_active' => true,
        ]);

        // Create translations
        $profile->translations()->createMany([
            [
                'locale' => 'en',
                'hero_badge' => 'Professional Language Solutions',
                'hero_title' => 'Breaking Language Barriers for Global Success',
                'hero_description' => 'Expert translation, dubbing, subtitling, and localization services that elevate your content across cultures and languages. Connect with audiences worldwide.',
                'about_title' => 'Empowering Global Communication Through Expert Language Services',
                'about_subtitle' => 'Who We Are',
                'about_lead_text' => 'Veridian Solutions is your trusted partner for professional translation, dubbing, subtitling, and localization services. We bridge language gaps to help businesses and individuals communicate effectively across borders.',
                'about_description' => 'With over 15 years of experience and a team of certified native linguists, we deliver accurate, culturally-appropriate translations that resonate with your target audience. Our ISO-certified processes ensure the highest quality standards in every project.',
                'mission_title' => 'Our Mission',
                'mission_description' => 'To empower global communication by providing accurate, culturally-sensitive language services that help businesses and individuals connect across borders. We are committed to excellence, integrity, and continuous innovation in every project we deliver.',
                'vision_title' => 'Our Vision',
                'vision_description' => 'To become the world\'s most trusted language services partner, recognized for our quality, cultural expertise, and innovative approach. We envision a world where language is never a barrier to understanding, collaboration, and success.',
                'footer_description' => 'Professional translation, dubbing, subtitling, and localization services for global communication.',
            ],
            [
                'locale' => 'id',
                'hero_badge' => 'Solusi Bahasa Profesional',
                'hero_title' => 'Menembus Batas Bahasa untuk Kesuksesan Global',
                'hero_description' => 'Layanan terjemahan, dubbing, subtitling, dan pelokalan ahli yang meningkatkan konten Anda melintasi budaya dan bahasa. Jangkau audiens di seluruh dunia.',
                'about_title' => 'Memberdayakan Komunikasi Global Melalui Layanan Bahasa Ahli',
                'about_subtitle' => 'Tentang Kami',
                'about_lead_text' => 'Veridian Solutions adalah mitra terpercaya Anda untuk layanan penerjemahan profesional, dubbing, subtitling, dan lokalisasi. Kami menjembatani kesenjangan bahasa untuk membantu bisnis dan individu berkomunikasi secara efektif lintas batas.',
                'about_description' => 'Dengan pengalaman lebih dari 15 tahun dan tim penerjemah asli bersertifikat, kami menghasilkan terjemahan yang akurat dan sesuai budaya yang beresonansi dengan audiens target Anda. Proses bersertifikat ISO kami memastikan standar kualitas tertinggi di setiap proyek.',
                'mission_title' => 'Misi Kami',
                'mission_description' => 'Memberdayakan komunikasi global dengan menyediakan layanan bahasa yang akurat dan sensitif secara budaya yang membantu bisnis dan individu terhubung lintas batas. Kami berkomitmen pada keunggulan, integritas, dan inovasi berkelanjutan di setiap proyek yang kami sampaikan.',
                'vision_title' => 'Visi Kami',
                'vision_description' => 'Menjadi mitra layanan bahasa paling terpercaya di dunia, diakui atas kualitas, keahlian budaya, dan pendekatan inovatif kami. Kami membayangkan dunia di mana bahasa tidak pernah menjadi penghalang untuk pemahaman, kolaborasi, dan kesuksesan.',
                'footer_description' => 'Layanan penerjemahan profesional, dubbing, subtitling, dan lokalisasi untuk komunikasi global.',
            ]
        ]);
    }
}
