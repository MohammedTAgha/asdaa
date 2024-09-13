<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class DistributionDetailsSheet implements FromArray, WithTitle
{
    protected $distribution;

    public function __construct($distribution)
    {
        $this->distribution = $distribution;
    }

    public function array(): array
    {
        $stats = $this->calculateStats();

        return [
            ['Distribution Details'],
            ['ID', $this->distribution->id],
            ['Name', $this->distribution->name],
            ['Date', $this->distribution->date],
            ['Category', $this->distribution->category->name ?? ''],
            ['Arrive Date', $this->distribution->arrive_date],
            ['Quantity', $this->distribution->quantity],
            ['Target', $this->distribution->target],
            ['Source', $this->distribution->source->name ?? ''],
            ['Done', $this->distribution->done ? 'Yes' : 'No'],
            ['Target Count', $this->distribution->target_count],
            ['Expectation', $this->distribution->expectation],
            ['Min Count', $this->distribution->min_count],
            ['Max Count', $this->distribution->max_count],
            ['Note', $this->distribution->note],
            [],
            ['Statistics'],
            ['Total Citizens', $stats['total_citizens']],
            ['Total Quantity Distributed', $stats['total_quantity']],
            ['Average Quantity per Citizen', $stats['avg_quantity']],
            ['Completed Distributions', $stats['completed_distributions']],
        ];
    }

    private function calculateStats(): array
    {
        $citizens = $this->distribution->citizens;
        
        return [
            'total_citizens' => $citizens->count(),
            'total_quantity' => $citizens->sum('pivot.quantity'),
            'avg_quantity' => $citizens->avg('pivot.quantity'),
            'completed_distributions' => $citizens->where('pivot.done', 1)->count(),
        ];
    }

    public function title(): string
    {
        return 'Distribution Details';
    }
}