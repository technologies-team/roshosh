<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('offers')->insert([
            [
                'name' => 'Special Offer 1',
                'description' => 'Description of Special Offer 1',
                'photo_id' => 1, // Assuming attachment ID 1 exists
                'type' => 'fixed',
                'percent_limited' => null,
                'value' => 25.00,
                'min_amount' => 100.00,
                'start_at' => now(),
                'expires_at' => now()->addDays(30),
                'enabled' => true,
                'count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Special Offer 2',
                'description' => 'Description of Special Offer 2',
                'photo_id' => 2, // Assuming attachment ID 2 exists
                'type' => 'percent_limited',
                'percent_limited' => 10.00,
                'value' => 20,
                'start_at' => now(),
                'min_amount' => 00.00,

                'expires_at' => now()->addDays(60),
                'enabled' => true,
                'count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Special Offer 3',
                'description' => 'Description of Special Offer 3',
                'photo_id' => 3, // Assuming attachment ID 3 exists
                'type' => 'percent',
                'percent_limited' => null,
                'min_amount' => 00.00,

                'value' => 20.00,
                'start_at' => now(),
                'expires_at' => now()->addDays(90),
                'enabled' => true,
                'count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
