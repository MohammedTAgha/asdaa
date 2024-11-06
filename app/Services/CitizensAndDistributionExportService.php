<?php

namespace App\Services;

use App\Models\Citizen;
use App\Models\Distribution;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

   /**
     * this donoad excel file of all citizens along thair aids 
     *
     * @param array $citizenIds
     * @param int $regionId
     * @return array
     */
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
        return array_merge(['الهوية','الاسم رباعي','المندوب'], $distributionNames);
    }

    // Format data for each row in the Excel file
    public function array(): array
    {
        $exportData = [];

        foreach ($this->citizens as $citizen) {
            // Add citizen's name as the first column
            $id = $citizen->id;
            $name = $citizen->firstname." ".$citizen->secondname." ".$citizen->thirdname." ".$citizen->lastname;
            $region =  $citizen->region->representatives->first()->name ??  $citizen->region->name ?? 'no region';
            $row = [$id ,$name , $region]; 

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
