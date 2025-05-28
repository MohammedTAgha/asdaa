<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Illuminate\Support\Collection;

class CategoryMembersTemplateExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    public function collection()
    {
        // Return one sample row
        return new Collection([[
            '409790273',      // national_id
            'XL',            // size
            'وصف العضو',      // description
            '2024-03-20',    // date
            '100.00',        // amount
            'خاصية 1',        // property1
            'خاصية 2',        // property2
            'خاصية 3',        // property3
            'خاصية 4'         // property4
        ]]);
    }

    public function headings(): array
    {
        return [
            'national_id (required)',
            'size',
            'description',
            'date',
            'amount',
            'property1',
            'property2',
            'property3',
            'property4'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(15); // national_id
        $sheet->getColumnDimension('B')->setWidth(10); // size
        $sheet->getColumnDimension('C')->setWidth(30); // description
        $sheet->getColumnDimension('D')->setWidth(15); // date
        $sheet->getColumnDimension('E')->setWidth(15); // amount
        $sheet->getColumnDimension('F')->setWidth(15); // property1
        $sheet->getColumnDimension('G')->setWidth(15); // property2
        $sheet->getColumnDimension('H')->setWidth(15); // property3
        $sheet->getColumnDimension('I')->setWidth(15); // property4

        // Format headers
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0066CC'],
            ],
        ]);

        // Add data validation for size
        $validation = $sheet->getCell('B2')->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST)
            ->setErrorStyle(DataValidation::STYLE_INFORMATION)
            ->setAllowBlank(true)
            ->setShowInputMessage(true)
            ->setShowErrorMessage(true)
            ->setShowDropDown(true)
            ->setErrorTitle('خطأ في الإدخال')
            ->setError('الرجاء اختيار القيمة من القائمة')
            ->setPromptTitle('اختر الحجم')
            ->setPrompt('اختر الحجم')
            ->setFormula1('"XS,S,M,L,XL,XXL"');
        $sheet->setDataValidation('B2:B1000', $validation);

        // Format national_id as text
        $sheet->getStyle('A2:A1000')->getNumberFormat()->setFormatCode('@');

        // Add date validation and format
        $sheet->getStyle('D2:D1000')->getNumberFormat()->setFormatCode('yyyy-mm-dd');

        // Add amount format
        $sheet->getStyle('E2:E1000')->getNumberFormat()->setFormatCode('#,##0.00');

        return $sheet;
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,    // national_id
            'D' => 'yyyy-mm-dd',                 // date
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // amount
        ];
    }
} 