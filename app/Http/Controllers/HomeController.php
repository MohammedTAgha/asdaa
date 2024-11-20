<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\Distribution;
use App\Models\Region;
use App\Services\StatisticsService;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }


    public function index()
    {
        //        $citizens = Citizen::all();
        //        $distributions = Distribution::with('category')->get();
        $stats = $this->statisticsService->getCitizenStatistics();
        $dist = $this->statisticsService->getDistributionStatistics();
        $benefited = $this->statisticsService->getBenefitedCitizensStatistics();
    //     dd(['stats' => $stats, 
    //     'dist' => $dist,
    //     'benefited' => $benefited
    // ]
    // );
        return view('home.index');
    }

    public function queries()
    {
               $regions = Region::all();
        //        $citizens = Citizen::all();
        //        $distributions = Distribution::with('category')->get();
        return view('home.queries',compact('regions'));
    }

    public function test()
    {
        $query = Citizen::with('region');
        $citizens = $query->get();
        $distributions = Distribution::with('category')->first()->get();
        $data = [];
        $data['ctz'] = $citizens;

        return view('home.test', compact('citizens', 'distributions', 'data'));
    }
}
