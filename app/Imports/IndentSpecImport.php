<?php

namespace App\Imports;

use App\Models\AssignParameterValue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class IndentSpecImport implements ToModel, WithStartRow
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
        return new AssignParameterValue([
            'parameter_group_name' => $row[1],
            'parameter_name' => $row[2],
            'parameter_value' => $row[3],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
