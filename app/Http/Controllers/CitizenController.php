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

class CitizenController extends Controller
{
    protected $citizenService;

    public function __construct(CitizenService $citizenService)
    {
        $this->citizenService = $citizenService;
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
        Log::error("--------------:", ["--------------" => "--------------"]);
        $request->validate([
            'regionId'=>'nullable',
            'excel_file' => 'required|mimes:xlsx,xls,csv',
        ]);
        $region=null;
        if ($request->has('regionId')) {
            $region=$request->regionId;
            Log::info('$region is zero ?');
            Log::info($region);
        }
        Log::info('$region');
        Log::error($region );
        Log::error($request);
        $file = $request->file('excel_file');
        $import = new CitizensImport($region);
        Log::error($file);
        try {
            $initialCount = Citizen::count(); // Count before import
            Excel::import($import, $file);
            $finalCount = Citizen::count(); // Count after import
            $addedCount = $finalCount - $initialCount; // Calculate actually added rows
            Log::error("success:", ["-->>" => 'ok']);
        } catch (ValidationException $e) {
            Log::error("catch error:", ["-->>" => $e->failures()]);
            return back()->withErrors($e->failures());
        }

        $failedRows = $import->failedRows;

        // Generate Excel file with failed rows
        $failedExcelPath = null;
        if (!empty($failedRows)) {
            Log::error("data fails:", ["-->>" => 'xxxx']);
            $failedExcelPath = 'failed_citizens_' . time() . '.xlsx';
            Excel::store(new FailedRowsExport($failedRows), $failedExcelPath, 'public');
        }

        $result = [
            'message' => 'Import completed',
            'addedCount' => $addedCount,
            'failedCount' => count($import->failedRows),
            'failedRows' => $import->failedRows,
            'failedExcelPath' => $failedExcelPath ? Storage::url($failedExcelPath) : null,
        ];
        // Flash the result data to the session
        session()->flash('import_result', $result);

        // Redirect to the index page
        return redirect()->route('citizens.index');
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
}
