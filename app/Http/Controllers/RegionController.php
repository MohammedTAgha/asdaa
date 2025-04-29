<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\BigRegion;
use App\Models\RegionRepresentative;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $query = Region::with(['bigRegion.representative', 'representatives']);
        
        if (auth()->user() && auth()->user()->role_id == 3) { // region manager role
            $regionIds = auth()->user()->regions->pluck('id')->toArray();
            $regions = $query->whereIn('id', $regionIds)->get();
        } else {
            $regions = $query->get();
        }
        
        return view('regions.index', compact('regions'));
    }

    public function create()
    {
        $bigRegions = BigRegion::with(['representative' => function($query) {
            $query->where('is_big_region_representative', true);
        }])->get();
        $representatives = RegionRepresentative::where('is_big_region_representative', false)
            ->doesntHave('region')
            ->get();
        return view('regions.create', compact('bigRegions', 'representatives'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'note' => 'nullable|string',
            'big_region_id' => 'nullable|exists:big_regions,id',
            'representative_ids' => 'nullable|array',
            'representative_ids.*' => 'exists:region_representatives,id'
        ]);

        $region = Region::create($request->all());

        if ($request->has('representative_ids')) {
            foreach ($request->representative_ids as $repId) {
                RegionRepresentative::where('id', $repId)
                    ->where('is_big_region_representative', false)
                    ->update(['region_id' => $region->id]);
            }
        }

        return redirect()->route('regions.index')->with('success', 'Region created successfully.');
    }

    public function show($id)
    {
        $region = Region::with([
            'bigRegion.representative',
            'representatives' => function($query) {
                $query->where('is_big_region_representative', false);
            }
        ])->findOrFail($id);
        
        return view('regions.show', compact('region'));
    }

    public function edit($id)
    {
        $region = Region::with([
            'bigRegion.representative',
            'representatives' => function($query) {
                $query->where('is_big_region_representative', false);
            }
        ])->findOrFail($id);
        
        $bigRegions = BigRegion::with(['representative' => function($query) {
            $query->where('is_big_region_representative', true);
        }])->get();
        
        $representatives = RegionRepresentative::where('is_big_region_representative', false)
            ->where(function($query) use ($region) {
                $query->doesntHave('region')
                    ->orWhere('region_id', $region->id);
            })
            ->get();

        return view('regions.edit', compact('region', 'bigRegions', 'representatives'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'note' => 'nullable|string',
            'big_region_id' => 'nullable|exists:big_regions,id',
            'representative_ids' => 'nullable|array',
            'representative_ids.*' => 'exists:region_representatives,id'
        ]);

        $region = Region::findOrFail($id);
        
        // First clear existing non-big-region representatives
        RegionRepresentative::where('region_id', $region->id)
            ->where('is_big_region_representative', false)
            ->update(['region_id' => null]);
            
        // Then update the region details
        $region->update($request->all());

        // Finally assign the selected representatives
        if ($request->has('representative_ids')) {
            RegionRepresentative::whereIn('id', $request->representative_ids)
                ->where('is_big_region_representative', false)
                ->update(['region_id' => $region->id]);
        }

        return redirect()->route('regions.index')->with('success', 'Region updated successfully.');
    }

    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        
        if ($region->citizens()->count() > 0) {
            return redirect()->route('regions.index')
                ->with('error', 'Cannot delete region that has citizens.');
        }
        
        // Clear representative assignments before deletion
        RegionRepresentative::where('region_id', $region->id)
            ->where('is_big_region_representative', false)
            ->update(['region_id' => null]);
            
        $region->delete();
        return redirect()->route('regions.index')
            ->with('success', 'Region deleted successfully.');
    }
}
