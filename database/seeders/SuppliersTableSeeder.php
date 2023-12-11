<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('suppliers')->insert([
                'insp_id'               => $i,
                'firm_name'             => "Supplier Company $i",
                'principal_name'        => "Principal Name $i",
                'address_of_local_agent' => "Local Agent Address $i, City $i",
                'address_of_principal'  => "Principal Address $i, City $i",
                'contact_no'            => "123-456-789$i",
                'email'                 => "contact$i@suppliercompany.com",
                'created_at'            => now(),
                'updated_at'            => now(),
                'created_by'            => "Seeder",
            ]);
        }
    }
}
