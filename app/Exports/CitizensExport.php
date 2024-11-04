<?php

namespace App\Exports;

use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class CitizensExport implements FromCollection ,WithHeadings
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
                $citizen->firstname,
                $citizen->secondname,
                $citizen->thirdname,
                $citizen->lastname,
                $citizen->phone,
                $citizen->phone2,
                $citizen->family_members,
                $citizen->wife_id,
                $citizen->wife_name,
                $citizen->mails_count,
                $citizen->femails_count,
                $citizen->leesthan3,
                $citizen->obstruction,
                $citizen->obstruction_description,
                $citizen->disease,
                $citizen->disease_description,
                $citizen->job,
                $citizen->living_status,
                $citizen->original_address,
                $citizen->note,
                $citizen->region ? $citizen->region->name : null, // Include region name
                $citizen->date_of_birth,
                $citizen->gender,
                $citizen->social_status,
                $citizen->elderly_count,
                $citizen->is_archived,
                $citizen->region->representatives->first()->name ?? 'مندوب غير محدد'
            ];
        });
    }

    public function headings(): array
    {
        return [
            'الرقم',
            'الاسم الأول',
            'الاسم الثاني',
            'الاسم الثالث',
            'اسم العائلة',
            'الهاتف',
            'الهاتف الثاني',
            'عدد أفراد الأسرة',
            'معرف الزوجة',
            'اسم الزوجة',
            'عدد الذكور',
            'عدد الإناث',
            'أقل من 3',
            'العائق',
            'وصف العائق',
            'المرض',
            'وصف المرض',
            'الوظيفة',
            'حالة المعيشة',
            'العنوان الأصلي',
            'ملاحظات',
            'اسم المنطقة',
            'تاريخ الميلاد',
            'الجنس',
            'الحالة الاجتماعية',
            'عدد كبار السن',
            'علامة الأرشفة',
            'region',

        ];
    }

}