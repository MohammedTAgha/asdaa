<?php
namespace App\Services;

use App\Models\Distribution;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DistributionStatisticsExport;
use Illuminate\Support\Facades\DB;

class DistributionReportService
{
    public function export()
    {
        return Excel::download(new DistributionStatisticsExport(), 'تقرير المشاريع.xlsx');
    }


public function generateStatistics()
    {
        // Query for statistics with regions
        $withRegions = DB::table('distribution_citizens')
            ->join('citizens', 'citizens.id', '=', 'distribution_citizens.citizen_id')
            ->join('regions', 'regions.id', '=', 'citizens.region_id')
            ->join('distributions', 'distributions.id', '=', 'distribution_citizens.distribution_id')
            ->select(
                'regions.name as region_name',
                'distributions.name as project_name',
                DB::raw('count(citizens.id) as total_citizens'),
                DB::raw('count(distribution_citizens.id) as benefited_citizens'),
                DB::raw('ROUND((count(distribution_citizens.id) / count(citizens.id)) * 100, 2) as percentage')
            )
            ->where('distribution_citizens.done', true)
            ->groupBy('regions.name', 'distributions.name')
            ->get();

        // Query for statistics without regions
        $withoutRegions = DB::table('distributions')
            ->leftJoin('distribution_citizens', 'distributions.id', '=', 'distribution_citizens.distribution_id')
            ->select(
                'distributions.name as project_name',
                DB::raw('count(distribution_citizens.citizen_id) as total_citizens'),
                DB::raw('sum(case when distribution_citizens.done = true then 1 else 0 end) as benefited_citizens')
            )
            ->groupBy('distributions.name')
            ->get();

        // Combine the results
        return [
            'withRegions' => $withRegions,
            'withoutRegions' => $withoutRegions,
        ];
    }
}
