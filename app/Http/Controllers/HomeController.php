<?php

namespace App\Http\Controllers;
use App\Models\Citizen;
use App\Models\Distribution;

use Illuminate\Http\Request;

class HomeController extends Controller{
    
    public function index(){
        $citizens = Citizen::all();
        $distributions = Distribution::with('category')->get();
        return view('home.index',compact('citizens','distributions'));
    }

    public function test(){
        $citizens = Citizen::all();
        $distributions = Distribution::with('category')->get();
        return view('home.test',compact('citizens','distributions'));
    }
}