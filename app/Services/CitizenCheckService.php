<?php

namespace App\Services;

use App\Models\Citizen;
use App\Models\Region;

class CitizenCheckService
{
    /**
     * Check citizens against the given criteria (exist ; not exist; inregion; in outher region ').
     *
     * @param array $citizenIds
     * @param int $regionId
     * @return array
     */
    public function checkCitizens(array $citizenIds, int $regionId)
    {
        // Get the citizens that exist in the database
        $existingCitizens = Citizen::whereIn('id', $citizenIds)->get();

        // Separate citizens who exist and who don't exist in the database
        $citizensExist = $existingCitizens->pluck('id')->toArray();
        $citizensNotExist = array_diff($citizenIds, $citizensExist);
        
        // Check if the citizens exist in the specified region
        $citizensInRegion = $existingCitizens->where('region_id', $regionId)->pluck('id')->toArray();
        $citizensInOtherRegions = array_diff($citizensExist, $citizensInRegion);
        // $citizensInOtherRegions
        return [
            'exist' => $citizensExist,
            'not_exist' => $citizensNotExist,
            'in_region' => $citizensInRegion,
            'in_other_regions' => $citizensInOtherRegions,
        ];
    }
}
