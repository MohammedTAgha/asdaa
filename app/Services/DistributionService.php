<?php
namespace App\Services;

use App\Models\Citizen;
use Illuminate\Support\Facades\DB;

class DistributionService
{
    public function addCitizensToDistribution(array $citizenIds, $distributionId)
    {
        $totalIds = count($citizenIds);
        DB::beginTransaction();
        try {
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
}
