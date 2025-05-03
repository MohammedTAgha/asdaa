<?php

namespace App\Http\Controllers;

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
        $bigRegions = $this->statisticsService->getBigRegionsStatistics();

        return view('home.index', compact('statistics', 'recentDistributions', 'bigRegions'));
    }
}