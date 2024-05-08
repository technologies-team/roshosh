<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceOfferTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offerServices = [
            ['offer_id' => 1, 'service_id' => 1],
            ['offer_id' => 2, 'service_id' => 1],
            ['offer_id' => 3, 'service_id' => 1],
            // Add more dummy data as needed
        ];

        // Insert dummy data into the offer_service table
        DB::table('offer_service')->insert($offerServices);

    }
}
