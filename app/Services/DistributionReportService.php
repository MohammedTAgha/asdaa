<?php
namespace App\Services;

use App\Models\Distribution;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DistributionStatisticsExport;

class DistributionReportService
{
    public function export()
    {
        return Excel::download(new DistributionStatisticsExport(), 'تقرير المشاريع.xlsx');
}
}
