<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\DistributionCategory;
use App\Models\DistributionCitizen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function index()
    {
        $distributions = Distribution::with('category')->get();
        return view('distributions.index', compact('distributions'));
    }

    public function create()
    {
        $categories = DistributionCategory::all();
        return view('distributions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'distribution_category_id' => 'required|exists:distribution_categories,id',
            'arrive_date' => 'required|date',
            'quantity' => 'required|integer',
            'target' => 'required',
            'source' => 'required',
            'done' => 'required|boolean',
            'target_count' => 'required|integer',
            'expectation' => 'required',
            'min_count' => 'required|integer',
            'max_count' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        Distribution::create($request->all());

        return redirect()->route('distributions.index')->with('success', 'Distribution created successfully.');
    }

    public function show(Distribution $distribution)
    {
        return view('distributions.show', compact('distribution'));
    }

    public function edit(Distribution $distribution)
    {
        $categories = DistributionCategory::all();
        return view('distributions.edit', compact('distribution', 'categories'));
    }

    public function update(Request $request, Distribution $distribution)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'distribution_category_id' => 'required|exists:distribution_categories,id',
            'arrive_date' => 'required|date',
            'quantity' => 'required|integer',
            'target' => 'required',
            'source' => 'required',
            'done' => 'required|boolean',
            'target_count' => 'required|integer',
            'expectation' => 'required',
            'min_count' => 'required|integer',
            'max_count' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $distribution->update($request->all());

        return redirect()->route('distributions.index')->with('success', 'Distribution updated successfully.');
    }

    public function updatePivot(Request $request)
{
    $pivotId = $request->input('pivotId');
    $isChecked = $request->input('isChecked');
    $selectedDate = $request->input('selectedDate');
    $quantity = $request->input('quantity');
    $recipient = $request->input('recipient');
    $note = $request->input('note');

    $data=0;
    if ($isChecked ===true){
        $data = 1;
    }
    
    // Retrieve the pivot record and update the "done" state
    $pivot = DistributionCitizen::find($pivotId);
    $pivot->done = $isChecked;
    $pivot->date=$selectedDate;
     $pivot->quantity=$quantity;
     $pivot->recipient=$recipient;
     $pivot->note=$note;
     
    $pivot->save();

    return response()->json(['message' => $request->input('selectedDate')]);
}

public function addCitizens(Request $request, $distributionId = null)
{
    $citizenIds = explode(',', $request->input('citizen_ids'));
    
    $truncatedCitizens = [];

    DB::beginTransaction();
    try {
        Log::error('Citizen IDs:', ['ids' => $citizenIds]);
        foreach ($citizenIds as $citizenId) {
            Log::error('Citizen ID:', ['...' => $citizenId]);
            try {
                DB::table('distribution_citizens')->insert([
                    'distribution_id' => $distributionId ?? $request->input('distribution_id'),
                    'citizen_id' => $citizenId,
                ]);
            } catch (QueryException $e) {
                if (strpos($e->getMessage(), 'Data truncated') !== false) {
                    $truncatedCitizens[] = $citizenId;
                } else {
                    throw $e;
                }
            }
        }
        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error adding citizens: ', ['error' => $e->getMessage()]);
        return redirect()->back()->with('error', 'An error occurred while adding citizens.');
    }

    if (!empty($truncatedCitizens)) {
        return redirect()->back()->with('truncated_citizens', $truncatedCitizens);
    }

    return redirect()->back()->with('success', 'Citizens added successfully.');
}

    public function destroy(Distribution $distribution)
    {
        $distribution->delete();

        return redirect()->route('distributions.index')->with('success', 'Distribution deleted successfully.');
    }
}