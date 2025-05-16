<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\Region;
use App\Models\Distribution;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CitizensImport;
use App\Exports\CitizensExport;
use Illuminate\Support\Facades\Log;
use App\Exports\CitizensTemplateExport;
use App\Exports\FailedRowsExport;
use App\Services\CitizensAndDistributionExportService;
use App\Services\CitizenService;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Services\CitizenImportService;
use App\Exports\ImportReportExport;

class CitizenController extends Controller
{
    protected $citizenService;
    protected $citizenImportService;

    public function __construct(CitizenService $citizenService, CitizenImportService $citizenImportService)
    {
        $this->citizenService = $citizenService;
        $this->citizenImportService = $citizenImportService;
    }
    public function index(Request $request)
    {
        $user = Auth::user();
     
        if ($user->role_id ==1) {
            $filters = $request->all();
            $filters['regions'] = $user->regions->pluck('id')->toArray();
    
            // Fetch the citizens with the applied filters
            $citizens = Citizen::filter($filters)->get()->toArray();
             
        }
        
        $regions = Region::all();
        $distributions = Distribution::all();
        $distribution = null;
        $distributionId = $request->input('distributionId');

        $citizens = Citizen::filter($request->all());
        if ($request->has('returnjson') && $request->input('returnjson') == 1) {

            return response()->json($citizens);
        }
        return view('citizens.index', compact('regions', 'distributions', 'distributionId'));
    }

    public function getData(Request $request)
    {


        $query = Citizen::with('region')
            ->filter($request->all())
            ->forUserRegions()
            ->select(['id', 'firstname', 'secondname', 'thirdname', 'lastname', 'wife_name', 'family_members', 'region_id', 'note']);
    
               
        // Apply other filters
        // $query-->scopeForUserRegions();
        

        return DataTables::of($query)
            ->addColumn('region', function ($citizen) {
                return $citizen->region->name ?? 'N/A';
            })
            ->addColumn('name', function ($citizen) {
                return '<a href="'.route('citizens.show', $citizen->id).'">'.$citizen->firstname . ' ' . $citizen->secondname . ' ' . $citizen->thirdname . ' ' . $citizen->lastname. '</a>';
                
            })
            ->addColumn('action', function ($citizen) {
                $actions = '';
                if ($citizen->trashed()) {
                    $actions .= '<button class="btn btn-sm btn-success restore-btn" data-id="' . $citizen->id . '">Restore</button>';
                } else {
                    $actions .= '<a href="' . route('citizens.edit', $citizen->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                    // ... other actions ...
                }
                return $actions;
            })
            ->addColumn('checkbox', function ($citizen) {
                return '<div class="form-check px form-check-sm form-check-custom form-check-solid"><input class="form-check-input w-18px" type="checkbox" name="citizens[]" value="'.$citizen->id.'"></div>';
            })
            ->rawColumns(['action', 'checkbox','name'])
            ->make(true);
    }

 


    public function show($id)
    {
        $citizens = Citizen::all();
        $citizen = Citizen::with('children')->findOrFail($id);
        return view('citizens.show', compact('citizen', 'citizens'));
    }

    public function create()
    {
        $regions = Region::all();
        return view('citizens.create', compact('regions'));
    }

    public function store(Request $request)
    {

        $data = [
            'id' => $request->input('id'),
            'firstname' => $request->input('firstname'),
            'secondname' => $request->input('secondname'),
            'thirdname' => $request->input('thirdname'),
            'lastname' => $request->input('lastname'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'region_id' => $request->input('region_id'),
            'wife_id' => $request->input('wife_id'),
            'wife_name' => $request->input('wife_name'),
            'widowed' => $request->input('widowed'),
            'social_status' => $request->input('social_status'),
            'living_status' => $request->input('living_status'),
            'job' => $request->input('job'),
            'original_address' => $request->input('original_address'),
            'elderly_count' => $request->input('elderly_count'),
            'note' => $request->input('note'),
            'family_members' => $request->input('family_members'),
            'mails_count' => $request->input('mails_count'),
            'femails_count' => $request->input('femails_count'),
            'mails_count' => $request->input('mails_count'),
            'leesthan3' => $request->input('leesthan3'),
            'disease' => $request->input('disease'),
            'disease_description' => $request->input('disease_description'),
            'obstruction' => $request->input('obstruction'),
            'obstruction_description' => $request->input('obstruction_description'),

        ];
        
        Citizen::create($data);
        return redirect()->route('citizens.index')->with('success', 'Citizen created successfully.');
    }

    public function edit($id)
    {
        $citizen = Citizen::findOrFail($id);
        $regions = Region::all();
        return view('citizens.edit', compact('citizen','regions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([$request->all()]);

        $citizen = Citizen::findOrFail($id);
        $citizen->update($request->all());
        return redirect()->route('citizens.index')->with('success', 'تم تحديث بيانات ' . $citizen->firstname . ' ' . $citizen->lasttname);
    }

    public function downloadTemplate()
    {
        return Excel::download(new CitizensTemplateExport, 'الترويسة.xlsx');
    }

    public function import()
    {
        $regions = Region::all();
        return (view('citizens.import',compact('regions')));
    }

    public function export(Request $request)
    {
        
        $query = Citizen::query();

        // Apply the same filters as in the index method
        if ($request->has('id') && !empty($request->input('id'))) {
            $query->where('id', $request->input('id'));
        }
        if ($request->has('first_name') && !empty($request->input('first_name'))) {
            $query->where('firstname', 'like', '%' . $request->input('first_name') . '%');
        }
        if ($request->has('second_name') && !empty($request->input('second_name'))) {
            $query->where('secondname', 'like', '%' . $request->input('second_name') . '%');
        }
        if ($request->has('third_name') && !empty($request->input('third_name'))) {
            $query->where('thirdname', 'like', '%' . $request->input('third_name') . '%');
        }
        if ($request->has('last_name') && !empty($request->input('last_name'))) {
            $query->where('lastname', 'like', '%' . $request->input('last_name') . '%');
        }
        if ($request->has('search') && !empty($request->input('search'))) {
            $query->where(function ($q) use ($request) {
                $q->where('firstname', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('secondname', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('thirdname', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('lastname', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('wife_name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('id', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('note', 'like', '%' . $request->input('search') . '%');
            });
        }
        if ($request->has('age')) {
            $query->where('age', $request->input('age'));
        }
        if ($request->has('gender') && !empty($request->input('gender'))) {
            $query->where('gender', $request->input('gender'));
        }
        if ($request->has('regions') && !empty($request->input('regions'))) {
            $query->whereIn('region_id', $request->regions);
        }

        $citizens = Citizen::filter($request->all())->with('region')->get();
        
        return Excel::download(new CitizensExport($citizens), 'citizens.xlsx');
    }

    
    public function restore($id)
    {
        $restoredCount = $this->citizenService->restore($id);
        
        if ($restoredCount > 0) {
            return response()->json(['message' => 'Citizen restored successfully']);
        } else {
            return response()->json(['message' => 'Citizen not found or already restored'], 404);
        }
    }
    
    public function restoreMultiple(Request $request)
    {
        $ids = $request->input('ids');
        $restoredCount = $this->citizenService->restore($ids);

        return response()->json(['message' => "{$restoredCount} citizens restored successfully"]);
    }
    public function upload(Request $request)
    {
        $request->validate([
            'regionId' => 'nullable|exists:regions,id',
            'excel_file' => 'required|mimes:xlsx,xls,csv',
            'should_update_existing' => 'boolean'
        ]);

        $result = $this->citizenImportService->import(
            $request->file('excel_file'),
            $request->input('regionId'),
            $request->boolean('should_update_existing')
        );

        if (!$result['success']) {
            return back()->withErrors($result['errors'] ?? [$result['message']]);
        }

        // Store the result in the session with a longer timeout
        session()->put('import_result', $result);
        session()->save();

        return redirect()->route('citizens.import')
            ->with('success', 'تم استيراد البيانات بنجاح');
    }
    public function removeSelectedCitizens(Request $request){
        $citizensIds=$request->input('citizenIds',[]);
        $result = $this->citizenService->removeCitizens($citizensIds);
        if(empty($citizensIds)){return response()->json(['erorr'=>'no citizens']);}
        return $result ?  response()->json(['success'=>'romvid successfuly6']):
         response()->json(['success'=>'romvid successfuly6']);
         
    }

    public function changeRegionForSelectedCitizens(Request $request){
        $citizensIds=$request->input('citizeIds',[]);
        $regionId = $request->input('regionId');
        if (empty($citizenIds) || empty($regionId)) {
            return response()->json(['error' => 'Citizens or region not selected'], 400);
        }
        $result = $this->citizenService->changeRegion($citizensIds , $regionId);
        return $result ?response()->json(['success'=>'updated successfuly6']):
        response()->json(['erorr'=>'erorr updating list']);
    }
    public function destroy($id)
    {
        $citizen = Citizen::findOrFail($id);
        $citizen->delete();
        return redirect()->route('citizens.index')->with('success', 'Citizen deleted successfully.');
    }

    public function exportWithDistributions(CitizensAndDistributionExportService $exportService)
{
    return $exportService->export();
}

public function exportImportReport(Request $request)
{
    if (!session()->has('import_result')) {
        return redirect()->route('citizens.import')
            ->with('error', 'لا يوجد تقرير استيراد متاح للتصدير. الرجاء قم بعملية الاستيراد أولاً.');
    }

    try {
        $importResult = session('import_result');
        $timestamp = now()->format('Y-m-d_H-i-s');
        $fileName = "تقرير_استيراد_المواطنين_{$timestamp}.xlsx";
        
        return Excel::download(
            new ImportReportExport($importResult),
            $fileName
        );
    } catch (\Exception $e) {
        Log::error('Error exporting import report:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->route('citizens.import')
            ->with('error', 'حدث خطأ أثناء تصدير التقرير. الرجاء المحاولة مرة أخرى.');
    }
}

public function exportSelectedCitizens(Request $request)
{
    $request->validate([
        'citizen_ids' => 'required|string'
    ]);

    // Split and clean the IDs
    $citizenIds = collect(explode("\n", $request->citizen_ids))
        ->map(fn($id) => trim($id))
        ->filter()
        ->unique()
        ->values();

    $citizens = Citizen::whereIn('id', $citizenIds)
        ->with('region')
        ->get();

    $timestamp = now()->format('Y-m-d_H-i-s');
    return Excel::download(new CitizensExport($citizens), "citizens_export_{$timestamp}.xlsx");
}

public function checkCitizens(Request $request)
{
    $request->validate([
        'citizen_ids' => 'required|string'
    ]);

    // Store the IDs in session for export functionality
    $rawIds = $request->citizen_ids;
    session(['last_checked_ids' => $rawIds]);

    // Split and clean the IDs
    $allIds = collect(explode("\n", $request->citizen_ids))
        ->map(fn($id) => trim($id))
        ->filter()
        ->unique()
        ->values();

    // Get all existing citizens regardless of ID validity
    $existingCitizens = Citizen::with([
        'distributions' => function($query) {
            $query->select('distributions.*', 'distribution_citizens.done')
                ->withPivot('done');
        },
        'region'
    ])
    ->whereIn('id', $allIds)
    ->get();

    // Prepare results for each ID
    $results = $allIds->map(function($id) use ($existingCitizens) {
        // Check ID validity
        $isValid = false;
        if (strlen($id) === 9 && preg_match('/^\d{9}$/', $id)) {
            $sum = 0;
            for ($i = 0; $i < 8; $i++) {
                $digit = intval($id[$i]);
                if ($i % 2 === 0) {
                    $sum += $digit;
                } else {
                    $doubled = $digit * 2;
                    $sum += $doubled > 9 ? $doubled - 9 : $doubled;
                }
            }
            $checkDigit = (10 - ($sum % 10)) % 10;
            $isValid = $checkDigit === intval($id[8]);
        }

        $citizen = $existingCitizens->firstWhere('id', $id);
        $exists = $citizen !== null;

        if (!$exists) {
            return [
                'id' => $id,
                'exists' => false,
                'is_valid' => $isValid,
                'name' => 'غير موجود في النظام',
                'region' => '-',
                'total_distributions' => 0,
                'completed_distributions' => 0,
                'family_members' => 0,
                'status_text' => $isValid ? 'غير موجود' : 'رقم هوية غير صالح وغير موجود'
            ];
        }

        return [
            'id' => $id,
            'exists' => true,
            'is_valid' => $isValid,
            'name' => $citizen->firstname . ' ' . $citizen->secondname . ' ' . $citizen->thirdname . ' ' . $citizen->lastname,
            'region' => $citizen->region ? $citizen->region->name : 'غير محدد',
            'total_distributions' => $citizen->distributions->count(),
            'completed_distributions' => $citizen->distributions->where('pivot.done', 1)->count(),
            'family_members' => $citizen->family_members,
            'status_text' => $isValid ? 'موجود' : 'رقم هوية غير صالح ولكن موجود'
        ];
    })->toArray();

    return redirect()->back()->with('check_results', $results);
}
}
