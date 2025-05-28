<?php

namespace App\Services;

use App\Models\Citizen;
use App\Models\FamilyMember;
use Illuminate\Support\Collection;

class CitizenValidationService
{
    /**
     * Validate a Palestinian ID number using the Luhn algorithm
     */
    public function validatePalestinianId(string $id): bool
    {
        if (!preg_match('/^\d{9}$/', $id)) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 8; $i++) {
            $digit = (int) $id[$i];
            if ($i % 2 === 0) {
                $sum += $digit;
            } else {
                $doubled = $digit * 2;
                $sum += $doubled > 9 ? $doubled - 9 : $doubled;
            }
        }

        $checkDigit = (10 - ($sum % 10)) % 10;
        return $checkDigit === (int) $id[8];
    }

    /**
     * Check if the family members count matches the actual count
     */
    public function validateFamilyMembersCount(Citizen $citizen): bool
    {
        $actualCount = $citizen->familyMembers()->count();
        return $actualCount === $citizen->family_members;
    }

    /**
     * Check if the citizen ID is associated with a family member
     */
    public function validateCitizenIdAssociation(Citizen $citizen): bool
    {
        return FamilyMember::where('national_id', $citizen->id)->exists();
    }

    /**
     * Check if the wife_id is linked to a family member
     */
    public function validateWifeIdAssociation(Citizen $citizen): bool
    {
        if (!$citizen->wife_id || $citizen->wife_id === '0') {
            return true; // No wife ID is valid
        }

        return FamilyMember::where('national_id', $citizen->wife_id)->exists();
    }

    /**
     * Check if the wife_id matches the mother's national_id
     */
    public function validateWifeIdMatchesMother(Citizen $citizen): bool
    {
        if (!$citizen->wife_id || $citizen->wife_id === '0') {
            return true; // No wife ID is valid
        }

        $mother = $citizen->mother;
        if (!$mother) {
            return false; // No mother found
        }

        return $mother->national_id === $citizen->wife_id;
    }

    /**
     * Run all validations on a citizen
     */
    public function validateCitizen(Citizen $citizen): array
    {
        return [
            'id_valid' => $this->validatePalestinianId($citizen->id),
            'wife_id_valid' => $this->validatePalestinianId($citizen->wife_id),
            'family_members_count_valid' => $this->validateFamilyMembersCount($citizen),
            'citizen_id_associated' => $this->validateCitizenIdAssociation($citizen),
            'wife_id_associated' => $this->validateWifeIdAssociation($citizen),
            'wife_id_matches_mother' => $this->validateWifeIdMatchesMother($citizen)
        ];
    }

    /**
     * Get detailed validation results with explanations
     */
    public function getDetailedValidationResults(Citizen $citizen): array
    {
        $results = $this->validateCitizen($citizen);
        $details = [];

        if (!$results['id_valid']) {
            $details[] = 'رقم الهوية غير صالح';
        }

        if ($citizen->wife_id && $citizen->wife_id !== '0' && !$results['wife_id_valid']) {
            $details[] = 'رقم هوية الزوجة غير صالح';
        }

        if (!$results['family_members_count_valid']) {
            $details[] = 'عدد أفراد العائلة المسجل لا يتطابق مع العدد الفعلي';
        }

        if (!$results['citizen_id_associated']) {
            $details[] = 'رقم الهوية غير مرتبط بأي فرد من أفراد العائلة';
        }

        if ($citizen->wife_id && $citizen->wife_id !== '0' && !$results['wife_id_associated']) {
            $details[] = 'رقم هوية الزوجة غير مرتبط بأي فرد من أفراد العائلة';
        }

        if ($citizen->wife_id && $citizen->wife_id !== '0' && !$results['wife_id_matches_mother']) {
            $details[] = 'رقم هوية الزوجة لا يتطابق مع رقم هوية الأم';
        }

        return [
            'is_valid' => empty($details),
            'details' => $details,
            'raw_results' => $results
        ];
    }
} 