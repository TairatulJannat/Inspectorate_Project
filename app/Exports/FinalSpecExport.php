<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class FinalSpecExport implements FromCollection, WithHeadings, WithEvents
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
            'Final Spec Parameter Value',
            'Draft Contract',
            'Contract',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->insertNewRowBefore(1, 4);

                $event->sheet->getDelegate()->getProtection()->setPassword('123456');
                $event->sheet->getDelegate()->getProtection()->setSheet(true);

                $event->sheet->getStyle('E7:E' . $event->sheet->getHighestRow())->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $event->sheet->getStyle('F7:F' . $event->sheet->getHighestRow())->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(40);

                $event->sheet->getDelegate()->getStyle('B')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('C')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('D')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('E')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('F')->getAlignment()->setWrapText(true);
            },
        ];
    }
}
