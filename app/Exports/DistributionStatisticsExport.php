<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DistributionStatisticsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return $this->generateStatistics();
    }

    public function headings(): array
    {
        return [
            'Region Name',
            'Project Name',
            'Total Citizens',
            'Benefited Citizens',
            'Percentage',
        ];
    }

    private function generateStatistics()
    {
        return DB::table('distributions')
            ->leftJoin('distribution_citizens', 'distributions.id', '=', 'distribution_citizens.distribution_id')
            ->leftJoin('citizens', 'citizens.id', '=', 'distribution_citizens.citizen_id')
            ->leftJoin('regions', 'regions.id', '=', 'citizens.region_id')
            ->select(
                'regions.name as region_name',
                'distributions.name as project_name',
                DB::raw('COUNT(DISTINCT citizens.id) as total_citizens'), // Count all citizens in the distribution
                DB::raw('SUM(CASE WHEN distribution_citizens.done = true THEN 1 ELSE 0 END) as benefited_citizens'), // Count citizens with done=true
                DB::raw('ROUND((SUM(CASE WHEN distribution_citizens.done = true THEN 1 ELSE 0 END) / COUNT(DISTINCT citizens.id)) * 100, 2) as percentage')
            )
            ->groupBy('regions.name', 'distributions.name')
            ->get();
    }

    private function getprojectsData()
{
    return DB::table('distributions')
        ->leftJoin('distribution_citizens', 'distributions.id', '=', 'distribution_citizens.distribution_id')
        ->select(
            'distributions.name as project_name',
            DB::raw('count(distribution_citizens.citizen_id) as total_citizens'),
            DB::raw('sum(case when distribution_citizens.done = true then 1 else 0 end) as benefited_citizens')
        )
        ->groupBy('distributions.name')
        ->get();
}
}
