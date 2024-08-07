<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Distribution;
use App\Imports\CitizensImport;
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
        $request->validate([
            'distribution_id' => 'required|exists:distributions,id',
            'citizens_file' => 'required|file|mimes:xlsx,xls',
        ]);

        $distributionId = $request->input('distribution_id');
        $file = $request->file('citizens_file');

        try {
            $citizensData = Excel::toCollection(new CitizensImport, $file)->first();

            DB::beginTransaction();

            $existingInDistribution = DB::table("distribution_citizens")
                ->where("distribution_id", $distributionId)
                ->pluck("citizen_id")
                ->toArray();

            $existingCitizens = DB::table("citizens")
                ->pluck("id")
                ->toArray();

            $added = 0;
            $uploaded = 0;
            // $addedCount = 0;
            $addedCitizensIds = [];
            $updatedCitizensIds = [];

            $addedCitizens = [];
            $updatedCitizens = [];
            $nonExistentCitizensId= [];
            $nonexistent = 0;
          
            foreach ($citizensData as $row) {
                $citizenId = $row['id'] ?? null;

                if (!$citizenId || !in_array($citizenId, $existingCitizens)) {
                    $nonexistent++;
                    if ($citizenId){
                        $nonExistentCitizensId[] =$row;
                    }
                    continue;
                }

                $pivotData = [
                    'distribution_id' => $distributionId,
                    'citizen_id' => $citizenId,
                    'quantity' => $row['quantity'] ?? null,
                    'recipient' => $row['recipient'] ?? null,
                    'note' => $row['note'] ?? null,
                    'done' => isset($row['done']) ? filter_var($row['done'], FILTER_VALIDATE_BOOLEAN) : false,
                    'date' => isset($row['date']) ? Carbon::parse($row['date'])->format('Y-m-d') : null,
                ];

                if (in_array($citizenId, $existingInDistribution)) {
                    DB::table("distribution_citizens")
                        ->where("distribution_id", $distributionId)
                        ->where("citizen_id", $citizenId)
                        ->update($pivotData);
                        $uploaded++;   
                    $updatedCitizens[]=$citizenId;
                } else {
                    DB::table("distribution_citizens")->insert($pivotData);
                    $addedCitizens[]=$pivotData;
                }
            }

            DB::commit();

            // $report = [
            //     'added' => $added,
            //     'updated' => $updated,
            //     // 'nonexistent' => $nonexistent,
            //     'nonexistent' => [
            //         'count' => count($nonExistentCitizensId),
            //         'citizens' => $nonExistentCitizensId // This will be an array of IDs
            //     ],
            // ];
            $report = [
                'added' => [
                    'count' => count($addedCitizens),
                    'citizens' => $addedCitizens
                ],
                'existing' => [
                    'count' => $uploaded,
                    'citizens' =>$updatedCitizens
                ],
                'nonexistent' => [
                    'count' => count($nonExistentCitizensId),
                    'citizens' => $nonExistentCitizensId // This will be an array of IDs
                ],
                // 'totalIds' => $totalIds

            ];
            dd( $report);
            $reportHtml = view('modals.addctz2dist', ['report' => $report])->render();    

            return redirect()->back()->with('status', [
                'type' => 'success',
                'message' => "تم رفع الملف بنجاح. تمت إضافة {$report['added']['count']} مواطن، تم تحديث {$report['existing']['count']} مواطن، و {$report['nonexistent']['count']} غير موجود."
            ])
            ->with('success', 'تمت العملية بنجاح. يرجى مراجعة التقرير للتفاصيل.')
            ->with('addCitizensReportHtml', $reportHtml);;

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', [
                'type' => 'danger',
                'message' => 'حدث خطأ أثناء معالجة الملف: ' . $e->getMessage()
            ]);
        }
    }
}