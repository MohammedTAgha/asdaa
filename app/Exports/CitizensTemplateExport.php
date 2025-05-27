<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
class CitizensTemplateExport implements  WithHeadings, WithStyles, WithCustomStartCell
{
    public function headings(): array
    {

        return [
            'رقم الهوية',
            ' فارغ',
            'الاسم الاول',
            'اسم الاب',
            'اسم الجد',
            'اسم العائلة',
            'رقم الجوال',
            'رقم الجوال البديل',
            'رقم هوية الزوجة',
            'اسم الزوجة رباعي',
            'عدد الافراد',
            'عدد الذكور',
            'عدد الاناث',
            'الحالة الاجتماعية',
            'مكان السكن الاصلي',
            'وصف ذوي الامراض المزمنة',
            'ملاحظات',
            'عدد الافراد اقل من 3 سنوات',
            'عدد الافراد ذوي الامراض المزمنة',
            'عدد الافراد ذوي الاحتياجات الخاصة',
            'معيل الاسرة ( 1. لا يعمل , 2. عامل , 3. موظف )',
            'حالة السكن ( 1. سيئ , 2. جيد ,3.ممتاز)',

            'وصف ذوي الاحتياجات الخاصة',
            'رقم المحافظة الاصلية',
            'عدد كبار السن',
            'تاريخ الميلاد',
            'is_archived',
        ];
        // return [
        //     'رقم الهوية',
        //     'الاسم الاول',
        //     'اسم الاب',
        //     'اسم الجد',
        //     'اسم العائلة',
        //     'رقم الجوال',
        //     'رقم الجوال البديل',
        //     'عدد الافراد',
        //     'رقم هوية الزوجة',
        //     'اسم الزوجة رباعي',
        //     'عدد الذكور',
        //     'عدد الاناث',
        //     'عدد الافراد اقل من 3 سنوات',
        //     'عدد الافراد ذوي الاحتياجات الخاصة',
        //     'وصف ذوي الاحتياجات الخاصة',
        //     'عدد الافراد ذوي الامراض المزمنة',
        //     'وصف ذوي الامراض المزمنة',
        //     'معيل الاسرة ( 1. لا يعمل , 2. عامل , 3. موظف )',
        //     'حالة السكن ( 1. سيئ , 2. جيد ,3.ممتاز)',
        //     'رقم المحافظة الاصلية',
        //     'مكان السكن الاصلي',
        //     'ملاحظات',
        //     'عدد كبار السن',
        //     'الحالة الاجتماعية',
        //     'تاريخ الميلاد',
        //     'is_archived',
        // ];
        // return [
        //     'id',
        //     'firstname',
        //     'secondname',
        //     'thirdname',
        //     'lastname',
        //     'phone',
        //     'phone2',
        //     'family_members',
        //     'wife_id',
        //     'wife_name',
        //     'mails_count',
        //     'femails_count',
        //     'leesthan3',        
        //     'obstruction',
        //     'obstruction_description',
        //     'disease',
        //     'disease_description',
        //     'job',
        //     'living_status',
        //     'original_address',
        //     'note',
        //     'region_id',
        // ];
    }

     /**
     * Apply styles to the header row.
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Set sheet direction to right-to-left
        $sheet->getStyle('A1:Z1')->getAlignment()->setHorizontal('right');

        // Apply bold styling to the header row and set background color
        return [
            // Styling for header row
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4CAF50'], // Example: Green background
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT, // Align right
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Center vertically
                ],
            ],
        ];
    }

    /**
     * Set the custom starting cell (optional).
     *
     * @return string
     */
    public function startCell(): string
    {
        return 'A1'; // Starts from A1, change if you want to start elsewhere
    }
}
