<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'id_blog_category' => 4, // Industry
                'image_featured' => 'assets/img/portfolio/portfolio-8.webp',
                'published_at' => Carbon::parse('2024-02-05 10:00:00'),
                'reading_time' => 8,
                'en' => [
                    'title' => 'The Future of AI in Translation: Opportunities and Challenges',
                    'slug' => 'the-future-of-ai-in-translation',
                    'excerpt' => 'Explore how artificial intelligence is transforming the translation industry while human expertise remains irreplaceable for quality and cultural accuracy.',
                    'content' => '<p>Artificial intelligence is revolutionizing the translation industry at an unprecedented pace...</p>',
                ],
                'id' => [
                    'title' => 'Masa Depan AI dalam Penerjemahan: Peluang dan Tantangan',
                    'slug' => 'masa-depan-ai-dalam-penerjemahan',
                    'excerpt' => 'Jelajahi bagaimana kecerdasan buatan mengubah industri penerjemahan sementara keahlian manusia tetap tak tergantikan untuk kualitas dan akurasi budaya.',
                    'content' => '<p>Kecerdasan buatan merevolusi industri penerjemahan pada tingkat yang belum pernah terjadi sebelumnya...</p>',
                ]
            ],
            [
                'id_blog_category' => 2, // Dubbing
                'image_featured' => 'assets/img/portfolio/portfolio-4.webp',
                'published_at' => Carbon::parse('2024-01-28 09:00:00'),
                'reading_time' => 6,
                'en' => [
                    'title' => '5 Common Mistakes in Video Dubbing and How to Avoid Them',
                    'slug' => '5-common-mistakes-in-video-dubbing',
                    'excerpt' => 'Learn professional tips to ensure high-quality dubbing projects including lip-sync precision, voice casting, and cultural adaptation strategies.',
                    'content' => '<p>Learn professional tips to ensure high-quality dubbing projects...</p>',
                ],
                'id' => [
                    'title' => '5 Kesalahan Umum dalam Sulih Suara Video dan Cara Menghindarinya',
                    'slug' => '5-kesalahan-umum-dalam-sulih-suara-video',
                    'excerpt' => 'Pelajari tips profesional untuk memastikan proyek sulih suara berkualitas tinggi.',
                    'content' => '<p>Pelajari tips profesional untuk memastikan proyek sulih suara berkualitas tinggi...</p>',
                ]
            ],
            [
                'id_blog_category' => 1, // Translation
                'image_featured' => 'assets/img/portfolio/portfolio-2.webp',
                'published_at' => Carbon::parse('2024-01-15 14:00:00'),
                'reading_time' => 7,
                'en' => [
                    'title' => 'Legal Translation 101: Why Accuracy Matters More Than Ever',
                    'slug' => 'legal-translation-101',
                    'excerpt' => 'Discover the critical importance of precision in legal document translation.',
                    'content' => '<p>Discover the critical importance of precision in legal document translation...</p>',
                ],
                'id' => [
                    'title' => 'Penerjemahan Hukum 101: Mengapa Akurasi Lebih Penting dari Sebelumnya',
                    'slug' => 'penerjemahan-hukum-101',
                    'excerpt' => 'Temukan betapa pentingnya presisi dalam penerjemahan dokumen hukum.',
                    'content' => '<p>Temukan betapa pentingnya presisi dalam penerjemahan dokumen hukum...</p>',
                ]
            ],
            [
                'id_blog_category' => 3, // Localization
                'image_featured' => 'assets/img/portfolio/portfolio-7.webp',
                'published_at' => Carbon::parse('2023-12-20 08:30:00'),
                'reading_time' => 9,
                'en' => [
                    'title' => 'Software Localization Best Practices for Global Markets',
                    'slug' => 'software-localization-best-practices',
                    'excerpt' => 'A comprehensive guide to successful software localization strategies including UI/UX adaptation, cultural customization, and testing methodologies.',
                    'content' => '<p>A comprehensive guide to successful software localization strategies...</p>',
                ],
                'id' => [
                    'title' => 'Praktik Terbaik Lokalisasi Perangkat Lunak untuk Pasar Global',
                    'slug' => 'praktik-terbaik-lokalisasi-perangkat-lunak',
                    'excerpt' => 'Panduan komprehensif untuk strategi lokalisasi perangkat lunak yang sukses termasuk adaptasi UI/UX, penyesuaian budaya, dan metodologi pengujian.',
                    'content' => '<p>Panduan komprehensif untuk strategi lokalisasi perangkat lunak yang sukses...</p>',
                ]
            ],
            [
                'id_blog_category' => 3, // Localization
                'image_featured' => 'assets/img/portfolio/portfolio-6.webp',
                'published_at' => Carbon::parse('2023-12-05 11:20:00'),
                'reading_time' => 7,
                'en' => [
                    'title' => 'Subtitle Standards: Making Your Content Accessible Worldwide',
                    'slug' => 'subtitle-standards',
                    'excerpt' => 'Best practices for subtitle creation focusing on accessibility, timing accuracy, formatting standards, and compliance with international guidelines.',
                    'content' => '<p>Best practices for subtitle creation focusing on accessibility...</p>',
                ],
                'id' => [
                    'title' => 'Standar Subtitel: Membuat Konten Anda Dapat Diakses di Seluruh Dunia',
                    'slug' => 'standar-subtitel',
                    'excerpt' => 'Praktik terbaik pembuatan subtitel yang berfokus pada aksesibilitas, akurasi pewaktuan, standar pemformatan, dan kepatuhan terhadap pedoman internasional.',
                    'content' => '<p>Praktik terbaik pembuatan subtitel yang berfokus pada aksesibilitas...</p>',
                ]
            ]
        ];

        foreach ($posts as $post) {
            $postId = DB::table('blog_posts')->insertGetId([
                'id_blog_category' => $post['id_blog_category'],
                'id_author' => 2, // editor / Sarah Chen
                'image_featured' => $post['image_featured'],
                'status' => 'published',
                'published_at' => $post['published_at'],
                'reading_time' => $post['reading_time'],
                'views_count' => rand(100, 1000), // Random views for dummy
                'created_by' => 2,
                'created_at' => $post['published_at'],
                'updated_at' => $post['published_at'],
            ]);

            // Translation EN
            DB::table('blog_post_translations')->insert([
                'id_blog_post' => $postId,
                'locale' => 'en',
                'slug' => $post['en']['slug'],
                'title' => $post['en']['title'],
                'excerpt' => $post['en']['excerpt'],
                'content' => $post['en']['content'],
                'meta_title' => $post['en']['title'],
                'meta_desc' => Str::limit($post['en']['excerpt'], 160),
            ]);

            // Translation ID
            DB::table('blog_post_translations')->insert([
                'id_blog_post' => $postId,
                'locale' => 'id',
                'slug' => $post['id']['slug'],
                'title' => $post['id']['title'],
                'excerpt' => $post['id']['excerpt'],
                'content' => $post['id']['content'],
                'meta_title' => $post['id']['title'],
                'meta_desc' => Str::limit($post['id']['excerpt'], 160),
            ]);
        }
    }
}
