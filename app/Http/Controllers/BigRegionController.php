<?php


namespace App\Http\Controllers;

use App\Models\BigRegion;
use App\Models\Region;
use App\Models\RegionRepresentative;
use Illuminate\Http\Request;

class BigRegionController extends Controller
{
    public function index()
    {
        $bigRegions = BigRegion::with('regions', 'representative')->get();
        return view('big-regions.index', compact('bigRegions'));
    }

    public function create()
    {
        $representatives = RegionRepresentative::where('is_big_region_representative', true)->get();
        $regions = Region::doesntHave('bigRegion')->get();
        return view('big-regions.create', compact('representatives', 'regions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'representative_id' => 'required|exists:region_representatives,id',
            'regions' => 'nullable|array',
            'regions.*' => 'exists:regions,id',
        ]);

        // Verify representative is a big region representative
        $representative = RegionRepresentative::findOrFail($validated['representative_id']);
        if (!$representative->is_big_region_representative) {
            return back()->withErrors(['representative_id' => 'Selected representative must be a big region representative'])->withInput();
        }

        $bigRegion = BigRegion::create([
            'name' => $validated['name'],
            'note' => $request->note,
            'representative_id' => $validated['representative_id'],
        ]);

        if (!empty($validated['regions'])) {
            Region::whereIn('id', $validated['regions'])->update(['big_region_id' => $bigRegion->id]);
        }

        return redirect()->route('big-regions.index')->with('success', 'Big Region created successfully!');
    }

    public function show(BigRegion $bigRegion, $id)
    {
        $bigRegion->load('regions.representatives', 'representative');
        return view('big-regions.show', compact('bigRegion'));
    }

    public function edit(BigRegion $bigRegion)
    {
        $representatives = RegionRepresentative::where('is_big_region_representative', true)->get();
        $regions = Region::where(function($query) use ($bigRegion) {
            $query->doesntHave('bigRegion')
                  ->orWhere('big_region_id', $bigRegion->id);
        })->get();
        
        $bigRegion->load('regions', 'representative');
        return view('big-regions.edit', compact('bigRegion', 'representatives', 'regions'));
    }

    public function update(Request $request ,$id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'representative_id' => 'required|exists:region_representatives,id',
            'regions' => 'nullable|array',
            'regions.*' => 'exists:regions,id',
        ]);

        // Verify representative is a big region representative
        $representative = RegionRepresentative::findOrFail($validated['representative_id']);
        if (!$representative->is_big_region_representative) {
            return back()->withErrors(['representative_id' => 'Selected representative must be a big region representative'])->withInput();
        }

        $bigRegion = BigRegion::findOrFail($id);
        $bigRegion->update([
            'name' => $validated['name'],
            'note' => $request->note,
            'representative_id' => $validated['representative_id'],
        ]);

        // Update associated regions
        if (!empty($validated['regions'])) {
            // First, remove this big region from all its current regions
            Region::where('big_region_id', $bigRegion->id)
                  ->update(['big_region_id' => null]);
            
            // Then assign the new regions
            Region::whereIn('id', $validated['regions'])
                  ->update(['big_region_id' => $bigRegion->id]);
        }

        return redirect()->route('big-regions.index')->with('success', 'Big Region updated successfully!');
    }
}
