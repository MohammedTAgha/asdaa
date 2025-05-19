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
    }    public function headings(): array
    {
        return [
            'رقم المواطن',           // Citizen ID
            'جنس المواطن',          // Citizen Gender
            'رقم الزوج/ة',          // Wife/Husband ID
            'جنس الزوج/ة',          // Wife/Husband Gender
            'نوع العلاقة',          // Relationship Type
            'نوع الإضافة',         // Addition Type (Father/Mother)
            'الحالة',              // Status
            'سبب الفشل',           // Failure Reason
            'تاريخ المحاولة'        // Attempt Date
        ];
    }

    public function collection()
    {
        $rows = [];
        foreach ($this->failures as $failure) {
            $rows[] = [
                'citizen_id' => $failure['citizen_id'],
                'citizen_gender' => $failure['citizen_gender'] ?? '---',
                'spouse_id' => $failure['person_id'] ?? '---',
                'spouse_gender' => $failure['person_gender'] ?? '---',
                'relationship' => $failure['relationship'] ?? '---',
                'addition_type' => $this->getAdditionType($failure['relationship']),
                'status' => 'فشل',
                'reason' => $failure['reason'],
                'attempt_date' => $failure['attempt_date']
            ];
        }
        return new Collection($rows);
    }

    protected function getAdditionType($relationship)
    {
        return $relationship === 'father' ? 'إضافة كأب' : 'إضافة كأم';
    }

    public function styles(Worksheet $sheet)
    {
        // Set RTL direction for the entire sheet
        $sheet->setRightToLeft(true);

        // Style the header row
        $sheet->getStyle('A1:I1')->applyFromArray([
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
        ]);        // Adjust column widths
        $sheet->getColumnDimension('A')->setWidth(15); // Citizen ID
        $sheet->getColumnDimension('B')->setWidth(12); // Citizen Gender
        $sheet->getColumnDimension('C')->setWidth(15); // Spouse ID
        $sheet->getColumnDimension('D')->setWidth(12); // Spouse Gender
        $sheet->getColumnDimension('E')->setWidth(15); // Relationship
        $sheet->getColumnDimension('F')->setWidth(15); // Addition Type
        $sheet->getColumnDimension('G')->setWidth(10); // Status
        $sheet->getColumnDimension('H')->setWidth(30); // Failure Reason
        $sheet->getColumnDimension('I')->setWidth(20); // Date

        // Style all cells
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:I' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);        // Color coding for the status and IDs
        foreach ($sheet->getRowIterator(2) as $row) {
            $rowIndex = $row->getRowIndex();
            
            // Style the status column (G)
            $sheet->getStyle('G' . $rowIndex)->applyFromArray([
                'font' => ['color' => ['rgb' => 'FF0000']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFE6E6']
                ]
            ]);

            // Highlight IDs in different colors
            $citizenCell = $sheet->getCellByColumnAndRow(1, $rowIndex); // Column A
            $spouseCell = $sheet->getCellByColumnAndRow(3, $rowIndex);  // Column C

            if (!empty($citizenCell->getValue())) {
                $sheet->getStyle('A' . $rowIndex)->applyFromArray([
                    'font' => ['color' => ['rgb' => '0000FF']] // Blue for citizen ID
                ]);
            }

            if (!empty($spouseCell->getValue()) && $spouseCell->getValue() !== '---') {
                $sheet->getStyle('C' . $rowIndex)->applyFromArray([
                    'font' => ['color' => ['rgb' => 'FF0000']] // Red for spouse ID
                ]);
            }
        }

        // Add conditional formatting for gender columns
        foreach ($sheet->getRowIterator(2) as $row) {
            $rowIndex = $row->getRowIndex();
            
            // Style gender columns (B and D)
            $citizenGender = $sheet->getCellByColumnAndRow(2, $rowIndex)->getValue();
            $spouseGender = $sheet->getCellByColumnAndRow(4, $rowIndex)->getValue();

            if ($citizenGender === 'ذكر') {
                $sheet->getStyle('B' . $rowIndex)->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E6F3FF']]
                ]);
            } elseif ($citizenGender === 'أنثى') {
                $sheet->getStyle('B' . $rowIndex)->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFE6F3']]
                ]);
            }

            if ($spouseGender === 'ذكر') {
                $sheet->getStyle('D' . $rowIndex)->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E6F3FF']]
                ]);
            } elseif ($spouseGender === 'أنثى') {
                $sheet->getStyle('D' . $rowIndex)->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFE6F3']]
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
