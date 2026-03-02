<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inquiry;

class InquirySeeder extends Seeder
{
    public function run(): void
    {
        $inquiries = [
            [
                'name' => 'David Chen',
                'email' => 'david.chen@techcorp.com',
                'subject' => 'Software Localization for Mobile App',
                'service' => 'Software Localization',
                'message' => "Hi Veridian team,\n\nWe're launching our fintech mobile app in Southeast Asia and need comprehensive localization for Indonesian, Thai, and Vietnamese markets.\n\nThe app has approximately 2,500 strings including in-app notifications, terms of service, and help documentation. We need both UI translation and cultural adaptation.\n\nCould you provide a timeline and cost estimate? We're targeting Q2 2026 launch.\n\nBest regards,\nDavid Chen\nProduct Manager, TechCorp Asia",
                'is_read' => false,
                'created_at' => now()->subHours(2),
            ],
            [
                'name' => 'Sarah Williams',
                'email' => 'sarah.w@globalfilms.co.uk',
                'subject' => 'Dubbing Project — Documentary Series',
                'service' => 'Professional Dubbing',
                'message' => "Dear Veridian Solutions,\n\nWe are producing a 6-episode documentary series about marine conservation and require professional dubbing in Bahasa Indonesia, Japanese, and Korean.\n\nEach episode is approximately 45 minutes. We need native voice actors with experience in nature/science documentaries.\n\nPlease let us know your availability and pricing for this type of project.\n\nKind regards,\nSarah Williams\nGlobal Films Productions UK",
                'is_read' => false,
                'created_at' => now()->subHours(5),
            ],
            [
                'name' => 'Ahmad Faisal',
                'email' => 'ahmad.faisal@kemenlu.go.id',
                'subject' => 'Official Document Translation (Indonesian ↔ English)',
                'service' => 'Document Translation',
                'message' => "Yth. Tim Veridian Solutions,\n\nKami membutuhkan jasa penerjemahan resmi (sworn translation) untuk dokumen-dokumen diplomatik antara Bahasa Indonesia dan Bahasa Inggris.\n\nTotal dokumen yang perlu diterjemahkan sekitar 150 halaman, termasuk nota kesepahaman dan perjanjian bilateral.\n\nApakah Veridian memiliki penerjemah tersumpah yang bisa menangani dokumen pemerintah? Mohon informasi mengenai proses dan estimasi waktu penyelesaian.\n\nTerima kasih,\nAhmad Faisal\nStaf Hubungan Internasional",
                'is_read' => true,
                'created_at' => now()->subDays(1),
            ],
            [
                'name' => 'Maria Gonzalez',
                'email' => 'mgonzalez@edutechlatam.com',
                'subject' => 'E-Learning Video Subtitling — 50 Modules',
                'service' => 'Video Subtitling',
                'message' => "Hello,\n\nWe have 50 e-learning video modules (each 10-15 minutes) that need subtitling from English to Spanish, Portuguese, and Indonesian.\n\nThe content covers data science and machine learning topics. Accuracy in technical terminology is critical.\n\nWe also need SRT/VTT files delivered alongside the subtitled videos. Is this something your team can handle?\n\nLooking forward to your response.\n\nMaria Gonzalez\nContent Director, EduTech LATAM",
                'is_read' => true,
                'created_at' => now()->subDays(2),
            ],
            [
                'name' => 'Tanaka Hiroshi',
                'email' => 'tanaka.h@yamatoind.co.jp',
                'subject' => 'Technical Manual Translation (Japanese → Indonesian)',
                'service' => 'Document Translation',
                'message' => "Dear Veridian,\n\nYamato Industries is expanding our manufacturing operations to Indonesia. We need our technical manuals (approx. 800 pages) translated from Japanese to Bahasa Indonesia.\n\nThe documents contain highly specialized engineering and safety terminology. Previous experience with industrial/manufacturing content is required.\n\nPlease send us your portfolio of similar projects and a quote.\n\nRegards,\nTanaka Hiroshi\nInternational Division, Yamato Industries",
                'is_read' => false,
                'created_at' => now()->subDays(3),
            ],
            [
                'name' => 'Emily Parker',
                'email' => 'emily@startupxyz.io',
                'subject' => 'General Inquiry — Partnership Opportunity',
                'service' => null,
                'message' => "Hi there!\n\nI'm the Co-founder of StartupXYZ, and we're building an AI-powered language learning platform. We're exploring potential partnerships with established translation companies.\n\nWould Veridian be interested in a conversation about how we might collaborate? We're particularly interested in your expertise in Professional Dubbing and Video Subtitling.\n\nLet me know if there's a good time to hop on a call!\n\nCheers,\nEmily Parker",
                'is_read' => false,
                'created_at' => now()->subDays(4),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@pertaminaenergy.co.id',
                'subject' => 'Corporate Video Dubbing — Annual Report',
                'service' => 'Professional Dubbing',
                'message' => "Selamat pagi,\n\nKami ingin menanyakan layanan dubbing untuk video laporan tahunan perusahaan kami. Video berdurasi 20 menit dalam Bahasa Indonesia, dan perlu didubbing ke Bahasa Inggris, Mandarin, dan Arab.\n\nVideo berisi presentasi direksi, infografis, dan narasi corporate. Kami butuh kualitas suara profesional yang sesuai dengan standar korporat.\n\nMohon kirimkan penawaran harga dan contoh pekerjaan serupa.\n\nSalam,\nBudi Santoso\nHead of Corporate Communications",
                'is_read' => true,
                'created_at' => now()->subDays(5),
            ],
            [
                'name' => 'Lisa Müller',
                'email' => 'l.muller@berlintech.de',
                'subject' => 'SaaS Platform Localization — DACH Region',
                'service' => 'Software Localization',
                'message' => "Guten Tag / Hello,\n\nWe are a Berlin-based SaaS company looking to localize our cloud platform for the Indonesian and Malay markets.\n\nOur platform has approximately 5,000 strings across web and mobile interfaces. We need:\n- UI string translation\n- Help center articles (30 articles)\n- Marketing landing pages (5 pages)\n- Legal documents (ToS, Privacy Policy)\n\nDo you offer ongoing translation services with a translation memory system? We expect regular content updates.\n\nBest,\nLisa Müller\nHead of Internationalization, BerlinTech GmbH",
                'is_read' => false,
                'created_at' => now()->subDays(7),
            ],
        ];

        foreach ($inquiries as $inquiry) {
            Inquiry::create($inquiry);
        }
    }
}
