<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignParameterValuesSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('assign_parameter_values')->insert([
            'parameter_name' => 'Parameter 1',
            'parameter_value' => 'Value 1',
            'parameter_group_id' => 18,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
