<?php

namespace App\Http\Controllers;

use App\Models\RegionRepresentative;
use App\Models\Region;
use App\Models\BigRegion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $bigRegions = BigRegion::doesntHave('representative')->get();
        return view('representatives.create', compact('regions', 'bigRegions'));
    }

    public function store(Request $request)
    {
        try {
            // First, determine if this is a big region representative
            $isBigRegion = $request->has('is_big_region_representative');
            
            // Set up validation rules
            $rules = [
                'id' => 'required|numeric|digits_between:1,20|unique:region_representatives,id',
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:15',
                'address' => 'nullable|string|max:255',
                'note' => 'nullable|string',
            ];

            // Add validation rules based on representative type
            if ($isBigRegion) {
                $rules['big_region_id'] = 'nullable|exists:big_regions,id';
            } else {
                $rules['region_id'] = 'required|exists:regions,id';
            }

            $validated = $request->validate($rules);

            try {
                DB::beginTransaction();

                // Create the representative
                $representative = RegionRepresentative::create([
                    'id' => $validated['id'],
                    'name' => $validated['name'],
                    'phone' => $validated['phone'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'note' => $validated['note'] ?? null,
                    'is_big_region_representative' => $isBigRegion,
                    'region_id' => $isBigRegion ? null : $validated['region_id']
                ]);

                // If this is a big region representative and a big region was selected
                if ($isBigRegion && !empty($validated['big_region_id'])) {
                    // Clear any other representative from this big region first
                    $bigRegion = BigRegion::findOrFail($validated['big_region_id']);
                    $bigRegion->update(['representative_id' => $representative->id]);
                }

                DB::commit();
                return redirect()->route('representatives.index')
                    ->with('success', 'تم إنشاء المندوب بنجاح');

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Error creating representative', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            return back()->withErrors(['error' => 'حدث خطأ أثناء إنشاء المندوب. يرجى المحاولة مرة أخرى.'])
                ->withInput();
        }
    }

    public function show($id)
    {
        $representative = RegionRepresentative::with(['region', 'managedBigRegion'])->findOrFail($id);
        $regions = Region::all();
        return view('representatives.show', compact('representative', 'regions'));
    }

    public function edit($id)
    {
        $representative = RegionRepresentative::with('managedBigRegion')->findOrFail($id);
        $regions = Region::all();
        $bigRegions = BigRegion::where(function($query) use ($representative) {
            $query->doesntHave('representative')
                  ->orWhere('representative_id', $representative->id);
        })->get();
        
        return view('representatives.edit', compact('representative', 'regions', 'bigRegions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required|numeric',
            'name' => 'required|string|max:255',
            'region_id' => 'nullable|exists:regions,id',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'is_big_region_representative' => 'boolean',
            'big_region_id' => 'nullable|exists:big_regions,id',
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

        // Update the representative
        $representative->update($request->except('big_region_id'));

        // Handle big region assignment if this is a big region representative
        if ($request->is_big_region_representative) {
            // Remove this representative from any currently managed big regions
            BigRegion::where('representative_id', $representative->id)
                ->update(['representative_id' => null]);
            
            // If a new big region was selected, assign them to it
            if ($request->filled('big_region_id')) {
                BigRegion::findOrFail($request->big_region_id)
                    ->update(['representative_id' => $representative->id]);
            }
        }

        return redirect()->route('representatives.index')->with('success', 'Representative updated successfully.');
    }

    public function destroy($id)
    {
        $representative = RegionRepresentative::findOrFail($id);
        
        // Clear any big region assignments
        BigRegion::where('representative_id', $representative->id)
            ->update(['representative_id' => null]);
            
        $representative->delete();
        return redirect()->route('representatives.index')->with('success', 'Representative deleted successfully.');
    }
}