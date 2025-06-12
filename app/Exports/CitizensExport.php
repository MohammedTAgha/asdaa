<?php

namespace App\Exports;

use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use App\Traits\LogsExports;

class CitizensExport implements FromCollection, WithHeadings
{
    use LogsExports;
{
    protected $citizens;

    public function __construct($citizens)
    {
        $this->citizens = $citizens;
    }

    public function collection()
    {
        return $this->citizens->map(function ($citizen) {
            return [
                $citizen->id,
                $citizen->fullName ?? null,
                $citizen->firstname,
                $citizen->secondname,
                $citizen->thirdname,
                $citizen->lastname,
                $citizen->phone,
                $citizen->phone2,
                $citizen->wife_id,
                $citizen->wife_name,
                $citizen->family_members,
                $citizen->mails_count,
                $citizen->femails_count,
                $citizen->social_status,
                $citizen->original_address,
                $citizen->disease_description,
                $citizen->note,

                $citizen->leesthan3,
                $citizen->disease,
                $citizen->obstruction,
                $citizen->job,
                $citizen->living_status,
                $citizen->obstruction_description,
                $citizen->original_address,
                $citizen->elderly_count,

                $citizen->date_of_birth,
                $citizen->gender,
                $citizen->is_archived,
                $citizen->region->representatives->first()->name ?? 'مندوب غير محدد',
                $citizen->region ? $citizen->region->name : null, // Include region name

            ];
        });
    }

    public function headings(): array
    {
        // return [
        //     'الهوية',
        //     'الاسم رباعي',
        //     'الاسم الأول',
        //     'الاسم الثاني',
        //     'الاسم الثالث',
        //     'اسم العائلة',
        //     'الهاتف',
        //     'الهاتف الثاني',
        //     'معرف الزوجة',
        //     'اسم الزوجة',
        //     'عدد أفراد الأسرة',
        //     'عدد الذكور',
        //     'عدد الإناث',
        //     'الحالة الاجتماعية',
        //     'العنوان الأصلي',
        //     'وصف المرض',

        //     'أقل من 3',
        //     'العائق',
        //     'وصف العائق',
        //     'المرض',
        //     'الوظيفة',
        //     'حالة المعيشة',
        //     'ملاحظات',
        //     'اسم المنطقة',
        //     'تاريخ الميلاد',
        //     'الجنس',
        //     'عدد كبار السن',
        //     'علامة الأرشفة',
        //     'region',

        // ];
        return [
            'رقم الهوية',
            ' الاسم رباعي',
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
            'مكان السكن الاصلي',
            'عدد كبار السن',
            'تاريخ الميلاد',
            'الجنس',
            'is_archived',
            'المندوب',
            'المنظقة',
        ];
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
        $sheet->getStyle('A1:AD1')->getAlignment()->setHorizontal('right');

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