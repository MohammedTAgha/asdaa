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
    }

    public function headings(): array
    {
        return [
            'رقم الهوية',
            'الاسم الكامل',
            'صلة القرابة',
            'الجنس',
            'العمر',
            'المنطقة',
            'ملاحظات'
        ];
    }

    public function map($member): array
    {
        return [
            $member->national_id,
            $member->firstname . ' ' . $member->secondname . ' ' . $member->lastname,
            $this->getRelationshipText($member->relationship),
            $member->gender === 'male' ? 'ذكر' : 'أنثى',
            Carbon::parse($member->date_of_birth)->age,
            $member->citizen->region->name ?? 'غير محدد',
            $member->notes
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
