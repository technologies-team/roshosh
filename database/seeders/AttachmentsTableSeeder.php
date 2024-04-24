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
                'name' => 'Document 1',
                'mime_type' => 'application/pdf',
                'path' => '/path/to/document1.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Image 1',
                'mime_type' => 'image/jpeg',
                'path' => '/path/to/image1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more attachment records as needed
        ]);
    }
}
