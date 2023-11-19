<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParameterGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert sample data into parameter_groups table
        DB::table('parameter_groups')->insert([
            [
                'name' => 'Sample Parameter Group 1',
                'item_type_id' => 1,  // Replace with a valid item_type_id
                'item_id' => 1,       // Replace with a valid item_id
                'inspectorate_id' => 1, // Replace with a valid inspectorate_id
                'section_id' => 1,     // Replace with a valid section_id
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more sample data as needed
        ]);
    }
}
