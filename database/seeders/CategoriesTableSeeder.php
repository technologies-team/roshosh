<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'title' => 'Category 1',
                'title_ar' => 'الفئة 1',
                'photo_id' => 1, // ID of the photo attachment
                'parent_id' => null, // No parent category
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Category 2',
                'title_ar' => 'الفئة 2',
                'photo_id' => 2, // ID of the photo attachment
                'parent_id' => null, // No parent category
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more category records as needed
        ]);
    }
}
