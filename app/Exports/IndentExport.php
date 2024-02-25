<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class IndentExport implements FromCollection, WithHeadings, WithEvents
{
    protected $excelData;

    public function __construct($excelData)
    {
        $this->excelData = $excelData;
    }

    public function collection()
    {
        return new \Illuminate\Support\Collection($this->excelData);
    }

    public function headings(): array
    {
        return [
            'S. No.',
            'Parameter Group Name',
            'Parameter Name',
            'Parameter Value',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->insertNewRowBefore(1, 4);
            },
        ];
    }
}
