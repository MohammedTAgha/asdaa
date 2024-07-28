<?php

namespace App\Http\Controllers;

use App\Models\RegionRepresentative;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionRepresentativeController extends Controller
{
    public function index()
    {
        $representatives = RegionRepresentative::with('region')->get();
        return view('representatives.index', compact('representatives'));
    }

    public function create()
    {
        $regions = Region::all();
        return view('representatives.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|digits_between:1,20',
            'name' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        RegionRepresentative::create($request->all());
        return redirect()->route('representatives.index')->with('success', 'Representative created successfully.');
    }

    public function show($id)
    {
        $representative = RegionRepresentative::with('region')->findOrFail($id);
        return view('representatives.show', compact('representative'));
    }

    public function edit($id)
    {
        $representative = RegionRepresentative::findOrFail($id);
        $regions = Region::all();
        return view('representatives.edit', compact('representative', 'regions'));
    }

    public function update(Request $request, $id)
    {
     
        $request->validate([
            'id' => 'required|numeric|digits_between:1,20',
            'name' => 'required|string|max:255',
            'region_id' => 'required|string',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'note' => 'nullable|string',
        ]);
        try {
            $representative = RegionRepresentative::findOrFail($id);
            $representative->update($request->all());
            
        }
        catch (QueryException $e) {
            Log::error("eroor:", [">>>>>" => $e]);
            dd($e);
        }
       

        return redirect()->route('representatives.index')->with('success', 'Representative updated successfully.');
    }

    public function destroy($id)
    {
        $representative = RegionRepresentative::findOrFail($id);
        $representative->delete();

        return redirect()->route('representatives.index')->with('success', 'Representative deleted successfully.');
    }
}