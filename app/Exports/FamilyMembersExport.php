<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class FamilyMembersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $members;

    public function __construct($members)
    {
        $this->members = $members;
    }

    public function collection()
    {
        return $this->members;
    }    public function headings(): array
    {
        return [
            'رقم هوية الفرد',
            'اسم الفرد',
            'تاريخ الميلاد',
            ' الميلاد',
            ' العمر',
            'الجنس',

            'صلة القرابة',
            'العمر',
            'رقم هوية رب الأسرة',
            'اسم رب الأسرة',
            'تاريخ ميلاد رب الأسرة',

            'المنطقة',
            'ملاحظات',
            'تصنيفات',
        ];
    }

    public function map($member): array
    {
        $citizen = $member->citizen;
        $citizenName = $citizen ? $citizen->firstname . ' ' . $citizen->secondname . ' ' . 
                      ($citizen->thirdname ? $citizen->thirdname . ' ' : '') . $citizen->lastname : 'غير محدد';
        
        return [
            $member->national_id,
            $member->firstname . ' ' . $member->secondname . ' ' . ($member->thirdname ? $member->thirdname . ' ' : '') . $member->lastname,
            $member->date_of_birth ? Carbon::parse($member->date_of_birth)->format('Y-m-d') : 'غير محدد',
            $member->age ?? ' ',
            $member->gender === 'male' ? 'ذكر' : 'أنثى',
            $this->getRelationshipText($member->relationship),
            $citizen ? $citizen->id : 'غير محدد',
            $citizenName,
            $citizen && $citizen->date_of_birth ? Carbon::parse($citizen->date_of_birth)->format('Y-m-d') : 'غير محدد',
            $member->citizen->region->name ?? 'غير محدد',
            $member->notes,
            $member->CategoryNamesString ??'-',
        ];
    }

    private function getRelationshipText($relationship)
    {
        return [
            'father' => 'الأب',
            'mother' => 'الأم',
            'son' => 'ابن',
            'daughter' => 'ابنة',
            'other' => 'آخر'
        ][$relationship] ?? $relationship;
    }
}
