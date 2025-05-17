<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\FamilyMember;
use App\Models\Records\Person;
use App\Models\Records\Relation;
use App\Services\FamilyMemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FamilyMemberController extends Controller
{
    protected $familyMemberService;

    public function __construct(FamilyMemberService $familyMemberService)
    {
        $this->familyMemberService = $familyMemberService;
    }

    public function create(Citizen $citizen)
    {
        $parents = $this->familyMemberService->getParents($citizen);
        $children = $this->familyMemberService->getChildren($citizen);

        return view('family-members.create', compact('citizen', 'parents', 'children'));
    }

    public function searchRecords(Request $request, Citizen $citizen)
    {
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
            $query->select('CI_ID_NUM', 'CI_FIRST_ARB', 'CI_FATHER_ARB', 'CI_GRAND_FATHER_ARB', 'CI_FAMILY_ARB');
        }])->where('CF_ID_NUM', $request->search_id)->get();

        $records_relatives = $relatives->map(function($relation) {
            return [
                'relative' => $relation->relative,
                'relation_type' => $relation->relation_name,
                'relation_code' => $relation->CF_RELATIVE_CD
            ];
        });

        $parents = $this->familyMemberService->getParents($citizen);
        $children = $this->familyMemberService->getChildren($citizen);

        return view('family-members.create', compact('citizen', 'parents', 'children', 'records_relatives'));
    }

    public function importRecords(Request $request, Citizen $citizen)
    {
        Log::info('Importing family members from records', [
            'citizen_id' => $citizen->id,
            'selected_relatives' => $request->selected_relatives,
            'relationships' => $request->relationships
        ]);

        $request->validate([
            'selected_relatives' => 'required|array',
            'selected_relatives.*' => 'required|string',
            'relationships' => 'required|array',
            'relationships.*' => 'required|in:father,mother,son,daughter,other'
        ]);

        $imported = 0;
        foreach ($request->selected_relatives as $relativeId) {
            Log::info('Processing relative', ['relative_id' => $relativeId]);
            $person = Person::where('CI_ID_NUM', $relativeId)->first();
            
            if ($person) {
                $memberData = [
                    'firstname' => $person->CI_FIRST_ARB,
                    'secondname' => $person->CI_FATHER_ARB,
                    'thirdname' => $person->CI_GRAND_FATHER_ARB,
                    'lastname' => $person->CI_FAMILY_ARB,
                    'national_id' => $person->CI_ID_NUM,
                    'date_of_birth' => $person->CI_BIRTH_DT,
                    'gender' => $person->CI_SEX_CD == 1 ? 'male' : 'female',
                    'relationship' => $request->relationships[$relativeId],
                ];
                Log::info('Prepared member data', $memberData);

                try {
                    $this->familyMemberService->addMember($memberData, $citizen);
                    $imported++;
                    Log::info('Successfully added family member', ['national_id' => $person->CI_ID_NUM]);
                } catch (\Exception $e) {
                    Log::error('Failed to add family member', [
                        'national_id' => $person->CI_ID_NUM,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    continue;
                }
            } else {
                Log::warning('Person not found in records', ['relative_id' => $relativeId]);
            }
        }

        Log::info('Import finished', ['imported_count' => $imported]);

        return redirect()
            ->route('citizens.show', $citizen)
            ->with('success', "تم إضافة $imported من أفراد العائلة بنجاح");
    }

    public function store(Request $request, Citizen $citizen)
    {
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

        $member = $this->familyMemberService->addMember($validated, $citizen);

        return redirect()
            ->route('citizens.show', $citizen)
            ->with('success', 'Family member added successfully');
    }

    public function edit(Citizen $citizen, FamilyMember $member)
    {
        return view('family-members.edit', compact('citizen', 'member'));
    }

    public function update(Request $request, Citizen $citizen, FamilyMember $member)
    {
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
            ->with('success', 'Family member updated successfully');
    }

    public function destroy(Citizen $citizen, FamilyMember $member)
    {
        $this->familyMemberService->deleteMember($member);

        return redirect()
            ->route('citizens.show', $citizen)
            ->with('success', 'Family member removed successfully');
    }
} 