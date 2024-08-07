<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Distribution;
use App\Imports\CitizensImport;
use App\Models\Citizen;
use Carbon\Carbon;

class CitizenUploadController extends Controller
{
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
                    DB::table("distribution_citizens")
                        ->where("distribution_id", $distributionId)
                        ->where("citizen_id", $citizenId)
                        ->update($pivotData);
                    $updated++;
                    $updatedCitizens[] = $citizenId;
                } else {
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
    
            DB::commit();
    
            // Prepare a report with data about added, updated, and nonexistent citizens
            $report = [
                'added' => [
                    'count' => $added,
                    'citizens' => $addedCitizenData
                ],
                'updated' => [
                    'count' => $updated,
                    'citizens' => $existingCitizenData
                ],
                'nonexistent' => [
                    'count' => count($nonexistentCitizens),
                    'citizens' => $nonexistentCitizens
                ]
            ];
            dd( $report);
            // Render the report into an HTML view
            $reportHtml = view('modals.addctz2dist', ['report' => $report])->render();
    
            // Redirect back with a success message and the report
            return redirect()->back()
                ->with('success', 'تم رفع الملف بنجاح. يرجى مراجعة التقرير للتفاصيل.')
                ->with('addCitizensReportHtml', $reportHtml);
    
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle any exceptions by rolling back the transaction and showing an error message
            return redirect()->back()->with('danger', 'حدث خطأ أثناء معالجة الملف: ' . $e->getMessage());
        }
    }
}