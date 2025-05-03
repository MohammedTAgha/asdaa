<?php

namespace App\Services;

use App\Models\Citizen;
use App\Models\Distribution;
use App\Models\Region;
use App\Models\BigRegion;
use Illuminate\Support\Facades\DB;

class DashboardStatisticsService
{
    public function getOverviewStatistics()
    {
        return [
            'total_citizens' => Citizen::count(),
            'total_distributions' => Distribution::count(),
            'total_regions' => Region::count(),
            'total_distributed_aid' => DB::table('distribution_citizens')
                ->where('done', 1)
                ->count(),
        ];
    }

    public function getRecentDistributions($limit = 6)
    {
        return Distribution::with(['category', 'source'])
            ->orderBy('date', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($distribution) {
                $completedCount = $distribution->citizens()
                    ->wherePivot('done', 1)
                    ->count();
                $totalCount = $distribution->citizens()->count();
                
                return [
                    'id' => $distribution->id,
                    'name' => $distribution->name,
                    'category' => $distribution->category->name ?? 'N/A',
                    'date' => $distribution->date,
                    'progress' => $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0,
                    'source' => $distribution->source->name ?? 'N/A',
                    'status' => $distribution->done ? 'مكتمل' : 'جاري',
                ];
            });
    }

    public function getBigRegionsStatistics()
    {
        return BigRegion::with(['regions.citizens'])
            ->get()
            ->map(function ($bigRegion) {
                $totalCitizens = $bigRegion->regions->sum(function ($region) {
                    return $region->citizens->count();
                });
                
                return [
                    'id' => $bigRegion->id,
                    'name' => $bigRegion->name,
                    'regions_count' => $bigRegion->regions->count(),
                    'citizens_count' => $totalCitizens,
                ];
            });
    }
}