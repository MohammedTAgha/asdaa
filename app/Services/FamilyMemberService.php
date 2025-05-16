<?php

namespace App\Services;

use App\Models\FamilyMember;
use App\Models\Citizen;

class FamilyMemberService
{
    public function getParents(Citizen $citizen)
    {
        return $citizen->familyMembers()
            ->whereIn('relationship', ['father', 'mother'])
            ->get();
    }

    public function getChildren(Citizen $citizen)
    {
        return $citizen->familyMembers()
            ->whereIn('relationship', ['son', 'daughter'])
            ->orderBy('date_of_birth')
            ->get();
    }

    public function addMember(array $data, Citizen $citizen)
    {
        return $citizen->familyMembers()->create([
            'firstname' => $data['firstname'],
            'secondname' => $data['secondname'],
            'thirdname' => $data['thirdname'],
            'lastname' => $data['lastname'],
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'relationship' => $data['relationship'],
            'national_id' => $data['national_id'],
            'notes' => $data['notes'] ?? null,
        ]);
    }

    public function updateMember(FamilyMember $member, array $data)
    {
        $member->update($data);
        return $member;
    }

    public function deleteMember(FamilyMember $member)
    {
        return $member->delete();
    }
} 