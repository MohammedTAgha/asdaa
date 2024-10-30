<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\Distribution;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

// this is for exporting single project
class DistributionExport implements WithMultipleSheets
{
    protected $distribution;

    public function __construct(Distribution $distribution)
    {
        $this->distribution = $distribution;
    }

    public function sheets(): array
    {
        return [
            new DistributionCitizensSheet($this->distribution),
            new DistributionDetailsSheet($this->distribution),
        ];
    }
}