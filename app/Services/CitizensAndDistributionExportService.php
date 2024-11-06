<?php

namespace App\Services;

use App\Models\Citizen;
use App\Models\Distribution;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CitizensAndDistributionExportService implements FromArray, WithHeadings
{
    protected $citizens;

    public function __construct()
    {
        $this->citizens = Citizen::with('distributions')->get();
    }

    // Set up the headings for the Excel file
    public function headings(): array
    {
        $distributionNames = Distribution::pluck('name')->toArray();
        return array_merge(['Citizen Name'], $distributionNames);
    }

    // Format data for each row in the Excel file
    public function array(): array
    {
        $exportData = [];

        foreach ($this->citizens as $citizen) {
            // Add citizen's name as the first column
            $row = [$citizen->firstname]; 

            // Iterate through each distribution
            $distributions = Distribution::all();
            foreach ($distributions as $distribution) {
                // Check if the distribution is done for this citizen
                $isDone = $citizen->distributions->contains(function ($d) use ($distribution) {
                    return $d->id == $distribution->id && $d->pivot->done == 1;
                });

                // Add "1" if done, otherwise "0" (or you could leave it blank)
                $row[] = $isDone ? 1 : 0;
            }

            $exportData[] = $row;
        }

        return $exportData;
    }

    public function export()
    {
        return Excel::download($this, 'المستفيدين_مع_المساعدات.xlsx');
    }
}
