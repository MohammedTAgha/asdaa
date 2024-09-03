<?php

namespace App\Http\Controllers;

use App\Services\DistributionService;
use Illuminate\Database\Eloquent\Model;
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
use App\Models\Source;
use App\Services\DistributionReportService;
use Yajra\DataTables\DataTables;

class DistributionController extends Controller
{
    protected $reportService;

    public function __construct(DistributionReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        $distributions = Distribution::with("category", 'source')->get();
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
            "distribution_category_id" => "nullable",
            "arrive_date" => "nullable|date",
            "quantity" => "nullable|integer",
            "target" => "nullable",
            "source_id" => "nullable|exists:sources,id",
            "done" => "nullable|boolean",
            "target_count" => "nullable|integer",
            "expectation" => "nullable",
            "min_count" => "nullable|integer",
            "max_count" => "nullable|integer",
            "note" => "nullable|string",
        ]);
        Log::info(['req id ' => $request->distribution_category_id]);

        // Check if a new category is being added
        if ($request->distribution_category_id === 'add_new' && $request->filled('new_category_name')) {
            Log::info(['new' => $request->distribution_category_id]);

            $newCategory = DistributionCategory::create(['name' => $request->new_category_name]);
            $request->merge(['distribution_category_id' => $newCategory->id]);
            Log::info(['new id' => $newCategory->id]);
            Log::info(['new request' =>  $request]);
        }

        // Handle new source creation
        if ($request->source_id === 'add_new_source' && $request->filled(['new_source_name', 'new_source_phone', 'new_source_email'])) {
            $newSource = Source::create([
                'name' => $request->new_source_name,
                'phone' => $request->new_source_phone,
                'email' => $request->new_source_email,
            ]);
            $request->merge(['source_id' => $newSource->id]);
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
        return view("distributions.show", compact("distribution", "citizens", "distributions", 'regions'));
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
            "source_id" => "nullable|exists:sources,id",
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

    public function addCitizens(Request $request, DistributionService $distributionService, $distributionId = null)
    {
        $citizenIds = explode(',', $request->input('citizens'));
        $distributionId = $request->input("distributionId", $distributionId);

        if (empty($citizenIds)) {
            return redirect()->back()->with("warning", "لا يوجد مواطنين تم اختيارهم");
        }

        if (empty($distributionId)) {
            return redirect()->back()->with("warning", "لا يوجد كشف محدد");
        }

        try {
            $report = $distributionService->addCitizensToDistribution($citizenIds, $distributionId);

            $reportHtml = view('modals.addctz2dist', ['report' => $report])->render();
            return redirect()->back()
                ->with('success', 'تمت العملية بنجاح. يرجى مراجعة التقرير للتفاصيل.')
                ->with('addCitizensReportHtml', $reportHtml);
        } catch (\Exception $e) {
            return redirect()->back()->with("warning", "حدث خطأ في الإضافة");
        }
    }

    public function addCitizensFilter(Request $request, DistributionService $distributionService, $distributionId = null)
    {
        // dd('fff');
        // Retrieve the filter parameters from the request
        $regions = $request->input('regions', []);
        $minFamilyMembers = $request->input('min_row_distribution', 0);
        $maxFamilyMembers = $request->input('max_row_distribution', PHP_INT_MAX);
        $distributionId = $request->input("distributionId", $distributionId);
        Log::alert('req1 ');
        Log::alert($request);
        // Query citizens based on the filter criteria

        $query = Citizen::query();
       

        if (!empty($regions)) {
            $query->whereIn('region_id', $regions);
        }

        if ($minFamilyMembers || $maxFamilyMembers) {
            $query->whereBetween('family_members', [$minFamilyMembers, $maxFamilyMembers]);
        }

        $citizenIds = $query->pluck('id')->toArray();
        $totalIds = count($citizenIds);
        Log::alert($totalIds);
        Log::alert('ids',$citizenIds);

         if (empty($citizenIds)) {
            Log::error("لا يوجد مواطنين تم اختيارهم بناءً على الفلاتر المقدمة");
            return redirect()->back()->with("warning", "لا يوجد مواطنين تم اختيارهم بناءً على الفلاتر المقدمة");
        }

        if (empty($distributionId)) {
            Log::error("لا يوجد كشف محدد");
            return redirect()->back()->with("warning", "لا يوجد كشف محدد");
        }

     
        try {
            $report = $distributionService->addCitizensToDistribution($citizenIds, $distributionId);
            Log::alert('re',$report);
            $reportHtml = view('modals.addctz2dist', ['report' => $report])->render();
            return redirect()->back()
                ->with('success', 'تمت العملية بنجاح. يرجى مراجعة التقرير للتفاصيل.')
                ->with('addCitizensReportHtml', $reportHtml);
        } catch (\Exception $e) {
            Log::alert($e);
            return redirect()->back()->with("warning", "حدث خطأ في الإضافة");
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

    public function getDistributionCitizens($distributionId)
{
    $citizens = Citizen::select([
        'citizens.id as citizen_id',
        'citizens.firstname',
        'citizens.secondname',
        'citizens.thirdname',
        'citizens.lastname',
        'citizens.family_members',
        'regions.name as region',
        'distribution_citizens.quantity',
        'distribution_citizens.done',
        'distribution_citizens.date',
        'distribution_citizens.recipient',
        'distribution_citizens.note',
        'distribution_citizens.id as pivot_id'
    ])
    ->join('distribution_citizens', 'citizens.id', '=', 'distribution_citizens.citizen_id')
    ->join('regions', 'citizens.region_id', '=', 'regions.id')
    ->where('distribution_citizens.distribution_id', $distributionId);
    return DataTables::of($citizens)
 
    ->addColumn('fullname', function ($citizen) {
        return $citizen->firstname . ' ' . $citizen->secondname . ' ' . $citizen->thirdname . ' ' . $citizen->lastname;
    })
    ->addColumn('action', function ($citizen) {
        return '<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-1 rounded" data-id="' . $citizen->pivot_id . '">تحديث</button>';
    })
        ->toJson();
}

    public function exportReport($report)
    {
        return Excel::download(new CitizensdDistReportExport($report), 'citizens_report.xlsx');
    }

    public function exportDistributionStatistics()
    {
        return $this->reportService->export();
    }

    public function destroy(Distribution $distribution)
    {
        $distribution->delete();

        return redirect()
            ->route("distributions.index")
            ->with("success", "Distribution deleted successfully.");
    }
}
