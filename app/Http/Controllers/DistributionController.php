<?php

namespace App\Http\Controllers;

use App\Exports\CitizensdDistReportExport;
use App\Models\Distribution;
use App\Models\DistributionCategory;
use App\Models\DistributionCitizen;
use App\Models\Citizen;
use App\Models\Region;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Facades\Excel;
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
            "distribution_category_id" => "nullable|exists:distribution_categories,id",
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
    
        // Check if a new category is being added
        if ($request->distribution_category_id === 'add_new' && $request->filled('new_category_name')) {
            Log::alert(['new' => $request->distribution_category_id ]);
            $newCategory = DistributionCategory::create(['name' => $request->new_category_name]);
            $request->merge(['distribution_category_id' => $newCategory->id]);
        }
    
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
        $regions = Region::all();
        return view("distributions.show", compact("distribution", "citizens", "distributions" , 'regions'));
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
        Log::debug('test');
        
        $citizenIds = explode(',', $request->input('citizens'));
        // dd($citizenIds);

        $distributionId = $request->input("distributionId", $distributionId);
        Log::debug($citizenIds);
        if (empty($citizenIds)) {
            return redirect()->back()->with("danger", "لا يوجد مواطنين تم اختيارهم");
        }
    
        if (empty($distributionId)) {
            return redirect()->back()->with("danger", "لا يوجد كشف محدد");
        }
        $totalIds = count($citizenIds);
        DB::beginTransaction();
        try {
            // Check which citizens already exist in the distribution
            $existingInDistribution = DB::table("distribution_citizens")
                ->where("distribution_id", $distributionId)
                ->whereIn("citizen_id", $citizenIds)
                ->pluck("citizen_id")
                ->toArray();
    
            // Check which citizens exist in the citizens table
            $existingCitizens = Citizen::whereIn("id", $citizenIds)->pluck("id")->toArray();
    
            // Identify non-existent citizens
            $nonExistentCitizens = array_diff($citizenIds, $existingCitizens);
    
            // Identify citizens to be added (exist in citizens table but not in distribution)
            $citizensToAdd = array_diff($existingCitizens, $existingInDistribution);
    
            $addedCount = 0;
            $addedCitizens = [];
    
            foreach ($citizensToAdd as $citizenId) {
                DB::table("distribution_citizens")->insert([
                    "distribution_id" => $distributionId,
                    "citizen_id" => $citizenId,
                ]);
                $addedCount++;
                $addedCitizens[] = $citizenId;
            }
    
            $existingCitizenData = Citizen::whereIn("id", $existingInDistribution)
                ->select('id', 'firstname', 'lastname')
                ->get()
                ->toArray();
    
            $addedCitizenData = Citizen::whereIn("id", $addedCitizens)
                ->select('id', 'firstname', 'lastname')
                ->get()
                ->toArray();
    
            DB::commit();
            
            $report = [
                'added' => [
                    'count' => $addedCount,
                    'citizens' => $addedCitizenData
                ],
                'existing' => [
                    'count' => count($existingInDistribution),
                    'citizens' => $existingCitizenData
                ],
                'updated' => [
                    'count' => count($nonExistentCitizens),
                    'citizens' => $nonExistentCitizens // This will be an array of IDs
                ],
                'nonexistent' => [
                    'count' => count($nonExistentCitizens),
                    'citizens' => $nonExistentCitizens // This will be an array of IDs
                ],
                'totalIds' => $totalIds

            ];
    
            $reportHtml = view('modals.addctz2dist', ['report' => $report])->render();    
            return redirect()->back()
                ->with('success', 'تمت العملية بنجاح. يرجى مراجعة التقرير للتفاصيل.')
                ->with('addCitizensReportHtml', $reportHtml);
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug('xxxxx');
            Log::error("Error adding citizens: ", ["error" => $e->getMessage()]);
            Log::error("Error adding citizen: ", ["xxxx" =>$report ]);
            return redirect()->back()->with("danger", "حدث خطأ في الإضافة");
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

    public function exportReport($report)
{
    return Excel::download(new CitizensdDistReportExport($report), 'citizens_report.xlsx');
}
    public function destroy(Distribution $distribution)
    {
        $distribution->delete();

        return redirect()
            ->route("distributions.index")
            ->with("success", "Distribution deleted successfully.");
    }
}
