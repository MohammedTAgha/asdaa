<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Region::with(['citizens', 'representatives', 'bigRegion.representative']);

        if ($user->hasRole('region_manager')) {
            $regions = $query->whereIn('id', $user->regions->pluck('id'))->paginate(6);
        } else {
            $regions = $query->paginate(6);
        }

        return response()->json($regions, 200);
    }

    public function all(Request $request)
    {
        $user = $request->user();
        $query = Region::with(['citizens', 'representatives', 'bigRegion.representative']);

        if ($user->hasRole('region_manager')) {
            $regions = $query->whereIn('id', $user->regions->pluck('id'))->get();
        } else {
            $regions = $query->get();
        }

        return response()->json($regions, 200);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->hasAnyRole(['admin', 'super_admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:regions,name',
            'position' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'big_region_id' => 'nullable|exists:big_regions,id'
        ]);

        $region = Region::create($validatedData);
        $region->load(['bigRegion.representative']);

        return response()->json($region, 201);
    }

    public function show($id, Request $request)
    {
        $user = $request->user();
        $region = Region::with([
            'representatives', 
            'citizens',
            'bigRegion.representative'
        ])->find($id);

        if (!$region) {
            return response()->json(['message' => 'Region not found'], 404);
        }

        if ($user->hasRole('region_manager') && !$user->regions->contains($id)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($region, 200);
    }

    public function update($id, Request $request)
    {
        $user = $request->user();
        $region = Region::findOrFail($id);

        if (!$user->hasAnyRole(['admin', 'super_admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:regions,name,' . $id,
            'position' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'big_region_id' => 'nullable|exists:big_regions,id'
        ]);

        $region->update($validatedData);
        $region->load(['bigRegion.representative']);

        return response()->json($region, 200);
    }

    public function destroy($id, Request $request)
    {
        $user = $request->user();
        $region = Region::findOrFail($id);

        if (!$user->hasAnyRole(['admin', 'super_admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($region->citizens()->exists()) {
            return response()->json([
                'message' => 'Cannot delete region with existing citizens'
            ], 400);
        }

        $region->delete();
        return response()->json(null, 204);
    }
}