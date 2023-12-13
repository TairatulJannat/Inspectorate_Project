<?php

namespace App\Imports;

use App\Models\SupplierSpecData;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class SupplierSpecImport implements ToModel
{
    public function model(array $row)
    {
        return new SupplierSpecData([
            'parameter_group_name' => $row[0],
            'parameter_name' => $row[1],
            'indent_parameter_value' => $row[2],
            'parameter_value' => $row[3],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
