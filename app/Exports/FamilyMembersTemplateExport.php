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

class FamilyMembersTemplateExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{    public function collection()
    {
        // Return one sample row
        return new Collection([[    
            '901631556',      // citizen_id
            'محمد',           // firstname
            'تبسيم',          // secondname
            'ابراهيم',        // thirdname
            'الاغا',          // lastname
            '409790273',      // national_id
            '2000-01-01',     // date_of_birth
            'ذكر',            // gender
            'son',            // relationship
            'نعم',            // is_accompanying
            'ملاحظات'         // notes
        ]]);
    }

    public function headings(): array
    {
        return [
            'رقم هوية رب الأسرة (مطلوب)',
            'الاسم الأول (مطلوب)',
            'اسم الأب (مطلوب)',
            'اسم الجد',
            'اسم العائلة (مطلوب)',
            'رقم الهوية (مطلوب)',
            'تاريخ الميلاد (مطلوب)',
            'الجنس (مطلوب)',
            'صلة القرابة (مطلوب)',
            'مرافق',
            'ملاحظات'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(15); // citizen_id
        $sheet->getColumnDimension('B')->setWidth(20); // firstname
        $sheet->getColumnDimension('C')->setWidth(20); // secondname
        $sheet->getColumnDimension('D')->setWidth(20); // thirdname
        $sheet->getColumnDimension('E')->setWidth(20); // lastname
        $sheet->getColumnDimension('F')->setWidth(15); // national_id
        $sheet->getColumnDimension('G')->setWidth(15); // date_of_birth
        $sheet->getColumnDimension('H')->setWidth(10); // gender
        $sheet->getColumnDimension('I')->setWidth(15); // relationship
        $sheet->getColumnDimension('J')->setWidth(15); // is_accompanying
        $sheet->getColumnDimension('K')->setWidth(30); // notes

        // Format headers
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0066CC'],
            ],
        ]);

        // Add data validation for gender
        $validation = $sheet->getCell('H2')->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST)
            ->setErrorStyle(DataValidation::STYLE_INFORMATION)
            ->setAllowBlank(false)
            ->setShowInputMessage(true)
            ->setShowErrorMessage(true)
            ->setShowDropDown(true)
            ->setErrorTitle('خطأ في الإدخال')
            ->setError('الرجاء اختيار القيمة من القائمة')
            ->setPromptTitle('اختر الجنس')
            ->setPrompt('اختر ذكر أو أنثى')
            ->setFormula1('"ذكر,أنثى"');
        $sheet->setDataValidation('H2:H1000', $validation);

        // Add data validation for relationship
        $validation = $sheet->getCell('I2')->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST)
            ->setErrorStyle(DataValidation::STYLE_INFORMATION)
            ->setAllowBlank(false)
            ->setShowInputMessage(true)
            ->setShowErrorMessage(true)
            ->setShowDropDown(true)
            ->setErrorTitle('خطأ في الإدخال')
            ->setError('الرجاء اختيار القيمة من القائمة')
            ->setPromptTitle('اختر صلة القرابة')
            ->setPrompt('اختر صلة القرابة')
            ->setFormula1('"father,mother,son,daughter"');
        $sheet->setDataValidation('I2:I1000', $validation);

        // Add data validation for is_accompanying
        $validation = $sheet->getCell('J2')->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST)
            ->setErrorStyle(DataValidation::STYLE_INFORMATION)
            ->setAllowBlank(true)
            ->setShowInputMessage(true)
            ->setShowErrorMessage(true)
            ->setShowDropDown(true)
            ->setErrorTitle('خطأ في الإدخال')
            ->setError('الرجاء اختيار نعم أو لا')
            ->setPromptTitle('هل مرافق؟')
            ->setPrompt('اختر نعم أو لا')
            ->setFormula1('"نعم,لا"');
        $sheet->setDataValidation('J2:J1000', $validation);

        // Format national_id as text
        $sheet->getStyle('F2:F1000')->getNumberFormat()->setFormatCode('@');

        // Add date validation and format
        $sheet->getStyle('G2:G1000')->getNumberFormat()->setFormatCode('yyyy-mm-dd');

        // Add a sample row
        $sheet->fromArray([
            [
                '901631556',       // citizen_id
                'محمد',            // firstname
                'تبسيم',           // secondname
                'ابراهيم',         // thirdname
                'الاغا',           // lastname
                '409790273',       // national_id
                '2000-01-01',      // date_of_birth
                'ذكر',             // gender
                'son',             // relationship
                'نعم',             // is_accompanying
                'ملاحظة توضيحية'    // notes
            ]
        ], null, 'A2');

        return $sheet;
    }    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,    // citizen_id
            'F' => NumberFormat::FORMAT_TEXT,    // national_id
            'G' => 'yyyy-mm-dd',                 // date_of_birth
        ];
    }
}
