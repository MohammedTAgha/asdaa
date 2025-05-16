<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\FamilyMember;
use App\Services\FamilyMemberService;
use Illuminate\Http\Request;

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