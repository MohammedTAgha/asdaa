<?php

namespace App\Http\Controllers;

use App\Models\BigRegion;
use App\Models\Region;
use App\Models\RegionRepresentative;
use App\Services\BigRegionService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BigRegionController extends Controller
{
    protected $bigRegionService;

    public function __construct(BigRegionService $bigRegionService)
    {
        $this->bigRegionService = $bigRegionService;
    }

    public function index(Request $request)
    {
        $query = BigRegion::with([
            'representative',
            'regions.representatives',
            'regions.citizens.distributions'
        ]);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('representative', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $bigRegions = $query->paginate(9)->withQueryString();
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
            'note' => 'nullable|string'
        ]);

        // Verify representative is a big region representative
        $representative = RegionRepresentative::findOrFail($validated['representative_id']);
        if (!$representative->is_big_region_representative) {
            return back()->withErrors(['representative_id' => 'Selected representative must be a big region representative.']);
        }

        // Clear previous big region assignment if exists
        BigRegion::where('representative_id', $validated['representative_id'])
            ->update(['representative_id' => null]);

        $bigRegion = BigRegion::create([
            'name' => $validated['name'],
            'representative_id' => $validated['representative_id'],
            'note' => $validated['note'] ?? null
        ]);

        if (!empty($validated['regions'])) {
            Region::whereIn('id', $validated['regions'])
                ->update(['big_region_id' => $bigRegion->id]);
        }

        return redirect()->route('big-regions.index')
            ->with('success', 'تم إنشاء المنطقة الكبيرة بنجاح');
    }

    public function show(BigRegion $bigRegion)
    {
        $bigRegion->load([
            'representative',
            'regions.representatives',
            'regions.citizens.distributions'
        ]);

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

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'representative_id' => 'required|exists:region_representatives,id',
            'regions' => 'nullable|array',
            'regions.*' => 'exists:regions,id',
            'note' => 'nullable|string'
        ]);

        $bigRegion = BigRegion::findOrFail($id);

        // Verify representative is a big region representative
        $representative = RegionRepresentative::findOrFail($validated['representative_id']);
        if (!$representative->is_big_region_representative) {
            return back()->withErrors(['representative_id' => 'Selected representative must be a big region representative.']);
        }

        // If assigning a different representative
        if ($validated['representative_id'] !== $bigRegion->representative_id) {
            // Clear any existing assignment of this representative
            BigRegion::where('representative_id', $validated['representative_id'])
                ->update(['representative_id' => null]);
        }

        $bigRegion->update([
            'name' => $validated['name'],
            'representative_id' => $validated['representative_id'],
            'note' => $validated['note'] ?? null
        ]);

        // Update region assignments
        Region::where('big_region_id', $bigRegion->id)
            ->update(['big_region_id' => null]);

        if (!empty($validated['regions'])) {
            Region::whereIn('id', $validated['regions'])
                ->update(['big_region_id' => $bigRegion->id]);
        }

        return redirect()->route('big-regions.index')
            ->with('success', 'تم تحديث المنطقة الكبيرة بنجاح');
    }

    public function destroy($id)
    {
        $bigRegion = BigRegion::findOrFail($id);
        
        // Check if there are any regions associated
        if ($bigRegion->regions()->count() > 0) {
            return back()->withErrors(['error' => 'لا يمكن حذف المنطقة الكبيرة لأنها تحتوي على مناطق مرتبطة']);
        }

        $bigRegion->delete();
        
        return redirect()->route('big-regions.index')
            ->with('success', 'تم حذف المنطقة الكبيرة بنجاح');
    }

    public function exportCitizens($id)
    {
        $export = $this->bigRegionService->exportCitizens($id);
        return Excel::download($export, 'citizens-' . $id . '.xlsx');
    }
}
