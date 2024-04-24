<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('coupons')->insert([
            [
                'name' => 'Coupon 1',
                'description' => 'Description for Coupon 1',
                'type' => 'percentage', // or 'fixed'
                'value' => 10.00, // value of the coupon
                'start_at' => now(),
                'expires_at' => now()->addDays(30), // expires in 30 days
                'enabled' => true,
                'count' => 100, // available count of the coupon
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Coupon 2',
                'description' => 'Description for Coupon 2',
                'type' => 'fixed', // or 'percentage'
                'value' => 50.00, // value of the coupon
                'start_at' => now(),
                'expires_at' => now()->addDays(60), // expires in 60 days
                'enabled' => true,
                'count' => 200, // available count of the coupon
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more coupon records as needed
        ]);
    }
}
