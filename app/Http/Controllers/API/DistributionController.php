<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Distribution;


class DistributionController extends Controller
{
    /**
     * Display a listing of the distributions.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('region_manager')) {
            // Fetch distributions related to the manager's region
            $distributions = Distribution::where('region_id', $user->region_id)->get();
        } else {
            // Admins and Super Admins can see all distributions
            $distributions = Distribution::all();
        }

        return response()->json($distributions, 200);
    }

    /**
     * Store a newly created distribution in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // Only Admins and Super Admins can create distributions
        if (!$user->hasAnyRole(['admin', 'super_admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'name'                    => 'required|string|max:255',
            'date'                    => 'required|date',
            'distribution_category_id'=> 'required|integer|exists:distribution_categories,id',
            'arrive_date'             => 'required|date',
            'quantity'                => 'required|integer',
            'target'                  => 'required|string|max:255',
            'source'                  => 'required|string|max:255',
            'source_id'               => 'required|integer|exists:sources,id',
            'done'                    => 'required|boolean',
            'target_count'            => 'required|integer',
            'expectation'             => 'required|string|max:255',
            'min_count'               => 'required|integer',
            'max_count'               => 'required|integer',
            'note'                    => 'nullable|string',
            'region_id'               => 'required|integer|exists:regions,id',
        ]);

        $distribution = Distribution::create($validatedData);

        return response()->json($distribution, 201);
    }

    /**
     * Display the specified distribution.
     */
    public function show($id, Request $request)
    {
        $user = $request->user();
        $distribution = Distribution::with('citizens')->find($id);

        if (!$distribution) {
            return response()->json(['message' => 'Distribution not found'], 404);
        }

        // Region Managers can only view distributions in their region
        if ($user->hasRole('region_manager') && $distribution->region_id !== $user->region_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($distribution, 200);
    }

    /**
     * Update the specified distribution in storage.
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $distribution = Distribution::find($id);

        if (!$distribution) {
            return response()->json(['message' => 'Distribution not found'], 404);
        }

        // Only Admins and Super Admins can update distributions
        if (!$user->hasAnyRole(['admin', 'super_admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'name'                    => 'sometimes|required|string|max:255',
            'date'                    => 'sometimes|required|date',
            'distribution_category_id'=> 'sometimes|required|integer|exists:distribution_categories,id',
            'arrive_date'             => 'sometimes|required|date',
            'quantity'                => 'sometimes|required|integer',
            'target'                  => 'sometimes|required|string|max:255',
            'source'                  => 'sometimes|required|string|max:255',
            'source_id'               => 'sometimes|required|integer|exists:sources,id',
            'done'                    => 'sometimes|required|boolean',
            'target_count'            => 'sometimes|required|integer',
            'expectation'             => 'sometimes|required|string|max:255',
            'min_count'               => 'sometimes|required|integer',
            'max_count'               => 'sometimes|required|integer',
            'note'                    => 'sometimes|nullable|string',
            'region_id'               => 'sometimes|required|integer|exists:regions,id',
        ]);

        $distribution->update($validatedData);

        return response()->json($distribution, 200);
    }

    /**
     * Remove the specified distribution from storage.
     */
    public function destroy($id, Request $request)
    {
        $user = $request->user();
        $distribution = Distribution::find($id);

        if (!$distribution) {
            return response()->json(['message' => 'Distribution not found'], 404);
        }

        // Only Admins and Super Admins can delete distributions
        if (!$user->hasAnyRole(['admin', 'super_admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $distribution->delete();

        return response()->json(['message' => 'Distribution deleted successfully'], 200);
    }
}