<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'id_blog_category' => 1,
                'badge_color' => 'translation',
                'en_name' => 'Translation',
                'en_slug' => 'translation',
                'id_name' => 'Penerjemahan',
                'id_slug' => 'penerjemahan',
            ],
            [
                'id_blog_category' => 2,
                'badge_color' => 'dubbing',
                'en_name' => 'Dubbing',
                'en_slug' => 'dubbing',
                'id_name' => 'Sulih Suara',
                'id_slug' => 'sulih-suara',
            ],
            [
                'id_blog_category' => 3,
                'badge_color' => 'localization',
                'en_name' => 'Localization',
                'en_slug' => 'localization',
                'id_name' => 'Lokalisasi',
                'id_slug' => 'lokalisasi',
            ],
            [
                'id_blog_category' => 4,
                'badge_color' => 'industry',
                'en_name' => 'Industry News',
                'en_slug' => 'industry-news',
                'id_name' => 'Berita Industri',
                'id_slug' => 'berita-industri',
            ],
        ];

        foreach ($categories as $cat) {
            DB::table('blog_categories')->insert([
                'id_blog_category' => $cat['id_blog_category'],
                'badge_color' => $cat['badge_color'],
                'is_active' => true,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Translation EN
            DB::table('blog_category_translations')->insert([
                'id_blog_category' => $cat['id_blog_category'],
                'locale' => 'en',
                'name' => $cat['en_name'],
                'slug' => $cat['en_slug'],
            ]);

            // Translation ID
            DB::table('blog_category_translations')->insert([
                'id_blog_category' => $cat['id_blog_category'],
                'locale' => 'id',
                'name' => $cat['id_name'],
                'slug' => $cat['id_slug'],
            ]);
        }
    }
}
