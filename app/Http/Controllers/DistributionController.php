<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\DistributionCategory;
use App\Models\DistributionCitizen;
use App\Models\Citizen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function index()
    {
        $distributions = Distribution::with("category")->get();
        return view("distributions.index", compact("distributions"));
    }

    public function create()
    {
        $categories = DistributionCategory::all();
        return view("distributions.create", compact("categories"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "date" => "nullable|date",
            "distribution_category_id" =>
                "nullable|exists:distribution_categories,id",
            "arrive_date" => "nullable|date",
            "quantity" => "nullable|integer",
            "target" => "nullable",
            "source" => "nullable",
            "done" => "nullable|boolean",
            "target_count" => "nullable|integer",
            "expectation" => "nullable",
            "min_count" => "nullable|integer",
            "max_count" => "nullable|integer",
            "note" => "nullable|string",
        ]);

        Distribution::create($request->all());

        return redirect()
            ->route("distributions.index")
            ->with("success", "Distribution created successfully.");
    }

    public function show($id)
    {   
        $distributions = Distribution::all();
        $citizens = Citizen::all();
        $distribution = Distribution::findOrFail($id);
        return view("distributions.show", compact("distribution","citizens","distributions"));
    }

    public function edit(Distribution $distribution)
    {
        $categories = DistributionCategory::all();
        return view(
            "distributions.edit",
            compact("distribution", "categories")
        );
    }

    public function update(Request $request, Distribution $distribution)
    {
        $request->validate([
            "name" => "required",
            "date" => "nullable|date",
            "distribution_category_id" =>
                "nullable|exists:distribution_categories,id",
            "arrive_date" => "nullable|date",
            "quantity" => "nullable|integer",
            "target" => "nullable",
            "source" => "nullable",
            "done" => "nullable|boolean",
            "target_count" => "nullable|integer",
            "expectation" => "nullable",
            "min_count" => "nullable|integer",
            "max_count" => "nullable|integer",
            "note" => "|string",
        ]);

        $distribution->update($request->all());

        return redirect()
            ->route("distributions.index")
            ->with("success", "Distribution updated successfully.");
    }

    public function updatePivot(Request $request)
    {
        $pivotId = $request->input("pivotId");
        $isChecked = $request->input("isChecked");
        $selectedDate = $request->input("selectedDate");
        $quantity = $request->input("quantity");
        $recipient = $request->input("recipient");
        $note = $request->input("note");

        $data = 0;
        if ($isChecked === true) {
            $data = 1;
        }

        // Retrieve the pivot record and update the "done" state
        $pivot = DistributionCitizen::find($pivotId);
        $pivot->done = $isChecked;
        $pivot->date = $selectedDate;
        $pivot->quantity = $quantity;
        $pivot->recipient = $recipient;
        $pivot->note = $note;

        $pivot->save();

        return response()->json(["message" => $request->input("selectedDate")]);
    }
    public function getDistributions()
    {
        $distributions = Distribution::all();
        return response()->json(["distributions" => $distributions]);
    }
    public function addCitizens(Request $request, $distributionId = null)
    {
        dd($request);
        $citizenIds = explode(",", $request->input("citizen_ids"));
        $distributionId = $distributionId ?? $request->input("distribution_id");
        $truncatedCitizens = [];
        $existingCitizenNames = [];

        DB::beginTransaction();
        try {
            Log::error("Citizen IDs:", ["ids" => $citizenIds]);

            // Retrieve existing citizens in the distribution
            $existingCitizens = DB::table("distribution_citizens")
                ->where("distribution_id", $distributionId)
                ->whereIn("citizen_id", $citizenIds)
                ->pluck("citizen_id")
                ->toArray();

            // Filter out existing citizens
            $newCitizenIds = array_diff($citizenIds, $existingCitizens);

            foreach ($newCitizenIds as $citizenId) {
                Log::error("Citizen ID:", ["..." => $citizenId]);
                try {
                    DB::table("distribution_citizens")->insert([
                        "distribution_id" => $distributionId,
                        "citizen_id" => $citizenId,
                    ]);
                } catch (QueryException $e) {
                    if (strpos($e->getMessage(), "Data truncated") !== false) {
                        $truncatedCitizens[] = $citizenId;
                    } else {
                        throw $e;
                    }
                }
            }

            // Get names of existing citizens
            if (!empty($existingCitizens)) {
                $existingCitizenNames = Citizen::whereIn(
                    "id",
                    $existingCitizens
                )
                    ->pluck("name")
                    ->toArray();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error adding citizens: ", [
                "error" => $e->getMessage(),
            ]);
            if ($request->expectsJson()) {
                return response()->json(
                    ["error" => "An error occurred while adding citizens."],
                    500
                );
            } else {
                return response()->json(
                    ["error" => "An error occurred while adding citizens."],
                    500
                );
            }
        }

        if (!empty($truncatedCitizens)) {
            if ($request->expectsJson()) {
                return response()->json(
                    ["truncated_citizens" => $truncatedCitizens],
                    400
                );
            } else {
                return response()->json(
                    ["truncated_citizens" => $truncatedCitizens],
                    400
                );
            }
        }

        if (!empty($existingCitizenNames)) {
            if ($request->expectsJson()) {
                return response()->json(
                    ["existing_citizens" => $existingCitizenNames],
                    200
                );
            } else {
                return response()->json(
                    ["existing_citizens" => $existingCitizenNames],
                    200
                );
            }

            return response()->json(
                ["success" => "Citizens added successfully."],
                200
            );
        }
    }

    public function removeCitizenFromDistribution($id) //pivot table id
    {
        
        try {
            // Delete the record from the pivot table
            DB::table('distribution_citizens')
            ->where('id', $id)
            ->delete();
            // DB::table('distribution_citizens')
            //     ->where('distribution_id', $distributionId)
            //     ->where('citizen_id', $citizenId)
            //     ->delete();

            return response()->json(['success' => 'Citizen removed successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error removing citizen: ', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while removing the citizen.'], 500);
        }
    }
    
    public function destroy(Distribution $distribution)
    {
        $distribution->delete();

        return redirect()
            ->route("distributions.index")
            ->with("success", "Distribution deleted successfully.");
    }
}
