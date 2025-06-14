<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoryMembersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function collection()
    {
        return $this->category->familyMembers()
            ->with(['citizen' => function($query) {
                $query->select('id', 'firstname', 'secondname', 'thirdname', 'lastname', 'phone');
            }])
            ->get();
    }

    public function headings(): array
    {
        return [
            ' ID',
            'اسم الفرد',
            'هوية الفرد',
            'هوية رب الاسرة',
            'اسم رب الاسرة',
            'تواصل',
            'تاريخ الميلاد',
            'العمر',
            'الجنس',
            'الوصف',
            'تاريخ',
            'عدد',
            'خاصية 1',
            'خاصية 2',
            'خاصية 3',
            'خاصية 4'
        ];
    }

    public function map($member): array
    {
        return [
            $member->id,
            $member->firstname . ' ' . $member->secondname . ' ' . 
            ($member->thirdname ? $member->thirdname . ' ' : '') . $member->lastname,
            $member->national_id,
            $member->citizen->id ?? 'N/A',
            $member->citizen ? 
                $member->citizen->firstname . ' ' . $member->citizen->secondname . ' ' . 
                ($member->citizen->thirdname ? $member->citizen->thirdname . ' ' : '') . 
                $member->citizen->lastname : ' ',
            $member->citizen->phone ?? 'N/A',
            $member->date_of_birth ??'N/A',
            $member->age ??'-',
            $member->gender ??' - ',
            $member->pivot->size ?? 'N/A',
            $member->pivot->description ?? 'N/A',
            $member->pivot->date ? $member->pivot->date->format('Y-m-d') : 'N/A',
            $member->pivot->amount ?? 'N/A',
            $member->pivot->property1 ?? 'N/A',
            $member->pivot->property2 ?? 'N/A',
            $member->pivot->property3 ?? 'N/A',
            $member->pivot->property4 ?? 'N/A',
            $member->CategoryNamesString ??'-',
        ];
    }
} 