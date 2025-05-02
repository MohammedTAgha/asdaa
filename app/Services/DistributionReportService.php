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
                DB::raw('count(DISTINCT citizens.id) as total_citizens'),
                DB::raw('count(DISTINCT CASE WHEN distribution_citizens.done = true THEN citizens.id END) as benefited_citizens'),
                DB::raw('ROUND((count(DISTINCT CASE WHEN distribution_citizens.done = true THEN citizens.id END) / count(DISTINCT citizens.id)) * 100, 2) as percentage')
            )
            ->groupBy('regions.name', 'distributions.name')
            ->get();

        // Query for statistics without regions
        $withoutRegions = DB::table('distributions')
            ->leftJoin('distribution_citizens', 'distributions.id', '=', 'distribution_citizens.distribution_id')
            ->select(
                'distributions.name as project_name',
                DB::raw('count(DISTINCT distribution_citizens.citizen_id) as total_citizens'),
                DB::raw('count(DISTINCT CASE WHEN distribution_citizens.done = true THEN distribution_citizens.citizen_id END) as benefited_citizens')
            )
            ->groupBy('distributions.name')
            ->get();

        return [
            'withRegions' => $withRegions,
            'withoutRegions' => $withoutRegions,
        ];
    }

    //get statistics ass array and show its for excel file
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

    // this method takes a distribution and retern its statistics
    public function calculateStats($distribution): array
    {
        $citizens = $distribution->citizens()
            ->select([
                'citizens.*',
                'distribution_citizens.done as pivot_done',
                'distribution_citizens.quantity as pivot_quantity'
            ])
            ->get();

        $citizens_count = $citizens->count();
        $benafated_count = $citizens->where('pivot_done', 1)->count();
        
        $percentage = $citizens_count > 0 
            ? ($benafated_count / $citizens_count) * 100 
            : 0;

        return [
            'benafated' => $benafated_count,
            'citizens_count' => $citizens_count,
            'total_citizens' => $citizens_count,
            'benefated_percentage' => $percentage,
            'total_quantity' => $citizens->sum('pivot_quantity'),
            'avg_quantity' => $citizens->avg('pivot_quantity') ?? 0,
            'completed_distributions' => $benafated_count,
        ];
    }
}
