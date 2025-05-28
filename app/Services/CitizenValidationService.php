<?php

namespace App\Services;

use App\Models\Citizen;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\Log;

class CitizenValidationService
{
    /**
     * Validate a Palestinian ID number using the Luhn algorithm
     */
    public function validatePalestinianId(string $id): bool
    {
        // Check if ID is exactly 9 digits
        if (!preg_match('/^\d{9}$/', $id)) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $digit = (int)$id[$i];
            if ($i % 2 === 0) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            $sum += $digit;
        }

        return $sum % 10 === 0;
    }

    /**
     * Validate if the count of family members matches the family_members attribute
     */
    public function validateFamilyMembersCount(Citizen $citizen): bool
    {
        $actualCount = $citizen->familyMembers()->count();
        return $actualCount === (int)$citizen->family_members;
    }

    /**
     * Validate if the citizen ID is associated with a family member
     */
    public function validateCitizenIdAssociation(Citizen $citizen): bool
    {
        return $citizen->familyMembers()
            ->where('national_id', $citizen->id)
            ->exists();
    }

    /**
     * Validate if the wife_id is linked to a family member
     */
    public function validateWifeIdAssociation(Citizen $citizen): bool
    {
        if (!$citizen->wife_id || $citizen->wife_id === '0') {
            return true; // No wife ID is valid
        }

        return $citizen->familyMembers()
            ->where('national_id', $citizen->wife_id)
            ->where('relationship', 'mother')
            ->exists();
    }

    /**
     * Validate if the wife_id matches the mother's national_id
     */
    public function validateWifeIdMatchesMother(Citizen $citizen): bool
    {
        if (!$citizen->wife_id || $citizen->wife_id === '0') {
            return true; // No wife ID is valid
        }

        $mother = $citizen->mother;
        if (!$mother) {
            return false;
        }

        return $mother->national_id === $citizen->wife_id;
    }

    /**
     * Run all validations and return results
     */
    public function validateCitizen(Citizen $citizen): array
    {
        $results = [
            'id_valid' => $this->validatePalestinianId($citizen->id),
            'family_members_count_valid' => $this->validateFamilyMembersCount($citizen),
            'citizen_id_associated' => $this->validateCitizenIdAssociation($citizen),
            'wife_id_associated' => $this->validateWifeIdAssociation($citizen),
            'wife_id_matches_mother' => $this->validateWifeIdMatchesMother($citizen)
        ];

        $results['is_valid'] = !in_array(false, $results, true);

        return $results;
    }

    /**
     * Get detailed validation results with explanations in Arabic
     */
    public function getDetailedValidationResults(Citizen $citizen): array
    {
        $results = $this->validateCitizen($citizen);
        $details = [];

        if (!$results['id_valid']) {
            $details[] = 'رقم الهوية غير صالح';
        }

        if (!$results['family_members_count_valid']) {
            $details[] = 'عدد أفراد العائلة لا يتطابق مع العدد المسجل';
        }

        if (!$results['citizen_id_associated']) {
            $details[] = 'رقم الهوية غير مرتبط بأي فرد من العائلة';
        }

        if (!$results['wife_id_associated']) {
            $details[] = 'رقم هوية الزوجة غير مرتبط بأي فرد من العائلة';
        }

        if (!$results['wife_id_matches_mother']) {
            $details[] = 'رقم هوية الزوجة لا يتطابق مع رقم هوية الأم';
        }

        return [
            'is_valid' => $results['is_valid'],
            'details' => $details
        ];
    }
} 