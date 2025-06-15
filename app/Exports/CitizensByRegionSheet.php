<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CitizensByRegionSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $citizens;
    protected $sheetName;

    public function __construct($citizens, $sheetName)
    {
        $this->citizens = $citizens;
        $this->sheetName = $sheetName;
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
            ];
        });
    }

    public function headings(): array
    {
        return [
            'رقم الهوية',
            'الاسم رباعي',
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
            'وصف الامراض المزمنة',
            'ملاحظات',
            'عدد الافراد اقل من 3 سنوات',
            'عدد الافراد ذوي الامراض المزمنة',
            'عدد الافراد ذوي الاحتياجات الخاصة', 
            'معيل الاسرة',
            'حالة السكن',
            'وصف ذوي الاحتياجات الخاصة',
            'مكان السكن الاصلي',
            'عدد كبار السن',
            'تاريخ الميلاد',
            'الجنس',
            'مؤرشف',
            'المندوب'
        ];
    }

    public function title(): string
    {
        // Return the sheet name (region name)
        return $this->sheetName;
    }
}