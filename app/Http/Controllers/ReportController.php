<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ProjectStatisticsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\DistributionReportService;
class ReportController extends Controller
{

    protected $distributionReportService;

    public function __construct(DistributionReportService $distributionReportService)
    {
        $this->distributionReportService = $distributionReportService;
    }

    public function export()
    {
        return $this->distributionReportService->export();
    }

    public function showStatistics()
    {
        $statistics = $this->distributionReportService->generateStatistics();

        return view('reports.project_statistics', [
            'withRegions' => $statistics['withRegions'],
            'withoutRegions' => $statistics['withoutRegions']
        ]);
    }
    // // Method for generating and displaying the general distribution statistics
    // public function distributionStatistics()
    // {
    //     $data = $this->generateStatistics();
    //     return view('reports.distribution-statistics', compact('data'));
    // }

    // // Method for generating and exporting the distribution report
    // public function exportDistributionReport()
    // {
    //     return Excel::download(new ProjectStatisticsExport, 'تقرير المشاريع.xlsx');
    // }

    // // Add other report methods as needed
    // private function generateStatistics()
    // {
    //     // Logic to generate statistics (similar to what you provided earlier)
    // }
}
