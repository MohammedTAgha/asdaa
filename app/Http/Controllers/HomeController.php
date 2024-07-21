<?php

namespace App\Http\Controllers;
use App\Models\Citizen;

use Illuminate\Http\Request;

class HomeController extends Controller{
    
    public function index(){
        $citizens = Citizen::all();
        return view('home.index',compact('citizens'));
    }
}