<?php

namespace App\Exports;

use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class CitizensExport implements FromQuery, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Citizen::query();

        // Apply the same filters as in the index method
        // (Copy the filtering logic from the CitizenController index method)

        return $query;
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