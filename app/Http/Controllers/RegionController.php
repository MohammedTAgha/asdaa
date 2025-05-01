<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\BigRegion;
use App\Models\RegionRepresentative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionController extends Controller
{
    public function index(Request $request)
    {
        $query = Region::with(['bigRegion.representative', 'representatives']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('bigRegion', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('representatives', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by big region
        if ($request->filled('big_region_id')) {
            $query->where('big_region_id', $request->big_region_id);
        }

        // Sort functionality
        $sort = $request->sort ?? 'name';
        $direction = $request->direction ?? 'asc';
        $query->orderBy($sort, $direction);
        
        if (auth()->user() && auth()->user()->role_id == 3) {
            $regionIds = auth()->user()->regions->pluck('id')->toArray();
            $query->whereIn('id', $regionIds);
        }
        
        $regions = $query->paginate(10);
        $bigRegions = BigRegion::all();
        
        return view('regions.index', compact('regions', 'bigRegions'));
    }

    public function create()
    {
        $bigRegions = BigRegion::with('representative')->get();
        $representatives = RegionRepresentative::where('is_big_region_representative', false)
            ->doesntHave('region')
            ->get();
        return view('regions.create', compact('bigRegions', 'representatives'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:regions,name',
            'position' => 'required|string|max:255',
            'big_region_id' => 'nullable|exists:big_regions,id',
            'representative_ids' => 'nullable|array',
            'representative_ids.*' => 'exists:region_representatives,id',
            'note' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $region = Region::create([
                'name' => $validated['name'],
                'position' => $validated['position'],
                'big_region_id' => $validated['big_region_id'],
                'note' => $validated['note']
            ]);

            if (!empty($validated['representative_ids'])) {
                RegionRepresentative::whereIn('id', $validated['representative_ids'])
                    ->where('is_big_region_representative', false)
                    ->update(['region_id' => $region->id]);
            }

            DB::commit();
            return redirect()->route('regions.index')
                ->with('success', 'تم إنشاء المنطقة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'حدث خطأ أثناء إنشاء المنطقة'])
                ->withInput();
        }
    }

    public function show($id)
    {
        $region = Region::with([
            'bigRegion.representative',
            'representatives' => function($query) {
                $query->where('is_big_region_representative', false);
            },
            'citizens'
        ])->findOrFail($id);
        
        // Get all regions and distributions for the citizens component
        $regions = Region::with('representatives')->get();
        $distributions = \App\Models\Distribution::all();
        
        return view('regions.show', compact('region', 'regions', 'distributions'));
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
