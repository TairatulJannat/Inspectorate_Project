<?php

namespace App\Imports;

use App\Models\SupplierSpecData;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SupplierSpecImport implements ToModel, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 6;
    }

    public function model(array $row)
    {
        return new SupplierSpecData([
            'parameter_group_name' => $row[1],
            'parameter_name' => $row[2],
            'indent_parameter_value' => $row[3],
            'parameter_value' => $row[4],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
