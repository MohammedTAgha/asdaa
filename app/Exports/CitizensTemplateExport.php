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
            'phone2',
            'family_members',
            'wife_id',
            'wife_name',
            'mails_count',
            'femails_count',
            'leesthan3',        
            'obstruction',
            'obstruction_description',
            'disease',
            'disease_description',
            'job',
            'living_status',
            'original_address',
            'note',
            'region_id',
        ];
    }
}
