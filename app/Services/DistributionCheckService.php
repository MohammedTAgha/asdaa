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
     * Check which citizens are in of distributions.
     *
     * @param array $citizenIds
     * @param array $distributionIds the specified list
     * @return array
     */
    public function checkCitizensInDistributions(array $citizenIds, array $distributionIds)
    {
        return $this->checkCitizens($citizenIds, $distributionIds);
    }

    /**
     * Check which citizens are out of the specified distribution.
     *
     * @param array $citizenIds
     * @param int $distributionId
     * @return array
     */
    public function checkCitizensOutOfDistribution(array $citizenIds, int $distributionId)
    {
        return $this->checkCitizens($citizenIds, [$distributionId]);
    }

    /**
     * Helper method to check citizens against distributions.
     *
     * @param array $citizenIds
     * @param array $distributionIds
     * @return array
     */
    private function checkCitizens(array $citizenIds, array $distributionIds)
    {
        // Fetch citizen IDs in the specified distributions
        $citizensIn = Distribution::whereIn('distribution_id', $distributionIds)
            ->whereIn('citizen_id', $citizenIds)
            ->pluck('citizen_id')
            ->toArray();

        // Determine which citizens are in and which are out
        return [
            'in' => array_intersect($citizenIds, $citizensIn),
            'out' => array_diff($citizenIds, $citizensIn),
        ];
    }

    //not used
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
