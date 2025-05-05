<?php

namespace App\Http\Controllers;

use App\Models\BigRegion;
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

    public function queries(Request $request)
    {
        $regions = Region::all();
        $citizens = null;

        if ($request->hasAny(['search', 'first_name', 'second_name', 'third_name', 'last_name'])) {
            $filters = array_filter([
                'search' => $request->search,
                'first_name' => $request->first_name,
                'second_name' => $request->second_name,
                'third_name' => $request->third_name,
                'last_name' => $request->last_name
            ]);
            
            $citizens = Citizen::filter($filters)->get();
        }

        return view('home.queries', compact('regions', 'citizens'));
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

    public function actions()
    {
       

        return view('home.actions');
    }
}
