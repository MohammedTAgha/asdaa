<?php

namespace App\Services;

use App\Models\Citizen;
use App\Models\Distribution;
use Illuminate\Support\Collection;

class DistributionCheckService
{
    /**
     * Check citizens against a distribution and optionally against other distributions.
     *
     * @param Distribution $distribution
     * @param array $citizenIds
     * @param array|null $otherDistributionIds
     * @return array
     */
    public function checkCitizensInDistribution(Distribution $distribution, array $citizenIds, array $otherDistributionIds = null)
    {
        // Get citizens who exist in the database
        $existingCitizens = Citizen::whereIn('id', $citizenIds)->get();

        // Citizens who exist in the database
        $citizensExist = $existingCitizens->pluck('id')->toArray();

        // Citizens who don't exist in the database
        $citizensNotExist = array_diff($citizenIds, $citizensExist);

        // Citizens who exist in the current distribution
        $citizensInCurrentDistribution = $distribution->citizens()->whereIn('citizen_id', $citizensExist)->pluck('citizen_id')->toArray();

        // Citizens who do not exist in the current distribution
        $citizensNotInCurrentDistribution = array_diff($citizensExist, $citizensInCurrentDistribution);

        $citizensInOtherDistributions = [];
        $citizensNotInOtherDistributions = [];

        if ($otherDistributionIds) {
            // Get citizens who exist in the provided distributions
            $citizensInOtherDistributions = Distribution::whereIn('id', $otherDistributionIds)
                ->whereHas('citizens', function($query) use ($citizensExist) {
                    $query->whereIn('citizen_id', $citizensExist);
                })->pluck('citizen_id')->toArray();

            // Citizens who do not exist in the provided distributions
            $citizensNotInOtherDistributions = array_diff($citizensExist, $citizensInOtherDistributions);
        }

        return [
            'exist_in_database' => $citizensExist,
            'not_exist_in_database' => $citizensNotExist,
            'in_current_distribution' => $citizensInCurrentDistribution,
            'not_in_current_distribution' => $citizensNotInCurrentDistribution,
            'in_other_distributions' => $citizensInOtherDistributions,
            'not_in_other_distributions' => $citizensNotInOtherDistributions,
        ];
    }

    /**
     * Remove citizens from the current distribution who have benefited from other distributions.
     *
     * @param Distribution $distribution
     * @param array $citizenIds
     * @return void
     */
    public function removeCitizensFromDistribution(Distribution $distribution, array $citizenIds)
    {
        $distribution->citizens()->detach($citizenIds);
    }
}
