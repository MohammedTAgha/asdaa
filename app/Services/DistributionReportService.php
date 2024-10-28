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

    public function getStatistics($distribution): array
    {
        $stats = $this->calculateStats($distribution);

        return [
            ['Distribution Details'],
            ['ID', $distribution->id],
            ['Name', $distribution->name],
            ['Date', $distribution->date],
            ['Category', $distribution->category->name ?? ''],
            ['Arrive Date', $distribution->arrive_date],
            ['Quantity', $distribution->quantity],
            ['Target', $distribution->target],
            ['Source', $distribution->source->name ?? ''],
            ['Done', $distribution->done ? 'Yes' : 'No'],
            ['Target Count', $distribution->target_count],
            ['Expectation', $distribution->expectation],
            ['Min Count', $distribution->min_count],
            ['Max Count', $distribution->max_count],
            ['Note', $distribution->note],
            [],
            ['Statistics'],
            ['Total Citizens', $stats['total_citizens']],
            ['Total Quantity Distributed', $stats['total_quantity']],
            ['Average Quantity per Citizen', $stats['avg_quantity']],
            ['Completed Distributions', $stats['completed_distributions']],
        ];
    }

    public function calculateStats($distribution): array
    {
        $citizens = $distribution->citizens;
        
        return [
            'total_citizens' => $citizens->count(),
            'total_quantity' => $citizens->sum('pivot.quantity'),
            'avg_quantity' => $citizens->avg('pivot.quantity'),
            'completed_distributions' => $citizens->where('pivot.done', 1)->count(),
        ];
    }
}
