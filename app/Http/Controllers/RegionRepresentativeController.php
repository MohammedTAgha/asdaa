<?php

namespace App\Http\Controllers;

use App\Models\RegionRepresentative;
use App\Models\Region;
use Illuminate\Http\Request;
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
        return view('representatives.create', compact('regions'));
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

            // Only require region_id for regular representatives
            if (!$isBigRegion) {
                $rules['region_id'] = 'required|exists:regions,id';
            }

            $validated = $request->validate($rules);

            // Prepare data for creation
            $data = $validated;
            $data['is_big_region_representative'] = $isBigRegion;
            
            // If big region representative, ensure no region is assigned
            if ($isBigRegion) {
                $data['region_id'] = null;
            }

            Log::info('Creating representative with data:', ['data' => $data]);

            RegionRepresentative::create($data);
            return redirect()->route('representatives.index')
                ->with('success', 'Representative created successfully.');

        } catch (\Exception $e) {
            Log::error('Error creating representative', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            return back()->withErrors(['error' => 'An error occurred while creating the representative. Please try again.'])
                ->withInput();
        }
    }

    public function show($id)
    {
        $representative = RegionRepresentative::with('region')->findOrFail($id);
        $regions = Region::all();
        return view('representatives.show', compact('representative', 'regions'));
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
            'region_id' => 'nullable|exists:regions,id',
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