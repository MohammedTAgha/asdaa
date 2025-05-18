<?php

namespace App\Services;

use App\Models\Citizen;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;

class AutomaticFamilyAssignmentService
{
    protected $familyMemberService;

    public function __construct(FamilyMemberService $familyMemberService)
    {
        $this->familyMemberService = $familyMemberService;
    }

    public function processAllCitizens()
    {
        $results = [
            'processed' => 0,
            'father_added' => 0,
            'mother_added' => 0,
            'errors' => [],
            'skipped' => []
        ];

        try {
            $citizens = Citizen::all();
            foreach ($citizens as $citizen) {
                $results['processed']++;
                $citizenResults = $this->assignFamilyMembers($citizen);
                
                // Aggregate results
                $results['father_added'] += $citizenResults['father_added'];
                $results['mother_added'] += $citizenResults['mother_added'];
                if (!empty($citizenResults['error'])) {
                    $results['errors'][] = [
                        'citizen_id' => $citizen->id,
                        'error' => $citizenResults['error']
                    ];
                }
                if (!empty($citizenResults['skipped'])) {
                    $results['skipped'][] = [
                        'citizen_id' => $citizen->id,
                        'reason' => $citizenResults['skipped']
                    ];
                }
            }
        } catch (Exception $e) {
            Log::error('Error in automatic family assignment', [
                'error' => $e->getMessage()
            ]);
            throw new Exception('حدث خطأ أثناء المعالجة التلقائية لأفراد العائلة');
        }

        return $results;
    }

    public function assignFamilyMembers(Citizen $citizen)
    {
        $results = [
            'father_added' => 0,
            'mother_added' => 0,
            'error' => null,
            'skipped' => null
        ];

        try {
            // Try to assign father if this is a male citizen
            if ($citizen->gender === '0') { // Male
                $fatherResult = $this->assignAsFather($citizen);
                $results['father_added'] = $fatherResult ? 1 : 0;
            }

            // Try to assign mother from wife_id if present
            if ($citizen->wife_id) {
                $motherResult = $this->assignAsMother($citizen);
                $results['mother_added'] = $motherResult ? 1 : 0;
            }

        } catch (Exception $e) {
            $results['error'] = $e->getMessage();
            Log::error('Error assigning family members', [
                'citizen_id' => $citizen->id,
                'error' => $e->getMessage()
            ]);
        }

        return $results;
    }

    protected function assignAsFather(Citizen $citizen)
    {
        // Skip if already has a father
        if ($this->familyMemberService->getParents($citizen)->where('relationship', 'father')->count() > 0) {
            return false;
        }

        try {
            $data = [
                'firstname' => $citizen->firstname,
                'secondname' => $citizen->secondname,
                'thirdname' => $citizen->thirdname,
                'lastname' => $citizen->lastname,
                'date_of_birth' => $citizen->date_of_birth,
                'gender' => '0', // Male
                'relationship' => 'father',
                'national_id' => $citizen->id,
                'notes' => 'تم إضافته تلقائياً كأب'
            ];

            $this->familyMemberService->addMember($data, $citizen);
            return true;

        } catch (Exception $e) {
            Log::error('Error assigning father', [
                'citizen_id' => $citizen->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    protected function assignAsMother(Citizen $citizen)
    {
        // Skip if already has a mother
        if ($this->familyMemberService->getParents($citizen)->where('relationship', 'mother')->count() > 0) {
            return false;
        }

        try {
            $wife = Citizen::find($citizen->wife_id);
            
            // Validate wife exists and is female
            if (!$wife || $wife->gender !== '1') { // 1 = Female
                Log::warning('Invalid wife record for mother assignment', [
                    'citizen_id' => $citizen->id,
                    'wife_id' => $citizen->wife_id
                ]);
                return false;
            }

            $data = [
                'firstname' => $wife->firstname,
                'secondname' => $wife->secondname,
                'thirdname' => $wife->thirdname,
                'lastname' => $wife->lastname,
                'date_of_birth' => $wife->date_of_birth,
                'gender' => '1', // Female
                'relationship' => 'mother',
                'national_id' => $wife->id,
                'notes' => 'تم إضافتها تلقائياً كأم'
            ];

            $this->familyMemberService->addMember($data, $citizen);
            return true;

        } catch (Exception $e) {
            Log::error('Error assigning mother', [
                'citizen_id' => $citizen->id,
                'wife_id' => $citizen->wife_id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
