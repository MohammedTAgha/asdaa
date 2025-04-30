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
        $bigRegions = BigRegion::with([
            'representative',
            'regions',
            'regions.representatives',
            'regions.citizens'
        ])->get();

        return view('big-regions.index', compact('bigRegions'));
    }

    public function create()
    {
        // Get all big region representatives, including those already assigned
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

        // If representative is already managing another big region, clear that assignment
        BigRegion::where('representative_id', $validated['representative_id'])
            ->update(['representative_id' => null]);

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

    public function show(BigRegion $bigRegion)
    {
        $bigRegion->load('regions.representatives', 'representative');
        return view('big-regions.show', compact('bigRegion'));
    }

    public function edit(BigRegion $bigRegion)
    {
        // Get all big region representatives, including those managing other regions
        $representatives = RegionRepresentative::where('is_big_region_representative', true)->get();
        $regions = Region::where(function($query) use ($bigRegion) {
            $query->doesntHave('bigRegion')
                  ->orWhere('big_region_id', $bigRegion->id);
        })->get();
        
        $bigRegion->load('regions', 'representative');
        return view('big-regions.edit', compact('bigRegion', 'representatives', 'regions'));
    }

    public function update(Request $request, $id)
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

        // If assigning a different representative
        if ($validated['representative_id'] !== $bigRegion->representative_id) {
            // Clear any other assignments for this representative
            BigRegion::where('representative_id', $validated['representative_id'])
                ->where('id', '!=', $id)
                ->update(['representative_id' => null]);
        }

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

    public function destroy($id)
    {
        $bigRegion = BigRegion::findOrFail($id);
        
        // Clear region associations
        Region::where('big_region_id', $bigRegion->id)
              ->update(['big_region_id' => null]);
              
        $bigRegion->delete();
        return redirect()->route('big-regions.index')
            ->with('success', 'Big Region deleted successfully!');
    }
}
