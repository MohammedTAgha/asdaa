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
}
