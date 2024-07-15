<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\Region;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sort', 'name'); // Default sort field
        $sortDirection = $request->get('direction', 'asc'); // Default sort direction
        $perPage = $request->get('per_page', 10); // Default entries per page
        $citizens = Citizen::orderBy($sortField, $sortDirection)
        ->paginate($perPage)
        ->appends($request->all());

    return view('citizens.index', compact('citizens', 'sortField', 'sortDirection', 'perPage'));
        $citizens = Citizen::all();
        return view('citizens.index', compact('citizens'));
    }

    public function show($id)
    {
        $citizen = Citizen::with('children')->findOrFail($id);
        return view('citizens.show', compact('citizen'));
    }

    public function create()
    {
        $regions = Region::all();
        return view('citizens.create',compact('regions'));
    }

    public function store(Request $request)
    {
   
       
        $data = [
            'id' => $request->input('id'),
            'name' => $request->input('name'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'region_id' => $request->input('region_id'),
            'wife_id' => $request->input('wife_id'),
            'wife_name' => $request->input('wife_name'),
            'widowed' => $request->input('widowed'),
            'social_status' => $request->input('social_status'),
            'living_status' => $request->input('living_status'),
            'job' => $request->input('job'),
            'original_address' => $request->input('original_address'),
            'elderly_count' => $request->input('elderly_count'),
            'note' => $request->input('note'),

        ];
        
        Citizen::create($data);

       
   
       return redirect()->route('citizens.index')->with('success', 'Citizen created successfully.');
    }

    public function edit($id)
    {
        $citizen = Citizen::findOrFail($id);
        return view('citizens.edit', compact('citizen'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            // Add other validation rules as needed
        ]);

        $citizen = Citizen::findOrFail($id);
        $citizen->update($request->all());
        return redirect()->route('citizens.index')->with('success', 'Citizen updated successfully.');
    }

    public function destroy($id)
    {
        $citizen = Citizen::findOrFail($id);
        $citizen->delete();
        return redirect()->route('citizens.index')->with('success', 'Citizen deleted successfully.');
    }
}

