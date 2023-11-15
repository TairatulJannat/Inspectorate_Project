<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ParameterGroup;

class ParameterGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $numberOfRecords = 10;

        for ($i = 1; $i <= $numberOfRecords; $i++) {
            ParameterGroup::create([
                'inspectorate_id' => rand(1, 4),
                'section_id' => rand(1, 3),
                'name' => "Parameter Group $i",
                'description' => "Description for Parameter Group $i",
                'status' => rand(0, 1),
            ]);
        }
    }
}
