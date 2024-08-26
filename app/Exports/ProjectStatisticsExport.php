<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Services\DistributionReportService;

class ProjectStatisticsExport implements FromView
{
    protected $distributionReportService;

    public function __construct()
    {
        $this->distributionReportService = new DistributionReportService();
    }

    public function view(): View
    {
        $statistics = $this->distributionReportService->generateStatistics();

        return view('exports.project_statistics', [
            'withRegions' => $statistics['withRegions'],
            'withoutRegions' => $statistics['withoutRegions']
        ]);
    }
}
