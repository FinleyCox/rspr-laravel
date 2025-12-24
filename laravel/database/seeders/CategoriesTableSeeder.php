<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        DB::table('categories')->upsert([
            [
                'slug' => 'category1',
                'name' => 'カテゴリ1',
                'type' => '0', // 0 = illustration
                'description' => 'イラスト用カテゴリ1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'novel-category1',
                'name' => 'カテゴリ1',
                'type' => '1', // 1 = novel
                'description' => '小説用カテゴリ1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['slug'], ['name', 'type', 'description', 'updated_at']);
    }
}
