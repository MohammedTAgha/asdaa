<?php

namespace App\Exports;

use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class CitizensExport implements FromCollection 
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

}