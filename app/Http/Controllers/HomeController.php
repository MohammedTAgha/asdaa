<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\Distribution;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        //        $citizens = Citizen::all();
        //        $distributions = Distribution::with('category')->get();
        return view('home.index');
    }

    public function queries()
    {
        //        $citizens = Citizen::all();
        //        $distributions = Distribution::with('category')->get();
        return view('home.queries');
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
