<?php
namespace App\Exports;

use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CitizensExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Citizen::all();
    }

    // public function headings(): array
    // {
    //     return ['id', 'firstname','secondname','thirdname',lastname', 'Date of Birth', 'Gender', 'Region', 'Wife ID', 'Wife Name', 'Widowed', 'Social Status', 'Living Status', 'Job', 'Original Address', 'Elderly Count', 'Note'];
    // }
}