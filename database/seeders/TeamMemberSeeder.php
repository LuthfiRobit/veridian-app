<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeamMember;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@veridian.com',
                'linkedin_url' => 'https://linkedin.com/in/ahmad-fauzi',
                'github_url' => 'https://github.com/ahmadfauzi',
                'is_active' => true,
                'sort_order' => 1,
                'translations' => [
                    'en' => ['position' => 'Chief Executive Officer', 'department' => 'Executive', 'bio' => 'Ahmad leads Veridian with 15+ years of experience in digital transformation and product strategy.'],
                    'id' => ['position' => 'Chief Executive Officer', 'department' => 'Eksekutif', 'bio' => 'Ahmad memimpin Veridian dengan pengalaman 15+ tahun dalam transformasi digital dan strategi produk.'],
                ],
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti.rahayu@veridian.com',
                'linkedin_url' => 'https://linkedin.com/in/siti-rahayu',
                'twitter_url' => 'https://twitter.com/sitirahayu',
                'is_active' => true,
                'sort_order' => 2,
                'translations' => [
                    'en' => ['position' => 'Head of Design', 'department' => 'Creative', 'bio' => 'Siti brings creativity and user-centric thinking to every project, crafting intuitive and beautiful interfaces.'],
                    'id' => ['position' => 'Kepala Divisi Desain', 'department' => 'Kreatif', 'bio' => 'Siti membawa kreativitas dan pemikiran yang berpusat pada pengguna ke setiap proyek.'],
                ],
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@veridian.com',
                'github_url' => 'https://github.com/budisantoso',
                'linkedin_url' => 'https://linkedin.com/in/budi-santoso',
                'is_active' => true,
                'sort_order' => 3,
                'translations' => [
                    'en' => ['position' => 'Lead Backend Developer', 'department' => 'Engineering', 'bio' => 'Budi architects scalable and resilient backend systems, with expertise in Laravel and microservices.'],
                    'id' => ['position' => 'Lead Backend Developer', 'department' => 'Engineering', 'bio' => 'Budi merancang sistem backend yang skalabel dan tangguh, dengan keahlian di Laravel dan microservices.'],
                ],
            ],
            [
                'name' => 'Dewi Kusuma',
                'email' => 'dewi.kusuma@veridian.com',
                'linkedin_url' => 'https://linkedin.com/in/dewi-kusuma',
                'is_active' => true,
                'sort_order' => 4,
                'translations' => [
                    'en' => ['position' => 'Marketing Manager', 'department' => 'Marketing', 'bio' => 'Dewi drives brand awareness and client acquisition through data-driven marketing strategies.'],
                    'id' => ['position' => 'Manajer Pemasaran', 'department' => 'Pemasaran', 'bio' => 'Dewi mendorong kesadaran merek dan akuisisi klien melalui strategi pemasaran berbasis data.'],
                ],
            ],
        ];

        foreach ($members as $memberData) {
            $translations = $memberData['translations'];
            unset($memberData['translations']);

            $member = TeamMember::create($memberData);

            foreach ($translations as $locale => $attrs) {
                $member->translateOrNew($locale)->fill($attrs)->save();
            }
        }

        $this->command->info('TeamMemberSeeder: ' . count($members) . ' team members seeded.');
    }
}
