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
            'date_of_birth',
            'gender',
            'region_id',
            'wife_id',
            'wife_name',
            'widowed',
            'social_status',
            'living_status',
            'job',
            'original_address',
            'elderly_count',
            'note',
        ];
    }
}