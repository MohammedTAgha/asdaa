<?php

namespace App\Http\Controllers;

use App\Services\DistributionService;
use Illuminate\Database\Eloquent\Model;
use App\Exports\CitizensdDistReportExport;
use App\Exports\DistributionExport;
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

    public function show($id ,DistributionReportService $distributionReportService )
    {
        $distributions = Distribution::all();
        $citizens = Citizen::all();
        $distribution = Distribution::findOrFail($id);
        $regions = Region::all();
        $stats = $distributionReportService->calculateStats($distribution);
       
        return view("distributions.show", compact("distribution", "citizens", "distributions", 'regions','stats'));
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

    public function addAllCitizens(Request $request , DistributionService $distributionService){
        $distributionId = $request->input('distributionId');
        Log::info("dist id ");
        Log::info($distributionId);

        if (empty($distributionId)) {
            return redirect()->back()->with("warning", "لا يوجد كشف محدد");
        }

        try {
            $report = $distributionService->addAllActiveToDistribution( $distributionId);

            $reportHtml = view('modals.addctz2dist', ['report' => $report])->render();
            return redirect()->back()
                ->with('success', 'تمت العملية بنجاح. يرجى مراجعة التقرير للتفاصيل.')
                ->with('addCitizensReportHtml', $reportHtml);
        } catch (\Exception $e) {
            Log::error('eroor adding ctz : '.$e->getMessage());
            return redirect()->back()->with("warning", "حدث خطأ في الإضافة");
        }
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
            $report = $distributionService->addCitizensToDistribution($citizenIds, $distributionId,[],true);

            $reportHtml = view('modals.addctz2dist', ['report' => $report])->render();
            return redirect()->back()
                ->with('success', 'تمت العملية بنجاح. يرجى مراجعة التقرير للتفاصيل.')
                ->with('addCitizensReportHtml', $reportHtml);
        } catch (\Exception $e) {
            Log::error('eroor adding ctz : '.$e->getMessage());
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
            'citizens.id',
            'citizens.firstname',
            'citizens.secondname',
            'citizens.thirdname',
            'citizens.lastname',
            'citizens.family_members',
            'regions.name as region',
            'distribution_citizens.quantity',  // From distribution_citizens table
            'distribution_citizens.done',      // From distribution_citizens table
            'distribution_citizens.date',      // From distribution_citizens table
            'distribution_citizens.recipient', // From distribution_citizens table
            'distribution_citizens.note',      // From distribution_citizens table
            'distribution_citizens.id as pivot_id'
        ])
        ->join('distribution_citizens', 'citizens.id', '=', 'distribution_citizens.citizen_id')
        ->join('regions', 'citizens.region_id', '=', 'regions.id')
        ->where('distribution_citizens.distribution_id', $distributionId);
        
        return DataTables::of($citizens)
            ->filterColumn('region', function($query, $keyword) {
                $query->whereRaw("LOWER(regions.name) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('quantity', function($query, $keyword) {
                $query->whereRaw("distribution_citizens.quantity LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('done', function($query, $keyword) {
                $query->whereRaw("distribution_citizens.done LIKE ?", ["%{$keyword}%"]);
            })
            ->addColumn('fullname', function ($citizen) {
                return $citizen->firstname . ' ' . $citizen->secondname . ' ' . $citizen->thirdname . ' ' . $citizen->lastname;
            })
            ->filterColumn('fullname', function($query, $keyword) {
                $query->whereRaw("LOWER(citizens.firstname) LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('fullname', function($query, $keyword) {
                $searchTerms = explode(' ', $keyword);
                $query->where(function ($q) use ($searchTerms, $keyword) {
                    // Full name search across name columns
                    $q->where(function ($nameQ) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $nameQ->where(function ($termQ) use ($term) {
                                $termQ->where('citizens.firstname', 'like', '%' . $term . '%')
                                      ->orWhere('citizens.secondname', 'like', '%' . $term . '%')
                                      ->orWhere('citizens.thirdname', 'like', '%' . $term . '%')
                                      ->orWhere('citizens.lastname', 'like', '%' . $term . '%');
                            });
                        }
                    });
            
                    // Original single-term searches for other columns
                    $q->orWhere('citizens.wife_name', 'like', '%' . $keyword . '%');
                });
                
            })
            ->addColumn('action', function ($citizen) {
                return '<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-1 rounded" data-id="' . $citizen->pivot_id . '">تحديث</button>';
            })
 
            
            ->toJson();
    }

    public function updateCitizens(Request $request, Distribution $distribution) {
        $citizens = $request->input('citizens');
        $field = $request->input('field');
        $value = $request->input('value');
    
        foreach ($citizens as $pivotId) {
            Log::alert('updating this id'.$pivotId);
            try{
                DB::table('distribution_citizens')
                ->where('id', $pivotId)
                ->update([$field.''=>$value]);
                $deletedIds[]=$pivotId;
              }catch (\Exception $e){
                    Log::error('eroor updating id: '.$pivotId);
              }
            // try {
            //     $distribution->citizens()->updateExistingPivot($pivotId, [$field => $value]);

            // }catch (\Exception $e) {
            //     //throw $th;
            // }
        }
    
        return response()->json(['success' => true]);
    }
    
    public function deleteCitizens(Request $request, Distribution $distribution) {
        $citizens = $request->input('citizens');
        $deletedIds = [];
        foreach ($citizens as $pivotId) {
            // Delete the record from the pivot table
          try{
            DB::table('distribution_citizens')
            ->where('id', $pivotId)
            ->delete();
            $deletedIds[]=$pivotId;
          }catch (\Exception $e){
                Log::error('eroor deleting id: '.$pivotId);
          }
          

        }
        session()->flash('message', 'deleted ok');

        return response()->json(['success' => ' removed','removed'=>$deletedIds], 200);
        // return response()->json(['success' => true]);
    }
    public function exportReport($report)
    {
        return Excel::download(new CitizensdDistReportExport($report), 'citizens_report.xlsx');
    }

    public function exportDistributionStatistics()
    {
        return $this->reportService->export();
    }
    // this is main export for distribution
    public function export($id) 
    {
        $distribution = Distribution::with(['citizens', 'citizens.region', 'category', 'source'])->findOrFail($id);
        
        return Excel::download(new DistributionExport($distribution), 'distribution_' . $id .'_'. time() . '.xlsx');
    }

    public function destroy(Distribution $distribution)
    {
        $distribution->delete();

        return redirect()
            ->route("distributions.index")
            ->with("success", "Distribution deleted successfully.");
    }
}
