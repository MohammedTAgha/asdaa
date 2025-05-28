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
    public function validatePalestinianId(string $id): array
    {
        if (!preg_match('/^\d{9}$/', $id)) {
            return [
                'is_valid' => false,
                'message' => 'رقم الهوية غير صالح',
                'details' => [
                    [
                        'message' => 'رقم الهوية يجب أن يتكون من 9 أرقام',
                        'id' => $id
                    ]
                ]
            ];
        }

        $sum = 0;
        for ($i = 0; $i < 8; $i++) {
            $digit = intval($id[$i]);
            if ($i % 2 === 0) {
                $sum += $digit;
            } else {
                $doubled = $digit * 2;
                $sum += $doubled > 9 ? $doubled - 9 : $doubled;
            }
        }
        $checkDigit = (10 - ($sum % 10)) % 10;
        
        if ($checkDigit !== intval($id[8])) {
            return [
                'is_valid' => false,
                'message' => 'رقم الهوية غير صالح',
                'details' => [
                    [
                        'message' => 'رقم التحقق غير صحيح',
                        'id' => $id,
                        'expected' => $checkDigit,
                        'actual' => $id[8]
                    ]
                ]
            ];
        }

        return ['is_valid' => true];
    }

    /**
     * Validate if the count of family members matches the family_members attribute
     */
    public function validateFamilyMembersCount(Citizen $citizen): array
    {
        $actualCount = $citizen->familyMembers()->count();
        $expectedCount = $citizen->family_members;

        if ($actualCount !== $expectedCount) {
            return [
                'is_valid' => false,
                'message' => 'عدد أفراد العائلة غير متطابق',
                'details' => [
                    [
                        'message' => 'عدد أفراد العائلة المسجلين لا يتطابق مع العدد الفعلي',
                        'expected' => $expectedCount,
                        'actual' => $actualCount
                    ]
                ]
            ];
        }

        return ['is_valid' => true];
    }

    /**
     * Validate if the citizen ID is associated with a family member
     */
    public function validateCitizenIdAssociation(Citizen $citizen): array
    {
        $exists = FamilyMember::where('national_id', $citizen->id)->exists();
        
        if (!$exists) {
            return [
                'is_valid' => false,
                'message' => 'رقم هوية المواطن غير مرتبط بأي فرد من العائلة',
                'details' => [
                    [
                        'message' => 'رقم الهوية غير موجود في سجلات أفراد العائلة',
                        'id' => $citizen->id
                    ]
                ]
            ];
        }

        return ['is_valid' => true];
    }

    /**
     * Validate if the wife_id is linked to a family member
     */
    public function validateWifeIdAssociation(Citizen $citizen): array
    {
        if (!$citizen->wife_id) {
            return ['is_valid' => true];
        }

        $exists = FamilyMember::where('national_id', $citizen->wife_id)->exists();
        
        if (!$exists) {
            return [
                'is_valid' => false,
                'message' => 'رقم هوية الزوجة غير مرتبط بأي فرد من العائلة',
                'details' => [
                    [
                        'message' => 'رقم هوية الزوجة غير موجود في سجلات أفراد العائلة',
                        'id' => $citizen->wife_id
                    ]
                ]
            ];
        }

        return ['is_valid' => true];
    }

    /**
     * Validate if the wife_id matches the mother's national_id
     */
    public function validateWifeIdMatchesMother(Citizen $citizen): array
    {
        if (!$citizen->wife_id) {
            return ['is_valid' => true];
        }

        $mother = $citizen->familyMembers()
            ->where('relationship', 'mother')
            ->where('national_id', $citizen->wife_id)
            ->first();

        if (!$mother) {
            return [
                'is_valid' => false,
                'message' => 'رقم هوية الزوجة لا يتطابق مع رقم هوية الأم',
                'details' => [
                    [
                        'message' => 'رقم هوية الزوجة غير مطابق لرقم هوية الأم المسجلة',
                        'id' => $citizen->wife_id
                    ]
                ]
            ];
        }

        return ['is_valid' => true];
    }

    /**
     * Run all validations and return results
     */
    public function validateCitizen(Citizen $citizen): array
    {
        $validations = [
            'id' => $this->validatePalestinianId($citizen->id),
            'family_members_count' => $this->validateFamilyMembersCount($citizen),
            'citizen_id_association' => $this->validateCitizenIdAssociation($citizen),
            'wife_id_association' => $this->validateWifeIdAssociation($citizen),
            'wife_id_matches_mother' => $this->validateWifeIdMatchesMother($citizen)
        ];

        $isValid = collect($validations)->every(fn($v) => $v['is_valid']);
        
        return [
            'is_valid' => $isValid,
            'validations' => $validations
        ];
    }

    /**
     * Get detailed validation results with explanations in Arabic
     */
    public function getDetailedValidationResults(Citizen $citizen): array
    {
        $validation = $this->validateCitizen($citizen);
        $details = [];

        foreach ($validation['validations'] as $key => $result) {
            if (!$result['is_valid']) {
                switch ($key) {
                    case 'id':
                        $details[] = [
                            'message' => 'رقم هوية المواطن غير صالح',
                            'id' => $citizen->id,
                            'type' => 'citizen_id',
                            'details' => $result['details'][0] ?? null
                        ];
                        break;

                    case 'family_members_count':
                        $details[] = [
                            'message' => 'عدد أفراد العائلة غير متطابق',
                            'expected' => $citizen->family_members,
                            'actual' => $citizen->familyMembers()->count(),
                            'type' => 'family_count'
                        ];
                        break;

                    case 'citizen_id_association':
                        $details[] = [
                            'message' => 'رقم هوية المواطن غير مرتبط بأي فرد من العائلة',
                            'id' => $citizen->id,
                            'type' => 'citizen_association'
                        ];
                        break;

                    case 'wife_id_association':
                        if ($citizen->wife_id) {
                            $details[] = [
                                'message' => 'رقم هوية الزوجة غير مرتبط بأي فرد من العائلة',
                                'id' => $citizen->wife_id,
                                'type' => 'wife_association'
                            ];
                        }
                        break;

                    case 'wife_id_matches_mother':
                        if ($citizen->wife_id) {
                            $details[] = [
                                'message' => 'رقم هوية الزوجة لا يتطابق مع رقم هوية الأم',
                                'id' => $citizen->wife_id,
                                'type' => 'wife_mother_match'
                            ];
                        }
                        break;
                }
            }
        }

        return [
            'is_valid' => $validation['is_valid'],
            'details' => $details,
            'citizen_id' => $citizen->id,
            'wife_id' => $citizen->wife_id
        ];
    }
} 