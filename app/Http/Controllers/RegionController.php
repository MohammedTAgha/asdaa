<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\BigRegion;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $query = Region::with(['bigRegion', 'representatives']);
        
        if (auth()->user() && auth()->user()->role_id == 3) {
            $regionIds = auth()->user()->regions->pluck('id')->toArray();
            $regions = $query->whereIn('id', $regionIds)->get();
        } else {
            $regions = $query->get();
        }
        
        return view('regions.index', compact('regions'));
    }

    public function create()
    {
        $bigRegions = BigRegion::with('representative')->get();
        return view("regions.create", compact('bigRegions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'note' => 'nullable|string',
            'big_region_id' => 'nullable|exists:big_regions,id'
        ]);

        Region::create($request->all());
        return redirect()->route('regions.index')->with('success', 'Region created successfully.');
    }

    public function show($id)
    {
        $regions = Region::all();
        $region = Region::findOrFail($id);
        return view('regions.show', compact('region', 'regions'));
    }

    public function edit($id)
    {
        $region = Region::findOrFail($id);
        $bigRegions = BigRegion::with('representative')->get();
        return view('regions.edit', compact('region', 'bigRegions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'note' => 'nullable|string',
            'big_region_id' => 'nullable|exists:big_regions,id'
        ]);

        $region = Region::findOrFail($id);
        
        // Check if the big region is being changed
        if ($region->big_region_id != $request->big_region_id) {
            // Additional logic here if needed when changing big region
        }
        
        $region->update($request->all());

        return redirect()->route('regions.index')->with('success', 'Region updated successfully.');
    }

    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        
        // Check if region has citizens before deleting
        if ($region->citizens()->count() > 0) {
            return redirect()->route('regions.index')
                ->with('error', 'Cannot delete region that has citizens.');
        }
        
        $region->delete();
        return redirect()->route('regions.index')
            ->with('success', 'Region deleted successfully.');
    }
}
