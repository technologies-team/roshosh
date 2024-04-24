<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'title' => 'Service 1',
                'title_ar' => 'الخدمة 1',
                'description' => 'Description for Service 1',
                'description_ar' => 'الوصف للخدمة 1',
                'price' => 50.00,
                'category_id' => 1, // ID of the category
                'parent_id' => null, // No parent service
                'rewards' => 10,
                'photo_id' => 1, // ID of the photo attachment
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Service 2',
                'title_ar' => 'الخدمة 2',
                'description' => 'Description for Service 2',
                'description_ar' => 'الوصف للخدمة 2',
                'price' => 100.00,
                'category_id' => 2, // ID of the category
                'parent_id' => null, // No parent service
                'rewards' => 20,
                'photo_id' => 2, // ID of the photo attachment
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more service records as needed
        ]);
    }
}
