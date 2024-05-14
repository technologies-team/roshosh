<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insert 5 static user records
        DB::table('users')->insert([
            [
                'name' => 'super admin',
                'email' => 'super@roshosh.ae',
                'phone' => '1234567890',
                'rewards' => 0,
                'role'=>'super',
                'status' => User::status_active,
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'admin',
                'email' => 'admin@roshosh.ae',
                'phone' => '9876543210',
                'rewards' => 0,
                'role'=>'admin',
                'status' => User::status_active,
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'vendor',
                'email' => 'vendor@roshosh.ae',
                'phone' => '433545345',
                'rewards' => 0,
                'role'=>'vendor',
                'status' => User::status_active,
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'customer',
                'email' => 'custome@roshosh.ae',
                'phone' => '02020202020200',
                'rewards' => 0,
                'role'=>'customer',
                'status' => User::status_active,
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
