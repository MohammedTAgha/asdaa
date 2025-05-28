<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\FamilyMember;
use App\Models\Records\Person;
use App\Models\Records\Relation;
use App\Models\Region;
use App\Services\FamilyMemberService;
use App\Services\FamilyMemberFilterService;
use App\Services\AutomaticFamilyAssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FamilyMembersImport;
use App\Exports\FamilyMembersTemplateExport;
use App\Exports\FamilyAssignmentFailuresExport;
use App\Models\Category;

class FamilyMemberController extends Controller
{
    protected $familyMemberService;
    protected $familyMemberFilterService;
    protected $automaticFamilyAssignmentService;

    public function __construct(
        FamilyMemberService $familyMemberService,
        FamilyMemberFilterService $familyMemberFilterService,
        AutomaticFamilyAssignmentService $automaticFamilyAssignmentService
    ) {
        $this->familyMemberService = $familyMemberService;
        $this->familyMemberFilterService = $familyMemberFilterService;
        $this->automaticFamilyAssignmentService = $automaticFamilyAssignmentService;
    }

    public function index(Request $request)
    {
        // $test = $this->familyMemberService->
        $filters = $request->only([
            'relationship',
            'gender',
            'min_age',
            'max_age',
            'region_id'
        ]);

        $regions = Region::all();
        $members = $this->familyMemberFilterService->getFilteredMembers($filters);

        if ($request->has('export')) {
            return $this->familyMemberFilterService->export($filters);
        }

        return view('family-members.index', compact('members', 'regions', 'filters'));
    }

    public function create(Citizen $citizen)
    {
        try {
            $parents = $this->familyMemberService->getParents($citizen);
            $children = $this->familyMemberService->getChildren($citizen);

            return view('family-members.create', compact('citizen', 'parents', 'children'));
        } catch (Exception $e) {
            return redirect()
                ->route('citizens.show', $citizen)
                ->with('error', $e->getMessage());
        }
    }

    public function searchRecords(Request $request, Citizen $citizen)
    {
        try {
            $request->validate([
                'search_id' => 'required|string'
            ]);

            // Get the person from Records database
            $person = Person::where('CI_ID_NUM', $request->search_id)->first();
            
            if (!$person) {
                return redirect()->back()->with('error', 'لم يتم العثور على الشخص في السجل المدني');
            }

            // Get relatives from Records database
            $relatives = Relation::with(['relative' => function($query) {
                $query->select('CI_ID_NUM', 'CI_FIRST_ARB', 'CI_FATHER_ARB', 'CI_GRAND_FATHER_ARB', 'CI_FAMILY_ARB','age','full_name','CI_PERSONAL_CD','CI_BIRTH_DT');
            }])->where('CF_ID_NUM', $request->search_id)->get();

            $records_relatives = $relatives->map(function($relation) {
                return [
                    'relative' => $relation->relative,
                    'relation_type' => $relation->relation_name,
                    'relation_code' => $relation->CF_RELATIVE_CD
                ];
            });

            // Prepend the main citizen (father) to the relatives list
            $father = [
                'relative' => $person,
                'relation_type' => 'زوج',
                'relation_code' => null,
                'is_father' => true,
            ];
            $records_relatives = collect([$father])->concat($records_relatives);
            Log::alert('Records relatives', [
                'records_relatives' => $records_relatives
            ]);
            $parents = $this->familyMemberService->getParents($citizen);
            $children = $this->familyMemberService->getChildren($citizen);

            return view('family-members.create', compact('citizen', 'parents', 'children', 'records_relatives'));
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء البحث في السجل المدني: ' . $e->getMessage());
        }
    }

    public function importRecords(Request $request, Citizen $citizen)
    {
        try {
            $request->validate([
                'selected_relatives' => 'required|array',
                'selected_relatives.*' => 'required|string',
                'relationships' => 'required|array',
                'relationships.*' => 'required|in:father,mother,son,daughter,other'
            ]);
            Log::alert('reeq', [
                'selected_relatives' => $request->all(),
                
            ]);
            $imported = 0;
            $errors = [];

            foreach ($request->selected_relatives as $relativeId) {
                //for each select id of reletive list its adds the one 
                try {
                    $person = Person::where('CI_ID_NUM', $relativeId)->first();
                    
                    if (!$person) {
                        $errors[] = "لم يتم العثور على الشخص برقم الهوية: $relativeId";
                        continue;
                    }

                    $dateOfBirth = $person->CI_BIRTH_DT;
                    $parsedDate = null;
                    if ($dateOfBirth) {
                        try {
                            $parsedDate = Carbon::createFromFormat('d/m/Y', $dateOfBirth)->format('Y-m-d');
                        } catch (\Exception $e) {
                            Log::warning('Failed to parse date_of_birth', [
                                'input' => $dateOfBirth,
                                'error' => $e->getMessage(),
                                'relative_id' => $relativeId
                            ]);
                        }
                    }

                    $memberData = [
                        'firstname' => $person->CI_FIRST_ARB,
                        'secondname' => $person->CI_FATHER_ARB,
                        'thirdname' => $person->CI_GRAND_FATHER_ARB,
                        'lastname' => $person->CI_FAMILY_ARB,
                        'national_id' => $person->CI_ID_NUM,
                        'date_of_birth' => $parsedDate,
                        'gender' => $person->CI_SEX_CD === 'ذكر' ? 'male' : 'female',
                        'relationship' => $request->relationships[$relativeId],
                    ];

                    $this->familyMemberService->addMember($memberData, $citizen);
                    Log::info('Imported family member', [
                        'citizen_id' => $citizen->id,
                        'relative_id' => $relativeId,
                        'data' => $memberData
                    ]);
                    $imported++;
                } catch (Exception $e) {
                    $errors[] = "فشل إضافة الفرد برقم الهوية $relativeId: " . $e->getMessage();
                    continue;
                }
            }

            $message = "تم إضافة $imported من أفراد العائلة بنجاح";
            if (!empty($errors)) {
                $message .= "\nالأخطاء:\n" . implode("\n", $errors);
            }

            return redirect()
                ->route('citizens.show', $citizen)
                ->with('success', $message)
                ->with('errors', $errors);

        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء استيراد أفراد العائلة: ' . $e->getMessage());
        }
    }

    public function importForm()
    {
        return view('family-members.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            $import = new FamilyMembersImport($this->familyMemberService);
            Excel::import($import, $request->file('file'));

            $report = $import->getReport();
              return view('family-members.import-report', [
                'successes' => $report['successes'],
                'failures' => $report['failures'],
                'successRows' => $report['successRows']
            ]);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء استيراد الملف: ' . $e->getMessage());
        }
    }

    public function store(Request $request, Citizen $citizen)
    {
        try {
            $validated = $request->validate([
                'firstname' => 'required|string|max:255',
                'secondname' => 'required|string|max:255',
                'thirdname' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:male,female',
                'relationship' => 'required|in:father,mother,son,daughter',
                'national_id' => 'required|string|unique:family_members,national_id',
                'notes' => 'nullable|string',
            ]);

            $this->familyMemberService->addMember($validated, $citizen);

            return redirect()
                ->route('citizens.show', $citizen)
                ->with('success', 'تم إضافة الفرد بنجاح');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء إضافة الفرد: ' . $e->getMessage());
        }
    }

    public function edit(Citizen $citizen, FamilyMember $member)
    {
        try {
            return view('family-members.edit', compact('citizen', 'member'));
        } catch (Exception $e) {
            return redirect()
                ->route('citizens.show', $citizen)
                ->with('error', 'حدث خطأ أثناء تحميل صفحة التعديل: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Citizen $citizen, FamilyMember $member)
    {
        try {
            $validated = $request->validate([
                'firstname' => 'required|string|max:255',
                'secondname' => 'required|string|max:255',
                'thirdname' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:male,female',
                'relationship' => 'required|in:father,mother,son,daughter',
                'national_id' => 'required|string|unique:family_members,national_id,' . $member->id,
                'notes' => 'nullable|string',
            ]);

            $this->familyMemberService->updateMember($member, $validated);

            return redirect()
                ->route('citizens.show', $citizen)
                ->with('success', 'تم تحديث بيانات الفرد بنجاح');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث بيانات الفرد: ' . $e->getMessage());
        }
    }

    public function destroy(Citizen $citizen, FamilyMember $member)
    {
        try {
            $this->familyMemberService->deleteMember($member);

            return redirect()
                ->route('citizens.show', $citizen)
                ->with('success', 'تم حذف الفرد بنجاح');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء حذف الفرد: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new FamilyMembersTemplateExport, 'family-members-template.xlsx');
    }

    public function showAutomaticAssignmentForm()
    {
        $regions=Region::all();
        return view('family-members.automatic-assignment',compact('regions'));
    }

    public function processAutomaticAssignment()
    {
        try {
            $results = $this->automaticFamilyAssignmentService->processAllCitizens();
            
            // // Generate failures report if there are any failures
            // $failures = $this->automaticFamilyAssignmentService->getFailures();
            // if (!empty($failures)) {                $export = new FamilyAssignmentFailuresExport($failures);
            //     $fileName = 'family_assignment_failures_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
                
            //     // Make sure the directory exists
            //     $storagePath = storage_path('app/public/reports');
            //     if (!file_exists($storagePath)) {
            //         mkdir($storagePath, 0755, true);
            //     }
                
            //     // Store the file
            //     Excel::store($export, 'reports/' . $fileName, 'public');
                
            //     // Generate the correct public URL
            //     $results['failure_report_url'] = url('storage/reports/' . $fileName);
            // }

            return view('family-members.automatic-assignment-report', [
                'results' => $results,
                'failures' => $failures
            ]);
        } catch (Exception $e) {
            return redirect()
                ->route('family-members.index')
                ->with('error', 'حدث خطأ أثناء المعالجة التلقائية لأفراد العائلة: ' . $e->getMessage());
        }
    }

    public function processAutomaticAssignmentForCitizen(Request $request )
    {
          $request->validate([
            'id' => 'nullable|exists:citizens,id',
        ]);
        if ($request->has('id')){
            $citizen = Citizen::find($request->id);
        }
         
        // dd($citizen);
        try {
            $results = $this->automaticFamilyAssignmentService->assignFamilyMembers($citizen);
            
            $message = sprintf(
                'تمت المعالجة التلقائية: تم إضافة %d أب و %d أم',
                $results['father_added'],
                $results['mother_added']
            );

            if (!empty($results['error'])) {
                $message .= "\nحدث خطأ: " . $results['error'];
            }

            if (!empty($results['skipped'])) {
                $message .= "\nتم تخطي: " . $results['skipped'];
            }
        //         return view('family-members.automatic-assignment-report', [
        //         'results' => $results,                
        // ]);
            return redirect()
                ->route('citizens.show', $citizen)
                ->with('success', $message);
        } catch (Exception $e) {
            return redirect()
                ->route('citizens.show', $citizen)
                ->with('error', 'حدث خطأ أثناء المعالجة التلقائية لأفراد العائلة: ' . $e->getMessage());
        }
    }

    public function addChildren(Request $request, Citizen $citizen)
    {
        try {
            $filters = $request->validate([
                'min_age' => 'nullable|integer|min:0',
                'max_age' => 'nullable|integer|min:0',
                'social_status' => 'nullable|string',
                'gender' => 'nullable|in:male,female'
            ]);

            $result = $this->familyMemberService->addChildrenAsMembers($citizen, $filters);

            $message = "تم إضافة {$result['added']} من الأبناء بنجاح";
            if (!empty($result['errors'])) {
                $message .= "\nالأخطاء:\n" . implode("\n", $result['errors']);
            }

             return view('family-members.automatic-assignment-report', [
                'results' => $result,
                'failures' => []
            ]);
            // return redirect()
            //     ->route('citizens.show', $citizen)
            //     ->with('success', $message)
            //     ->with('errors', $result['errors']);

        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء إضافة الأبناء: ' . $e->getMessage());
        }
    }

    public function processAutomaticAssignmentWithChildren(Request $request)
    {
        try {
            $filters = $request->validate([
                'min_age' => 'nullable|integer|min:0',
                'max_age' => 'nullable|integer|min:0',
                'social_status' => 'nullable|string',
                'gender' => 'nullable|in:male,female',
                'region_id' => 'nullable|exists:regions,id'
            ]);

            $results = $this->automaticFamilyAssignmentService->processAllCitizensWithChildren(
                $filters,
                $request->region_id
            );
            
            // Generate failures report if there are any failures
            $failures = $this->automaticFamilyAssignmentService->getFailures();
            if (!empty($failures)) {                $export = new FamilyAssignmentFailuresExport($failures);
                $fileName = 'family_assignment_failures_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
                
                // Make sure the directory exists
                $storagePath = storage_path('app/public/reports');
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0755, true);
                }
                
                // Store the file
                Excel::store($export, 'reports/' . $fileName, 'public');
                
                // Generate the correct public URL
                $results['failure_report_url'] = url('storage/reports/' . $fileName);
            }
            $message = sprintf(
                'تمت المعالجة التلقائية: تم إضافة %d أب و %d أم و %d ابن',
                $results['father_added'],
                $results['mother_added'],
                $results['children_added']
            );

            if (!empty($results['errors'])) {
                $message .= "\nالأخطاء:\n" . implode("\n", $results['errors']);
            }
 return view('family-members.automatic-assignment-report', [
                'results' => $results,
                'failures' => []
            ]);
            // return redirect()
            //     ->route('family-members.index')
            //     ->with('success', $message);

        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ أثناء المعالجة التلقائية: ' . $e->getMessage());
        }
    }

    public function show(FamilyMember $member)
    {
        $categories = Category::where('status', 'active')->get();
        return view('family-members.show', compact('member', 'categories'));
    }

    public function test()
    {
        $results = $this->familyMemberService->findCitizensWithoutFamilyMembers();
        return view('family-members.test', compact('results'));
    }
}