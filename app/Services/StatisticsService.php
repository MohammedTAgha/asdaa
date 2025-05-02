<?php

namespace App\Services;
use Carbon\Carbon;
use App\Models\Citizen;
use App\Models\Distribution;
use App\Models\Region;

class StatisticsService
{
    /**
     * Get the total number of citizens and the number added last month.
     */
    public function getCitizenStatistics()
    {
        $totalCitizens = Citizen::count();
        $person_count = Citizen::sum('family_members');
        $males = Citizen::sum('mails_count');
        $females = Citizen::sum('femails_count');
        $lesthan3 = Citizen::sum('leesthan3');
        $obstruction = Citizen::sum('obstruction');
        $disease = Citizen::sum('disease');

        $lastMonthCitizens = Citizen::where('created_at', '>=', Carbon::now()->subMonth())->count();

        return [
            'total_citizens' => $totalCitizens,
            'new_citizens_last_month' => $lastMonthCitizens,
            'males' => $males,
            'females' => $females,
            'lesthan3' => $lesthan3,
            'obstruction' => $obstruction,
            'disease' => $disease,
            
        ];
    }

    /**
     * Get the total number of distributions and total aids distributed.
     */
    public function getDistributionStatistics()
    {
        $totalDistributions = Distribution::count();
        //$totalAidsDistributed = Distribution::sum('pakages_count'); // Assuming aid_amount column exists

        return [
            'total_distributions' => $totalDistributions,
            // 'total_aids_distributed' => $totalAidsDistributed,

        ];
    }

    /**
     * Get the count of benefited citizens and the average number of distributions per person.
     */
    public function getBenefitedCitizensStatistics()
    {
        $benefitedCitizens = Citizen::whereHas('distributions', function ($query) {
            $query->where('distribution_citizens.done', 1); // Specify the table name
        })->count();

        $totalDistributedByPerson = Citizen::withCount(['distributions' => function ($query) {
            $query->where('distribution_citizens.done', 1); // Specify the table name
        }])
            ->whereHas('distributions', function ($query) {
                $query->where('distribution_citizens.done', 1); // Specify the table name
            })
            ->get()
            ->avg('distributions_count');

        return [
            'benefited_citizens_count' => $benefitedCitizens,
            'average_distributions_per_person' => round($totalDistributedByPerson, 2),
        ];
    }

    /**
     * Get the number of regions that have benefited and the count of citizens per region.
     */
    public function getRegionalStatistics()
    {
        $benefitedRegions = Region::whereHas('citizens.distributions', function ($query) {
            $query->where('distribution_citizens.done', 1); // Specify the table name
        })->count();

        $citizensByRegion = Region::withCount(['citizens' => function ($query) {
            $query->whereHas('distributions', function ($query) {
                $query->where('distribution_citizens.done', 1); // Specify the table name
            });
        }])->get()->mapWithKeys(function ($region) {
            return [$region->name => $region->citizens_count];
        });

        return [
            'benefited_regions_count' => $benefitedRegions,
            'citizens_count_by_region' => $citizensByRegion,
        ];
    }

    /**
     * Additional useful statistics.
     */
    public function getAdditionalStatistics()
    {
        $citizensWithMultipleDistributions = Citizen::has('distributions', '>', 1)->count();
        $highestAidDistribution = Distribution::withCount('citizens')
            ->orderBy('citizens_count', 'desc')
            ->first();

        return [
            'citizens_with_multiple_distributions' => $citizensWithMultipleDistributions,
            'distribution_with_most_citizens' => $highestAidDistribution,
        ];
    }

    /**
     * Method to return all statistics in one response.
     */
    public function getAllStatistics()
    {
        return [
            'citizen_statistics' => $this->getCitizenStatistics(),
            'distribution_statistics' => $this->getDistributionStatistics(),
            'benefited_citizens_statistics' => $this->getBenefitedCitizensStatistics(),
            'regional_statistics' => $this->getRegionalStatistics(),
            'additional_statistics' => $this->getAdditionalStatistics(),
        ];
    }
}

