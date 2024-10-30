<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Citizen;
use App\Http\Resources\CitizenResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CitizenController extends Controller
{
    /**
     * Display a listing of the citizens.
     */
    public function index(Request $request)
    {
        Log::info('api 111');
        $user = $request->user();
        $citizens = Citizen::with('distributions','region.representatives')->get();
      
        // if ($user->hasRole('region_manager')) {
        //     // Assuming the User model has a region_id attribute
        //     $citizens = Citizen::where('region_id', $user->region_id)->get();
        // } else {
        //     // Admins and Super Admins can see all citizens
            
        // }

        return response()->json($citizens, 200);
    }

    /**
     * Store a newly created citizen in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // Only Admins and Region Managers can create citizens
        if (!$user->hasAnyRole(['admin', 'region_manager'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'firstname'       => 'required|string|max:255',
            'secondname'      => 'nullable|string|max:255',
            'thirdname'       => 'nullable|string|max:255',
            'lastname'        => 'required|string|max:255',
            'phone'           => 'nullable|string|max:20',
            'family_members'  => 'nullable|integer',
            'wife_id'         => 'nullable|integer|exists:citizens,id',
            'wife_name'       => 'nullable|string|max:255',
            'region_id'       => 'required|integer|exists:regions,id',
            'date_of_birth'   => 'required|date',
            'gender'          => 'required|string|in:male,female,other',
            'social_status'   => 'required|string',
            'is_archived'     => 'required|boolean',
            'verified'        => 'required|boolean',
        ]);

        $citizen = Citizen::create($validatedData);

        return response()->json($citizen, 201);
    }

    /**
     * Display the specified citizen.
     */
    public function show($id, Request $request)
    {
        $user = $request->user();
        $citizen = Citizen::find($id);

        if (!$citizen) {
            return response()->json(['message' => 'Citizen not found'], 404);
        }

        // Region Managers can only view citizens in their region
        if ($user->hasRole('region_manager') && $citizen->region_id !== $user->region_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($citizen, 200);
    }

    /**
     * Update the specified citizen in storage.
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $citizen = Citizen::find($id);

        if (!$citizen) {
            return response()->json(['message' => 'Citizen not found'], 404);
        }

        // Region Managers can only update citizens in their region
        if ($user->hasRole('region_manager') && $citizen->region_id !== $user->region_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Only Admins and Region Managers can update citizens
        if (!$user->hasAnyRole(['admin', 'region_manager'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'firstname'       => 'sometimes|required|string|max:255',
            'secondname'      => 'sometimes|nullable|string|max:255',
            'thirdname'       => 'sometimes|nullable|string|max:255',
            'lastname'        => 'sometimes|required|string|max:255',
            'phone'           => 'sometimes|nullable|string|max:20',
            'family_members'  => 'sometimes|nullable|integer',
            'wife_id'         => 'sometimes|nullable|integer|exists:citizens,id',
            'wife_name'       => 'sometimes|nullable|string|max:255',
            'region_id'       => 'sometimes|required|integer|exists:regions,id',
            'date_of_birth'   => 'sometimes|required|date',
            'gender'          => 'sometimes|required|string|in:male,female,other',
            'social_status'   => 'sometimes|required|string',
            'is_archived'     => 'sometimes|required|boolean',
            'verified'        => 'sometimes|required|boolean',
        ]);

        $citizen->update($validatedData);

        return response()->json($citizen, 200);
    }

    /**
     * Remove the specified citizen from storage.
     */
    public function destroy($id, Request $request)
    {
        $user = $request->user();
        $citizen = Citizen::find($id);

        if (!$citizen) {
            return response()->json(['message' => 'Citizen not found'], 404);
        }

        // Region Managers can only delete citizens in their region
        if ($user->hasRole('region_manager') && $citizen->region_id !== $user->region_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Only Admins and Region Managers can delete citizens
        if (!$user->hasAnyRole(['admin', 'region_manager'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $citizen->delete();

        return response()->json(['message' => 'Citizen deleted successfully'], 200);
    }
}