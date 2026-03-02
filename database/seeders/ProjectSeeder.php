<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectImage;
use App\Models\ProjectStat;
use App\Models\ProjectFeature;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $cat1 = ProjectCategory::create(['is_active' => true]);
        $cat1->translations()->createMany([
            ['locale' => 'en', 'name' => 'Translation', 'slug' => 'translation'],
            ['locale' => 'id', 'name' => 'Terjemahan', 'slug' => 'terjemahan'],
        ]);

        $cat2 = ProjectCategory::create(['is_active' => true]);
        $cat2->translations()->createMany([
            ['locale' => 'en', 'name' => 'Dubbing', 'slug' => 'dubbing'],
            ['locale' => 'id', 'name' => 'Sulih Suara', 'slug' => 'sulih-suara'],
        ]);

        // Project 1
        $proj1 = Project::create([
            'id_project_category' => $cat1->id_project_category,
            'client_name' => 'Global Corp',
            'completion_date' => '2024-01-15',
            'project_url' => 'https://globalcorp.com',
            'image_thumbnail' => 'assets/img/projects/legal-thumb.jpg',
            'sort_order' => 1,
            'is_active' => true,
            'is_featured' => true,
        ]);

        $proj1->translations()->createMany([
            [
                'locale' => 'en',
                'title' => 'Legal Contract Translation',
                'slug' => 'legal-contract-translation',
                'subtitle' => 'High-stakes legal documentation',
                'description' => 'Translating 500 pages of legal contracts.',
                'content' => '<p>Full details about the project...</p>',
                'challenge' => 'Tight deadline and complex terminology.',
                'solution' => 'Dedicated team of legal translators.',
                'result' => 'Delivered on time with 100% accuracy.',
                'tech_stack' => ['Legal', 'Trados', 'English', 'Indonesian'],
                'meta_title' => 'Legal Translation Case Study',
                'meta_desc' => 'Legal translation project overview.',
            ],
            [
                'locale' => 'id',
                'title' => 'Terjemahan Kontrak Hukum',
                'slug' => 'terjemahan-kontrak-hukum',
                'subtitle' => 'Dokumentasi hukum berisiko tinggi',
                'description' => 'Menerjemahkan 500 halaman kontrak hukum.',
                'content' => '<p>Detail lengkap tentang proyek...</p>',
                'challenge' => 'Tenggat waktu ketat dan istilah rumit.',
                'solution' => 'Tim penerjemah hukum berdedikasi.',
                'result' => 'Disampaikan tepat waktu dengan akurasi 100%.',
                'tech_stack' => ['Hukum', 'Trados', 'Inggris', 'Indonesia'],
                'meta_title' => 'Studi Kasus Terjemahan Hukum',
                'meta_desc' => 'Gambaran umum proyek terjemahan hukum.',
            ],
        ]);

        // Details for Project 1
        $img1 = ProjectImage::create([
            'project_id' => $proj1->id_project,
            'image_path' => 'assets/img/projects/legal-1.jpg',
            'is_hero' => true,
            'sort_order' => 1,
        ]);

        $img1->translations()->createMany([
            ['locale' => 'en', 'caption' => 'Contract Signing'],
            ['locale' => 'id', 'caption' => 'Penandatanganan Kontrak'],
        ]);

        $stat1 = ProjectStat::create([
            'project_id' => $proj1->id_project,
            'value' => '500k+',
            'icon_class' => 'bi bi-file-text',
            'sort_order' => 1,
        ]);

        $stat1->translations()->createMany([
            ['locale' => 'en', 'label' => 'Words Translated'],
            ['locale' => 'id', 'label' => 'Kata Diterjemahkan'],
        ]);

        $feat1 = ProjectFeature::create([
            'project_id' => $proj1->id_project,
            'icon_class' => 'bi bi-shield-check',
            'sort_order' => 1,
        ]);

        $feat1->translations()->createMany([
            ['locale' => 'en', 'title' => 'Certified', 'description' => 'ISO 17100 Certified'],
            ['locale' => 'id', 'title' => 'Tersertifikasi', 'description' => 'Sertifikasi ISO 17100'],
        ]);

        // Project 2
        $proj2 = Project::create([
            'id_project_category' => $cat2->id_project_category,
            'client_name' => 'EduTech Inc',
            'completion_date' => '2024-03-20',
            'project_url' => 'https://edutech.com',
            'image_thumbnail' => 'assets/img/projects/edu-thumb.jpg',
            'sort_order' => 2,
            'is_active' => true,
            'is_featured' => false,
        ]);

        $proj2->translations()->createMany([
            [
                'locale' => 'en',
                'title' => 'E-Learning Dubbing',
                'slug' => 'elearning-dubbing',
                'subtitle' => 'Educational content localization',
                'description' => 'Dubbing for 50 hours of course material.',
                'content' => '<p>Details about the dubbing project...</p>',
                'challenge' => 'Matching lip-sync for animated characters.',
                'solution' => 'Experienced voice actors.',
                'result' => 'High student engagement.',
                'tech_stack' => ['Dubbing', 'Education', 'English', 'Spanish'],
                'meta_title' => 'E-Learning Dubbing Case Study',
                'meta_desc' => 'E-learning dubbing project overview.',
            ],
            [
                'locale' => 'id',
                'title' => 'Sulih Suara E-Learning',
                'slug' => 'sulih-suara-elearning',
                'subtitle' => 'Lokalisasi konten pendidikan',
                'description' => 'Menyulihsuarakan 50 jam materi kursus.',
                'content' => '<p>Detail tentang proyek sulih suara...</p>',
                'challenge' => 'Menyesuaikan gerak bibir karakter animasi.',
                'solution' => 'Aktor suara berpengalaman.',
                'result' => 'Keterlibatan siswa tinggi.',
                'tech_stack' => ['Sulih Suara', 'Pendidikan', 'Inggris', 'Spanyol'],
                'meta_title' => 'Studi Kasus Sulih Suara E-Learning',
                'meta_desc' => 'Gambaran umum proyek sulih suara e-learning.',
            ],
        ]);
    }
}
