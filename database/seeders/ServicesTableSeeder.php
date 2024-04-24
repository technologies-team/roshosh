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
                'title' => 'car wash',
                'title_ar' => 'غسيل السيارة',
                'description' => '
                Several stages are involved: \n

1- Opening the car.\n
2- Cleaning the doors.\n
3- Inquiring about the nature of the inquiry.',
                'description_ar' => 'تكون على عدة مراحل
                \n
                1-فتح السيارة
                \n
                2- تنظيف الابواب
                 \n
                3- استعلام عن طبيعة الاستعلام
                ',
                'price' => 50.00,
                'category_id' => 1, // ID of the category
                'parent_id' => null, // No parent service
                'rewards' => 10,
                'photo_id' => 3, // ID of the photo attachment
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'vip wash ',
                'title_ar' => 'خدمة  vip',
                'description' => '
                Several stages are involved: \n

1- Opening the car.\n
2- Cleaning the doors.\n
3- Inquiring about the nature of the inquiry.',
                'description_ar' => 'تكون على عدة مراحل
                \n
                1-فتح السيارة
                \n
                2- تنظيف الابواب
                 \n
                3- استعلام عن طبيعة الاستعلام
                ', 'price' => 100.00,
                'category_id' => 2, // ID of the category
                'parent_id' => null, // No parent service
                'rewards' => 20,
                'photo_id' => 4, // ID of the photo attachment
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Detailing',
                'title_ar' => 'خدمة  تفصيل',
                'description' => '
                Several stages are involved: \n

1- Opening the car.\n
2- Cleaning the doors.\n
3- Inquiring about the nature of the inquiry.',
                'description_ar' => 'تكون على عدة مراحل
                \n
                1-فتح السيارة
                \n
                2- تنظيف الابواب
                 \n
                3- استعلام عن طبيعة الاستعلام
                ', 'price' => 100.00,
                'category_id' => 2, // ID of the category
                'parent_id' => null, // No parent service
                'rewards' => 20,
                'photo_id' => 5, // ID of the photo attachment
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more service records as needed
        ]);
    }
}
