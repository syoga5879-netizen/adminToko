<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
        ['category' => 'Elektronik', 'created_at' => now(), 'updated_at' => now()],
        ['category' => 'Fashion', 'created_at' => now(), 'updated_at' => now()],
        ['category' => 'Makanan & Minuman', 'created_at' => now(), 'updated_at' => now()],
        ['category' => 'Olahraga', 'created_at' => now(), 'updated_at' => now()],
        ['category' => 'Kesehatan', 'created_at' => now(), 'updated_at' => now()],
        ['category' => 'Pendidikan', 'created_at' => now(), 'updated_at' => now()],
        ['category' => 'Hobi & Kerajinan', 'created_at' => now(), 'updated_at' => now()],
        ['category' => 'Komik & Manga', 'created_at' => now(), 'updated_at' => now()],
        ['category' => 'Sains & Teknologi', 'created_at' => now(), 'updated_at' => now()],
        ['category' => 'Sejarah & Budaya', 'created_at' => now(), 'updated_at' => now()],
        ['category' => 'Agama & Spiritualitas', 'created_at' => now(), 'updated_at' => now()],
        ['category' => 'Bisnis & Ekonomi', 'created_at' => now(), 'updated_at' => now()],
    ]);
    }
}