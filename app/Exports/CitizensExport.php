<?php

namespace App\Exports;

use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class CitizensExport implements FromCollection , WithHeadings
{
    protected $citizens;

    public function __construct($citizens)
    {
        $this->citizens = $citizens;
    }

    public function collection()
    {
        return $this->citizens;
    }
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