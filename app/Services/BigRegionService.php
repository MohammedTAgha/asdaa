<?php

namespace App\Services;

use App\Models\BigRegion;
use App\Models\Distribution;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BigRegionService
{
    public function getBigRegionStatistics($bigRegionId = null)
    {
        $query = BigRegion::with([
            'representative',
            'regions.representatives',
            'regions.citizens.distributions',
            'citizens'
        ]);
        
        if ($bigRegionId) {
            $query->where('id', $bigRegionId);
        }

        $bigRegions = $query->get();
        
        return $bigRegions->map(function ($bigRegion) {
            return [
                'id' => $bigRegion->id,
                'name' => $bigRegion->name,
                'total_citizens' => $this->calculateTotalCitizens($bigRegion),
                'total_regions' => $bigRegion->regions->count(),
                'total_representatives' => $this->calculateTotalRepresentatives($bigRegion),
                'total_family_members' => $this->calculateTotalFamilyMembers($bigRegion),
                'coverage_stats' => $this->calculateCoverageStats($bigRegion),
                'distributions_stats' => $this->calculateDistributionsStats($bigRegion),
                'regions_summary' => $this->getRegionsSummary($bigRegion),
                'representative_info' => $this->getRepresentativeInfo($bigRegion),
                'created_at' => $bigRegion->created_at->format('Y-m-d'),
                'updated_at' => $bigRegion->updated_at->format('Y-m-d')
            ];
        });
    }

    private function calculateTotalCitizens($bigRegion): int
    {
        return $bigRegion->regions->sum(function ($region) {
            return $region->citizens->count();
        });
    }

    private function calculateTotalRepresentatives($bigRegion): int
    {
        return $bigRegion->regions->sum(function ($region) {
            return $region->representatives->count();
        });
    }

    private function calculateTotalFamilyMembers($bigRegion): int
    {
        return $bigRegion->regions->sum(function ($region) {
            return $region->citizens->sum('family_members');
        });
    }

    private function calculateCoverageStats($bigRegion): array
    {
        $totalRegions = $bigRegion->regions->count();
        $regionsWithReps = $bigRegion->regions->filter(function ($region) {
            return $region->representatives->count() > 0;
        })->count();

        $percentage = $totalRegions > 0 ? ($regionsWithReps / $totalRegions) * 100 : 0;

        return [
            'total_regions' => $totalRegions,
            'regions_with_representatives' => $regionsWithReps,
            'coverage_percentage' => round($percentage, 1)
        ];
    }

    private function calculateDistributionsStats($bigRegion): array
    {
        // Get all distributions for this big region with their beneficiary counts
        $distributions = Distribution::whereHas('citizens', function($query) use ($bigRegion) {
            $query->whereHas('region', function($query) use ($bigRegion) {
                $query->where('big_region_id', $bigRegion->id);
            });
        })->withCount(['citizens as beneficiaries_count' => function($query) use ($bigRegion) {
            $query->whereHas('region', function($query) use ($bigRegion) {
                $query->where('big_region_id', $bigRegion->id);
            });
        }])->get();

        $totalCitizens = $this->calculateTotalCitizens($bigRegion);

        return [
            'total_distributions' => $distributions->count(),
            'distributions' => $distributions->map(function ($distribution) use ($totalCitizens) {
                return [
                    'id' => $distribution->id,
                    'name' => $distribution->name,
                    'beneficiaries_count' => $distribution->beneficiaries_count,
                    'percentage' => $totalCitizens > 0 
                        ? round(($distribution->beneficiaries_count / $totalCitizens) * 100, 1) 
                        : 0,
                    'status' => $distribution->status
                ];
            })
        ];
    }

    private function getRegionsSummary($bigRegion): Collection
    {
        return $bigRegion->regions->map(function ($region) {
            return [
                'id' => $region->id,
                'name' => $region->name,
                'citizens_count' => $region->citizens->count(),
                'representatives_count' => $region->representatives->count(),
                'total_family_members' => $region->citizens->sum('family_members'),
                'representatives' => $region->representatives->map(function ($rep) {
                    return [
                        'id' => $rep->id,
                        'name' => $rep->name
                    ];
                })
            ];
        });
    }

    private function getRepresentativeInfo($bigRegion): ?array
    {
        if (!$bigRegion->representative) {
            return null;
        }

        return [
            'id' => $bigRegion->representative->id,
            'name' => $bigRegion->representative->name,
            'phone' => $bigRegion->representative->phone,
            'address' => $bigRegion->representative->address
        ];
    }
}