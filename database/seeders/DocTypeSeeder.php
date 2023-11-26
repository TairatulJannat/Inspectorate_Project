<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed some example doc types
        DB::table('doc_types')->insert([
            [
                'name' => 'Type A',
                'doc_serial' => 5,
                'processing_day' => 5,
                'created_at' => now()->subDays(rand(1, 365)),
                'updated_at' => now()->subDays(rand(1, 365)),
            ],
            [
                'name' => 'Type B',
                'doc_serial' => 5,
                'processing_day' => 7,
                'created_at' => now()->subDays(rand(1, 365)),
                'updated_at' => now()->subDays(rand(1, 365)),
            ],
            // Add more entries as needed
        ]);
    }
}
