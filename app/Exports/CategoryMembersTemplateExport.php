<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CategoryMembersTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            [
                '1234567890', // national_id
                'XL', // size
                'وصف العضو', // description
                '2024-03-20', // date
                '100.00', // amount
                'خاصية 1', // property1
                'خاصية 2', // property2
                'خاصية 3', // property3
                'خاصية 4', // property4
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'رقم الهوية',
            'الحجم',
            'الوصف',
            'التاريخ',
            'المبلغ',
            'خاصية 1',
            'خاصية 2',
            'خاصية 3',
            'خاصية 4'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
} 