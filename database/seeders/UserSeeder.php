<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@veridiansolutions.com'],
            [
                'name' => 'Admin Veridian',
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'avatar' => null,
                'author_title' => 'Chief Operations Officer',
                'author_bio' => 'Overseeing global operations and ensuring top-quality service delivery.',
            ]
        );
        $admin->assignRole('Super Admin');

        // Editor
        $editor = User::firstOrCreate(
            ['email' => 'editor@veridiansolutions.com'],
            [
                'name' => 'Sarah Chen',
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
                'avatar' => 'assets/img/team/team-1.jpg',
                'author_title' => 'Senior Translation Technology Consultant',
                'author_bio' => 'With over 12 years of experience in translation technology, Sarah specializes in AI-assisted translation workflows and helps language service providers integrate cutting-edge tools while maintaining quality standards.',
            ]
        );
        $editor->assignRole('Editor');
    }
}
