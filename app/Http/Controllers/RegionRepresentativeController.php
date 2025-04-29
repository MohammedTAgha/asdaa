<?php

namespace App\Http\Controllers;

use App\Models\RegionRepresentative;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionRepresentativeController extends Controller
{
    public function index()
    {
        $representatives = RegionRepresentative::with(['region', 'managedBigRegion'])->get();
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
            'region_id' => 'required_if:is_big_region_representative,false|exists:regions,id',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'is_big_region_representative' => 'boolean',
        ]);

        // If representative is a big region manager, they can't be assigned to a regular region
        if ($request->is_big_region_representative) {
            $request->merge(['region_id' => null]);
        }

        RegionRepresentative::create($request->all());
        return redirect()->route('representatives.index')->with('success', 'Representative created successfully.');
    }

    public function show($id)
    {
        $representative = RegionRepresentative::with('region')->findOrFail($id);
        $regions = Region::all();
        return view('representatives.show', compact('representative' , 'regions'));
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
            'id' => 'required|numeric',
            'name' => 'required|string|max:255',
            'region_id' => 'required_if:is_big_region_representative,false|exists:regions,id',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'is_big_region_representative' => 'boolean',
        ]);

        $representative = RegionRepresentative::findOrFail($id);

        // If changing to big region representative, clear region assignment
        if ($request->is_big_region_representative) {
            $request->merge(['region_id' => null]);
        }
        
        // If changing from big region to regular, check if managing any big regions
        if (!$request->is_big_region_representative && $representative->is_big_region_representative) {
            if ($representative->managedBigRegion()->exists()) {
                return back()->withErrors(['is_big_region_representative' => 'Cannot change role while managing big regions'])->withInput();
            }
        }

        $representative->update($request->all());
        return redirect()->route('representatives.index')->with('success', 'Representative updated successfully.');
    }

    public function destroy($id)
    {
        $representative = RegionRepresentative::findOrFail($id);
        $representative->delete();

        return redirect()->route('representatives.index')->with('success', 'Representative deleted successfully.');
    }
}