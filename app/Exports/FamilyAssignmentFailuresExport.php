<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Collection;

class FamilyAssignmentFailuresExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $failures;

    public function __construct(array $failures)
    {
        $this->failures = $failures;
    }

    public function collection()
    {
        return new Collection($this->failures);
    }

    public function headings(): array
    {
        return [
            'رقم المواطن',
            'رقم الهوية المراد إضافته',
            'نوع العلاقة',
            'سبب الفشل',
            'ملاحظات',
            'تاريخ المحاولة'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set RTL direction for the entire sheet
        $sheet->setRightToLeft(true);

        // Style the header row
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0056b3']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ]
        ]);

        // Adjust column widths
        $sheet->getColumnDimension('A')->setWidth(15); // Citizen ID
        $sheet->getColumnDimension('B')->setWidth(15); // Person ID
        $sheet->getColumnDimension('C')->setWidth(12); // Relation Type
        $sheet->getColumnDimension('D')->setWidth(25); // Failure Reason
        $sheet->getColumnDimension('E')->setWidth(30); // Notes
        $sheet->getColumnDimension('F')->setWidth(20); // Date

        // Style all cells
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:F' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);

        // Highlight failed IDs in red
        foreach ($sheet->getRowIterator(2) as $row) {
            if (!empty($row->getCellByColumnAndRow(2, $row->getRowIndex())->getValue())) {
                $sheet->getStyle('B' . $row->getRowIndex())->applyFromArray([
                    'font' => ['color' => ['rgb' => 'FF0000']]
                ]);
            }
        }

        return $sheet;
    }

    public function title(): string
    {
        return 'تقرير الإضافات الفاشلة';
    }
}
