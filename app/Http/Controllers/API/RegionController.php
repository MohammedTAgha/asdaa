<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the regions.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('region_manager')) {
            // Region Managers can see only their region
            $regions = Region::where('id', $user->region_id)->with('representatives', 'citizens')->get();
        } else {
            // Admins and Super Admins can see all regions
            $regions = Region::with('representatives', 'citizens')->get();
        }

        return response()->json($regions, 200);
    }

    /**
     * Store a newly created region in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // Only Admins and Super Admins can create regions
        if (!$user->hasAnyRole(['admin', 'super_admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'name'    => 'required|string|max:255|unique:regions,name',
            'position'=> 'nullable|string|max:255',
            'note'    => 'nullable|string',
        ]);

        $region = Region::create($validatedData);

        return response()->json($region, 201);
    }

    /**
     * Display the specified region.
     */
    public function show($id, Request $request)
    {
        $user = $request->user();
        $region = Region::with('representatives', 'citizens')->find($id);

        if (!$region) {
            return response()->json(['message' => 'Region not found'], 404);
        }

        // Region Managers can only view their own region
        if ($user->hasRole('region_manager') && $region->id !== $user->region_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($region, 200);
    }

    /**
     * Update the specified region in storage.
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $region = Region::find($id);

        if (!$region) {
            return response()->json(['message' => 'Region not found'], 404);
        }

        // Only Admins and Super Admins can update regions
        if (!$user->hasAnyRole(['admin', 'super_admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'name'     => 'sometimes|required|string|max:255|unique:regions,name,' . $region->id,
            'position' => 'sometimes|nullable|string|max:255',
            'note'     => 'sometimes|nullable|string',
        ]);

        $region->update($validatedData);

        return response()->json($region, 200);
    }

    /**
     * Remove the specified region from storage.
     */
    public function destroy($id, Request $request)
    {
        $user = $request->user();
        $region = Region::find($id);

        if (!$region) {
            return response()->json(['message' => 'Region not found'], 404);
        }

        // Only Admins and Super Admins can delete regions
        if (!$user->hasAnyRole(['admin', 'super_admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $region->delete();

        return response()->json(['message' => 'Region deleted successfully'], 200);
    }
}