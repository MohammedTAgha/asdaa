<?php

namespace App\Exports;

use App\Models\Region;
use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CitizensByRegionExport implements WithMultipleSheets
{
    protected $citizens;

    public function __construct($citizens)
    {
        $this->citizens = $citizens;
    }    public function sheets(): array
    {
        $sheets = [];
        
        // Add first sheet with all citizens
        $sheets[] = new CitizensByRegionSheet($this->citizens, 'جميع المواطنين');
        
        // Group citizens by region for additional sheets
        $citizensByRegion = $this->citizens->groupBy('region_id');
        
        foreach ($citizensByRegion as $regionId => $citizens) {
            $region = Region::find($regionId);
            $sheetName = $region ? $region->name : 'بدون منطقة';
            
            // Create a new sheet for each region
            $sheets[] = new CitizensByRegionSheet($citizens, $sheetName);
        }

        return $sheets;
    }
}