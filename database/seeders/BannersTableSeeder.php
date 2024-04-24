<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banners')->insert([
            [
                'photo_id' => 1,
                'description' => 'Banner 1 description',
                'title' => 'Banner 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'photo_id' => 2,
                'description' => 'Banner 2 description',
                'title' => 'Banner 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more banner records as needed
        ]);
    }
}
