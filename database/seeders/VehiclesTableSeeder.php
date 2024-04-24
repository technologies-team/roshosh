<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicles')->insert([
            [
                'type' => 'SUV',
                'color' => 'Black',
                'make' => 'Toyota',
                'model' => 'RAV4',
                'license_plate' => 'ABC123',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Sedan',
                'color' => 'White',
                'make' => 'Honda',
                'model' => 'Accord',
                'license_plate' => 'XYZ789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more vehicle records as needed
        ]);
    }
}
