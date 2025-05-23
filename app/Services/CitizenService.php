<?php

namespace App\Services;

use App\Models\Citizen;
use App\Models\Distribution;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CitizenService
{
    public function removeCitizens(array $citizenIds)
    {

        
       if (empty($citizenIds)){
        Log::alert('no citizens found');
        return false;
       }
       try{
        Citizen::whereIn('id', $citizenIds)->update(['is_archived' => 1]);
        Citizen::whereIn('id', $citizenIds)->delete();
        Log::info('deleted');
        return true;
       }catch(Exception $e){
        Log::error('faild to remove: '.$e->getMessage());
        return false;
       }
       
    }

      /**
     * Change region for selected citizens.
     *
     * @param array $citizenIds
     * @param int $regionId
     * @return bool
     */
    public function changeRegion(array $citizenIds, int $regionId): bool
    {
        try {
            DB::transaction(function  () use ($citizenIds, $regionId) {
                // Update region for the selected citizens.
                Citizen::whereIn('id', $citizenIds)->update(['region_id' => $regionId]);
            });

            return true;
        } catch (Exception $e) {
            Log::error('Failed to change citizen region: ' . $e->getMessage());
            return false;
        }
    }

    public function restore($ids): int
    {
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        try {
            $restored=Citizen::withTrashed()
            ->whereIn('id', $ids)
            ->restore();
            Citizen::withTrashed()->whereIn('id', $ids)->update(['is_archived' => 0]);
            
            return $restored;
        } catch (Exception $e) {
            Log::error('erorr restoring ids');
            Log::error($ids);
            return false;
        }
    }
     /**
     * Get citizen information by their IDs.
     *
     * @param array $citizenIds
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCitizensByIds(array $citizenIds)
    {
        return Citizen::whereIn('id', $citizenIds)->get();
    }

    /**
     * Add multiple citizens to a category
     *
     * @param array $citizenIds
     * @param int $categoryId
     * @return bool
     */
    public function addCitizensToCategory(array $citizenIds, int $categoryId): bool
    {
        if (empty($citizenIds)) {
            Log::alert('No citizens provided');
            return false;
        }

        try {
            DB::transaction(function () use ($citizenIds, $categoryId) {
                $citizens = Citizen::whereIn('id', $citizenIds)->get();
                
                foreach ($citizens as $citizen) {
                    // Get all family members of the citizen
                    $familyMemberIds = $citizen->familyMembers()->pluck('id')->toArray();
                    
                    if (!empty($familyMemberIds)) {
                        // Attach the category to all family members
                        DB::table('category_family_member')
                            ->insert(array_map(function($familyMemberId) use ($categoryId) {
                                return [
                                    'category_id' => $categoryId,
                                    'family_member_id' => $familyMemberId,
                                    'created_at' => now(),
                                    'updated_at' => now()
                                ];
                            }, $familyMemberIds));
                    }
                }
            });

            return true;
        } catch (Exception $e) {
            Log::error('Failed to add citizens to category: ' . $e->getMessage());
            return false;
        }
    }
}
