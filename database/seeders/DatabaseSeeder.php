<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            IpWhitelistSeeder::class,
            LanguageSeeder::class,
            ServiceSeeder::class,
            ProjectSeeder::class,
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
            TestimonialSeeder::class,
            CompanyProfileSeeder::class,
            InquirySeeder::class,
            TeamMemberSeeder::class,
            CoreValueSeeder::class,
            CompanyTimelineSeeder::class,
            CertificationSeeder::class,
        ]);
    }
}
