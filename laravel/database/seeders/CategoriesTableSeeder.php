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
                'slug' => 'i-gensaku',
                'name' => '原作軸',
                'type' => '0', // 0 = illustration
                'description' => '原作軸',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'i-genparo',
                'name' => '現パロ',
                'type' => '0', // 0 = illustration
                'description' => '現パロ',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'n-gensaku',
                'name' => '原作軸',
                'type' => '1', // 1 = novel
                'description' => '原作軸',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'n-genparo',
                'name' => '現パロ',
                'type' => '1', // 1 = novel
                'description' => '現パロ',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['slug'], ['name', 'type', 'description', 'updated_at']);
    }
}
