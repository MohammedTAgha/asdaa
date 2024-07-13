<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    public function index()
    {
        $citizens = Citizen::all();
        return response()->json($citizens);
    }

    public function show($id)
    {
        $citizen = Citizen::find($id);
        return response()->json($citizen);
    }

    public function store(Request $request)
    {
        $citizen = Citizen::create($request->all());
        return response()->json($citizen, 201);
    }

    public function update(Request $request, $id)
    {
        $citizen = Citizen::findOrFail($id);
        $citizen->update($request->all());
        return response()->json($citizen, 200);
    }

    public function delete($id)
    {
        Citizen::findOrFail($id)->delete();
        return response()->json(null, 204);
    }

    public function age()
    {
        return \Carbon\Carbon::parse($this->date_of_birth)->age;
    }
    
    public function children()
    {
        return $this->hasMany(Child::class);
    }

}