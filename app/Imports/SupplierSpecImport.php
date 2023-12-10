<?php

namespace App\Imports;

use App\Models\AssignParameterValue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class SupplierSpecImport implements ToModel
{
    public function model(array $row)
    {
        return new AssignParameterValue([
            'parameter_group_name' => $row[0],
            'parameter_name' => $row[1],
            'parameter_value' => $row[2],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
