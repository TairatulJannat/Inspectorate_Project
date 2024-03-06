<?php

namespace App\Imports;

use App\Models\DraftContract;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class DraftContractSpecImport implements ToModel, WithStartRow, WithCustomCsvSettings
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
        return new DraftContract([
            'parameter_group_name' => $row[1],
            'parameter_name' => $row[2],
            'indent_parameter_value' => $row[3],
            'supplier_parameter_value' => $row[4],
            'draft_contract_parameter_value' => $row[5],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
            'input_encoding' => 'UTF-8',
            'enclosure' => '"',
            'line_ending' => "\r\n", // This preserves line breaks
        ];
    }
}
