<?php

namespace App\Services;

use App\Models\Citizen;
use App\Models\Distribution;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

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
    protected $distributions;
    protected $selectedDistributions;

    public function __construct($citizens = null, $distributionIds = null)
    {
        // Handle citizens input (can be array of IDs, Collection of models, or null for all)
        if ($citizens instanceof Collection) {
            $this->citizens = $citizens;
        } elseif (is_array($citizens)) {
            $this->citizens = Citizen::with(['distributions', 'region.representatives'])
                ->whereIn('id', $citizens)
                ->get();
        } else {
            $this->citizens = Citizen::with(['distributions', 'region.representatives'])->get();
        }

        // Handle distributions input
        if (is_array($distributionIds)) {
            $this->selectedDistributions = Distribution::whereIn('id', $distributionIds)->get();
        } else {
            $this->selectedDistributions = Distribution::all();
        }
    }

    // Set up the headings for the Excel file
    public function headings(): array
    {
        $basicColumns = ['الهوية', 'الاسم رباعي', 'المندوب'];
        $distributionNames = $this->selectedDistributions->pluck('name')->toArray();
        
        return array_merge($basicColumns, $distributionNames);
    }

    // Format data for each row in the Excel file
    public function array(): array
    {
        $exportData = [];

        foreach ($this->citizens as $citizen) {
            // Basic citizen information
            $row = [
                $citizen->id,
                $citizen->firstname . " " . $citizen->secondname . " " . $citizen->thirdname . " " . $citizen->lastname,
                $citizen->region->representatives->first()->name ?? $citizen->region->name ?? 'لا يوجد مندوب'
            ];

            // Add distribution status
            foreach ($this->selectedDistributions as $distribution) {
                $citizenDistribution = $citizen->distributions->first(function ($d) use ($distribution) {
                    return $d->id == $distribution->id;
                });
                
                if ($citizenDistribution === null) {
                    // Citizen doesn't have this distribution
                    $row[] = '-';
                } else {
                    // Citizen has this distribution, check if it's done
                    $row[] = $citizenDistribution->pivot->done ? '1' : '0';
                }
            }

            $exportData[] = $row;
        }

        return $exportData;
    }

    public static function exportSelected($citizenIds, $distributionIds = null)
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $service = new self($citizenIds, $distributionIds);
        return Excel::download($service, "المستفيدين_مع_المساعدات_{$timestamp}.xlsx");
    }
}
