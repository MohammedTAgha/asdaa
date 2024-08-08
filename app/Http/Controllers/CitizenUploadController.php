<?php

namespace App\Http\Controllers;

use App\Exports\CitizensdDistReportExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Distribution;
use App\Imports\CitizensImport;
use App\Models\Citizen;
use Carbon\Carbon;

class CitizenUploadController extends Controller // upload to a distributin exel 
{
    // protected $report;

    // public function __construct()
    // {
    //     $this->report = $this->generateReport(); // Or set it later
    // }
    
    public function showUploadForm()
    {
        $distributions = Distribution::all();
        return view('common.upload_citizens', compact('distributions'));
    }

    public function uploadCitizens(Request $request)
    {
        // Validate the request to ensure required fields are provided
        $request->validate([
            'distribution_id' => 'required|exists:distributions,id',
            'citizens_file' => 'required|file|mimes:xlsx,xls',
        ]);
    
        $distributionId = $request->input('distribution_id');
        $file = $request->file('citizens_file');
    
        try {
            // Read the uploaded Excel file and get the first collection of data
            $citizensData = Excel::toCollection(new CitizensImport, $file)->first();
    
            DB::beginTransaction();
    
            // Get existing citizen IDs already linked to the distribution
            $existingInDistribution = DB::table("distribution_citizens")
                ->where("distribution_id", $distributionId)
                ->pluck("citizen_id")
                ->toArray();
    
            // Get all existing citizen IDs from the citizens table
            $existingCitizens = Citizen::pluck("id")->toArray();
    
            // Initialize counters and arrays for report
            $added = 0;
            $updated = 0;
            $nonexistentCitizens = [];
            $addedCitizens = [];
            $updatedCitizens = [];
            $updatedDetails = [];
    
            // Process each row of citizen data from the file
            foreach ($citizensData as $row) {
                $citizenId = $row['id'] ?? null;
    
                // Check if the citizen exists in the database
                if (!$citizenId || !in_array($citizenId, $existingCitizens)) {
                    $nonexistentCitizens[] = $citizenId;
                    continue;
                }
    
                // Prepare data for insertion or update
                $pivotData = [
                    'distribution_id' => $distributionId,
                    'citizen_id' => $citizenId,
                    'quantity' => $row['quantity'] ?? null,
                    'recipient' => $row['recipient'] ?? null,
                    'note' => $row['note'] ?? null,
                    'done' => isset($row['done']) ? filter_var($row['done'], FILTER_VALIDATE_BOOLEAN) : false,
                    'date' => isset($row['date']) ? Carbon::parse($row['date'])->format('Y-m-d') : null,
                ];
    
                // Update if citizen is already in the distribution; otherwise, add
                if (in_array($citizenId, $existingInDistribution)) {
                    // Fetch existing details for comparison
                    $existingDetails = DB::table("distribution_citizens")
                        ->where("distribution_id", $distributionId)
                        ->where("citizen_id", $citizenId)
                        ->first();
    
                    // Update the record
                    DB::table("distribution_citizens")
                        ->where("distribution_id", $distributionId)
                        ->where("citizen_id", $citizenId)
                        ->update($pivotData);
                    $updated++;
                    $updatedCitizens[] = $citizenId;
    
                    // Track changes for the report
                    $changes = [];
                    foreach ($pivotData as $key => $value) {
                        if ($value != $existingDetails->$key) {
                            $changes[$key] = ['old' => $existingDetails->$key, 'new' => $value];
                        }
                    }
                    $updatedDetails[$citizenId] = $changes;
                } else {
                    // Insert new record
                    DB::table("distribution_citizens")->insert($pivotData);
                    $added++;
                    $addedCitizens[] = $citizenId;
                }
            }
    
            // Fetch detailed information for added citizens
            $addedCitizenData = Citizen::whereIn("id", $addedCitizens)
                ->select('id', 'firstname', 'lastname')
                ->get()
                ->toArray();
    
            // Fetch detailed information for updated citizens
            $existingCitizenData = Citizen::whereIn("id", $updatedCitizens)
                ->select('id', 'firstname', 'lastname')
                ->get()
                ->toArray();
            
                // array_diff($existingInDistribution, $updatedCitizens)
            DB::commit();
    
            // Prepare a report with data about added, updated, and nonexistent citizens
            $report = [
                'added' => [
                    'count' => $added,
                    'citizens' => $addedCitizenData
                ],
                'existing' => [
                    // 'count' => count($existingInDistribution) - $updated, // Citizens linked but not updated
                    // 'citizens' => array_diff($existingInDistribution, $updatedCitizens)
                    'count' => count($existingCitizenData), // Citizens linked but not updated
                     'citizens' => $existingCitizenData,

                ],
                'updated' => [
                    'count' => $updated,
                    'citizens' => $existingCitizenData,
                    'details' => $updatedDetails
                ],
                'nonexistent' => [
                    'count' => count($nonexistentCitizens),
                    'citizens' => $nonexistentCitizens
                ]
            ];
            $reportHtml = view('modals.addctz2dist', ['report' => $report])->render();    
            
            return redirect()->back()->with('status', [
                'type' => 'success',
                'message' => "تم رفع الملف بنجاح. تمت إضافة {$report['added']['count']} مواطن، تم تحديث {$report['updated']['count']} مواطن، و {$report['nonexistent']['count']} غير موجود."
            ])
            ->with('success', 'تمت العملية بنجاح. يرجى مراجعة التقرير للتفاصيل.')
            ->with('addCitizensReportHtml', $reportHtml);


            
     
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle any exceptions by rolling back the transaction and showing an error message
            return redirect()->back()->with('danger', 'حدث خطأ أثناء معالجة الملف: ' . $e->getMessage());
        }
    }
    public function exportReport(Request $request)
    {
        
        $report = unserialize(base64_decode($request->query('report')));
        
        return Excel::download(new CitizensdDistReportExport($report), 'citizens_report.xlsx');
    }


    }