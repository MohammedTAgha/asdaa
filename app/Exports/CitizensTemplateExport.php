<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class CitizensTemplateExport implements WithHeadings
{
    public function headings(): array
    {
        return [

            'رقم الهوية',
            'الاسم الاول',
            ' اسم الاب',
            'اسم الجد',
            'اسم العائلة',
            'رقم الجوال',
            'رقم الجوال البديل',
            'عدد الأفراد',
            'هوية الزوجة',
            'اسم الزوجة رباعي',
            'عدد الذكور',
            'عدد الاناث',
            'عدد الافراد اقل من 3 سنوات',
            'عدد الافراد ذوي الاحتياجات الخاصة',
            'وصف الاحتياجات الخاصة',
            'عدد الافراد ذوي الامراض المزمنة',
            'وصف الامراض المزمنة',
            'العمل',
            'حالة السكن',
            'original_address',
            'note',
            'رقم المنطقة',
            'الحالة الاجتماعية',
            // 'date_of_birth' => $row['date_of_birth'],
            // 'gender' => $row['gender'],
            // 'elderly_count' => $row['elderly_count'],


            // 'id',
            // 'firstname',
            // 'secondname',
            // 'thirdname',
            // 'lastname',
            // 'phone',
            // 'phone2',
            // 'family_members',
            // 'wife_id',
            // 'wife_name',
            // 'mails_count',
            // 'femails_count',
            // 'leesthan3',        
            // 'obstruction',
            // 'obstruction_description',
            // 'disease',
            // 'disease_description',
            // 'job',
            // 'living_status',
            // 'original_address',
            // 'note',
            // 'region_id',
        ];
    }
}
