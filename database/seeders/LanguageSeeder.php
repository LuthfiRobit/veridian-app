<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('languages')->insert([
            [
                'code' => 'en',
                'name' => 'English',
                'icon' => 'flag-icon flag-icon-us',
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'id',
                'name' => 'Indonesian',
                'icon' => 'flag-icon flag-icon-id',
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'zh',
                'name' => 'Chinese',
                'icon' => 'flag-icon flag-icon-cn',
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
