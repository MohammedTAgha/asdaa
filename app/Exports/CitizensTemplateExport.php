<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class CitizensTemplateExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            'id',
            'firstname',
            'secondname',
            'thirdname',
            'lastname',
            'phone',
            'family_members',
            'wife_id',
            'wife_name',
            'date_of_birth',
            'gender',
            'elderly_count',
            'obstruction',
            'obstruction_description',
            'disease',
            'disease_description',
            'job',
            'living_status',
            'social_status',
            'original_address',
            'region_id',
            'note',
        ];
    }
}