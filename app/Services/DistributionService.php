<?php
namespace App\Services;

use App\Models\Citizen;
use Illuminate\Support\Facades\DB;

class DistributionService
{
    public function addCitizensToDistribution(array $citizenIds, $distributionId, array $filters = [])
    {
        $totalIds = count($citizenIds);
        DB::beginTransaction();

        try {
            // Apply filters to the citizens list before adding
            $citizenIds = $this->applyFilters($citizenIds, $filters);

            // Check which citizens already exist in the distribution
            $existingInDistribution = DB::table("distribution_citizens")
                ->where("distribution_id", $distributionId)
                ->whereIn("citizen_id", $citizenIds)
                ->pluck("citizen_id")
                ->toArray();

            // Check which citizens exist in the citizens table
            $existingCitizens = Citizen::whereIn("id", $citizenIds)->pluck("id")->toArray();

            // Identify non-existent citizens
            $nonExistentCitizens = array_diff($citizenIds, $existingCitizens);

            // Identify citizens to be added (exist in citizens table but not in distribution)
            $citizensToAdd = array_diff($existingCitizens, $existingInDistribution);

            $addedCount = 0;
            $addedCitizens = [];

            foreach ($citizensToAdd as $citizenId) {
                DB::table("distribution_citizens")->insert([
                    "distribution_id" => $distributionId,
                    "citizen_id" => $citizenId,
                ]);
                $addedCount++;
                $addedCitizens[] = $citizenId;
            }

            $existingCitizenData = Citizen::whereIn("id", $existingInDistribution)
                ->select('id', 'firstname', 'lastname')
                ->get()
                ->toArray();

            $addedCitizenData = Citizen::whereIn("id", $addedCitizens)
                ->select('id', 'firstname', 'lastname')
                ->get()
                ->toArray();

            DB::commit();

            return [
                'added' => [
                    'count' => $addedCount,
                    'citizens' => $addedCitizenData
                ],
                'existing' => [
                    'count' => count($existingInDistribution),
                    'citizens' => $existingCitizenData
                ],
                'updated' => [
                    'count' => count($nonExistentCitizens),
                    'citizens' => $nonExistentCitizens // This will be an array of IDs
                ],
                'nonexistent' => [
                    'count' => count($nonExistentCitizens),
                    'citizens' => $nonExistentCitizens // This will be an array of IDs
                ],
                'totalIds' => $totalIds
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Error adding citizens: " . $e->getMessage());
        }
    }
        /**
     * Remove citizens from a distribution based on given filters.
     *
     * @param int $distributionId
     * @param array $filters
     * @return array
     * @throws \Exception
     */
    public function removeCitizensFromDistribution(int $distributionId, array $filters = [])
    {
        DB::beginTransaction();

        try {
            // Get the list of citizens to be removed based on filters
            $citizenIds = $this->applyFiltersForDeletion($distributionId, $filters);

            // Delete citizens from the distribution
            $deletedCount = DB::table('distribution_citizens')
                ->where('distribution_id', $distributionId)
                ->whereIn('citizen_id', $citizenIds)
                ->delete();

            DB::commit();

            return [
                'deleted' => [
                    'count' => $deletedCount,
                    'citizens' => $citizenIds
                ],
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Error removing citizens: " . $e->getMessage());
        }
    }

        /**
     * Apply filters to find citizens for deletion from a distribution.
     *
     * @param int $distributionId
     * @param array $filters
     * @return array
     */
    private function applyFiltersForDeletion(int $distributionId, array $filters)
    {
        $query = DB::table('distribution_citizens')
            ->join('citizens', 'distribution_citizens.citizen_id', '=', 'citizens.id')
            ->where('distribution_citizens.distribution_id', $distributionId);

        // Apply filters similar to those in the applyFilters method
        if (isset($filters['distribution_ids']) && !empty($filters['distribution_ids'])) {
            $query->whereIn('distribution_citizens.distribution_id', $filters['distribution_ids']);
        }

        if (isset($filters['family_range']) && !empty($filters['family_range'])) {
            $query->where('citizens.family_id', $filters['family_range']['family_id'])
                ->where('citizens.relationship_level', '>=', $filters['family_range']['min_level'])
                ->where('citizens.relationship_level', '<=', $filters['family_range']['max_level']);
        }

        if (isset($filters['region_ids']) && !empty($filters['region_ids'])) {
            $query->whereIn('citizens.region_id', $filters['region_ids']);
        }

        if (isset($filters['original_city']) && !empty($filters['original_city'])) {
            $query->where('citizens.original_city', $filters['original_city']);
        }

        return $query->pluck('citizens.id')->toArray();
    }


    /**
     * Apply filters to the citizen list.
     *
     * @param array $citizenIds
     * @param array $filters
     * @return array
     */
    private function applyFilters(array $citizenIds, array $filters)
    {
        $query = Citizen::whereIn('id', $citizenIds);

        // 1. Check if each citizen is in the given distributions
        if (isset($filters['distribution_ids']) && !empty($filters['distribution_ids'])) {
            $query->whereHas('distributions', function($q) use ($filters) {
                $q->whereIn('distributions.id', $filters['distribution_ids']);
            });
        }

        // 2. Check if their family members are within a given range
        if (isset($filters['family_range']) && !empty($filters['family_range'])) {
            // Implement family range check logic (Assume there's a 'family_id' and 'relationship_level' attribute)
            $query->where('family_id', $filters['family_range']['family_id'])
                ->where('relationship_level', '>=', $filters['family_range']['min_level'])
                ->where('relationship_level', '<=', $filters['family_range']['max_level']);
        }

        // 3. Check if they are in the selected regions
        if (isset($filters['region_ids']) && !empty($filters['region_ids'])) {
            $query->whereIn('region_id', $filters['region_ids']);
        }

        // 4. Check other attributes like original city
        if (isset($filters['original_city']) && !empty($filters['original_city'])) {
            $query->where('original_city', $filters['original_city']);
        }

        return $query->pluck('id')->toArray();
    }
}


// citizenIds = [1, 2, 3, 4, 5];
// $distributionId = 10;
// $filters = [
//     'distribution_ids' => [5, 6],
//     'family_range' => ['family_id' => 1, 'min_level' => 2, 'max_level' => 5],
//     'region_ids' => [2, 3],
//     'original_city' => 'Gaza'
// ];


/**
 * 
 * 
 *Explanation:

* **Method: `removeCitizensFromDistribution`**  
 *  This method takes a `distributionId` and a set of filters as input. It first filters the citizens based on the provided criteria using `applyFiltersForDeletion`, then removes those citizens from the specified distribution.
*
*2. **Method: `applyFiltersForDeletion`**  
   This method generates a list of citizen IDs that match the given filters within the specified distribution. The filtering criteria are similar to the `applyFilters` method used for adding citizens.

*3*. **Deletion Process:**  
   After filtering, the method deletes the matching citizen records from the `distribution_citizens` table.

 */