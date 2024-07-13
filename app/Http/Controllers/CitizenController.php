<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    public function index()
    {
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
        return view('citizens.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            // Add other validation rules as needed
        ]);

        Citizen::create($request->all());
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

