<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttachmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('attachments')->insert([
            [
                'name' => 'V5rJO5f3Wesx1YlXsFImgkAkj6VcM1X90QJzwvdA.png',
                'mime_type' => 'application/pdf',
                'path' => 'attachment/V5rJO5f3Wesx1YlXsFImgkAkj6VcM1X90QJzwvdA.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'V5rJO5f3Wesx1YlXsFImgkAkj6VcM1X90QJzwvdA.png',
                'mime_type' => 'image/jpeg',
                'path' => '/attachment/V5rJO5f3Wesx1YlXsFImgkAkj6VcM1X90QJzwvdA.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],   [
                'name' => 'EsjgKDQW6RrNSllXyXVvGVkkZmtVUqkuHq6HjDb9.png',
                'mime_type' => 'image/jpeg',
                'path' => '/attachment/EsjgKDQW6RrNSllXyXVvGVkkZmtVUqkuHq6HjDb9.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],   [
                'name' => 'HwrSFp81LtNzk4fz6PUiTIDeehQrgkfoQOjyU6r6.png',
                'mime_type' => 'image/jpeg',
                'path' => '/attachment/HwrSFp81LtNzk4fz6PUiTIDeehQrgkfoQOjyU6r6.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],   [
                'name' => 'tnwbu3EnH0BABqvsDtjn8xV94PwSC0TCfKqdNZua.png',
                'mime_type' => 'image/jpeg',
                'path' => '/attachment/tnwbu3EnH0BABqvsDtjn8xV94PwSC0TCfKqdNZua.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
