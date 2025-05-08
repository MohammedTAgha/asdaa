<?php

namespace App\Http\Controllers;

use App\Models\BigRegion;
use App\Services\DashboardStatisticsService;

class DashboardController extends Controller
{
    protected $statisticsService;

    public function __construct(DashboardStatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function index()
    {
        $statistics = $this->statisticsService->getOverviewStatistics();
        $recentDistributions = $this->statisticsService->getRecentDistributions();
        // $bigRegions = $this->statisticsService->getBigRegionsStatistics();
        // $bigRegions = BigRegion::with([
        //     'representative',
        //     'regions.representatives',
        //     'regions.citizens.distributions'
        // ])->get()->map(function ($bigRegion) {
        //     return [
        //         'id' => $bigRegion->id,
        //         'name' => $bigRegion->name,
        //         'total_citizens' => $bigRegion->regions->sum(function ($region) {
        //             return $region->citizens->count();
        //         }),
        //         'total_regions' => $bigRegion->regions->count(),
        //         'total_representatives' => $bigRegion->regions->sum(function ($region) {
        //             return $region->representatives->count();
        //         }),
        //         'created_at' => $bigRegion->created_at->format('Y-m-d'),
        //         'updated_at' => $bigRegion->updated_at->format('Y-m-d')
        //     ];
        // });
        $bigRegions  = BigRegion::paginate(10); 
        return view('home.index', compact('statistics', 'recentDistributions', 'bigRegions'));
    }
}