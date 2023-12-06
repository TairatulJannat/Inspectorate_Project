<?php

namespace App\Exports;

use App\Models\AssignParameterValue;
use Maatwebsite\Excel\Concerns\FromCollection;

class AssignParameterValuesExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return AssignParameterValue::all();
    }
}
