<?php

namespace App\Services;

use App\Models\Citizen;
use App\Models\FamilyMember;
use App\Models\Records\Person;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class AutomaticFamilyAssignmentService
{
    protected $familyMemberService;
    protected $failures = [];

    public function __construct(FamilyMemberService $familyMemberService)
    {
        $this->familyMemberService = $familyMemberService;
    }

    public function getFailures()
    {
        return $this->failures;
    }    protected function recordFailure($citizenId, $personId, $relationship, $reason, $notes = '', $citizenGender = null, $personGender = null)
    {
        // Get the citizen's gender from Person model if not provided
        if (!$citizenGender) {
            $citizenPerson = Person::where('CI_ID_NUM', $citizenId)->first();
            $citizenGender = $citizenPerson ? $citizenPerson->CI_SEX_CD : '---';
        }

        // Get the person's gender from Person model if not provided
        if ($personId && !$personGender) {
            $person = Person::where('CI_ID_NUM', $personId)->first();
            $personGender = $person ? $person->CI_SEX_CD : '---';
        }

        $this->failures[] = [
            'citizen_id' => $citizenId,
            'citizen_gender' => $citizenGender,
            'person_id' => $personId,
            'person_gender' => $personGender,
            'relationship' => $relationship,
            'reason' => $reason,
            'notes' => $notes,
            'attempt_date' => now()->format('Y-m-d H:i:s')
        ];
    }

    public function processAllCitizens()
    {
        $this->failures = []; // Reset failures at start
        $results = [
            'processed' => 0,
            'father_added' => 0,
            'mother_added' => 0,
            'errors' => [],
            'skipped' => []
        ];

        try {
            $citizens = Citizen::all();
            
            // First pass: Process all citizen.id records
            foreach ($citizens as $citizen) {
                $results['processed']++;
                $citizenResults = $this->processCitizenId($citizen);
                
                $this->aggregateResults($results, $citizen, $citizenResults);
            }

            // Second pass: Process all wife_id records
            foreach ($citizens as $citizen) {
                $wifeResults = $this->processWifeId($citizen);
                
                $this->aggregateResults($results, $citizen, $wifeResults);
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
            'errors' => [],
            'skipped' => []
        ];

        try {
            // First, process citizen.id - add as father if male, mother if female
            $personFromId = Person::where('CI_ID_NUM', $citizen->id)->first();
            if ($personFromId) {
                if ($personFromId->CI_SEX_CD === 'ذكر') {
                    $this->assignAsFather($citizen, $personFromId, $results);
                } elseif ($personFromId->CI_SEX_CD === 'أنثى') {
                    $this->assignAsMother($citizen, $personFromId, $results);
                }
            } else {
                $results['skipped'][] = "لم يتم العثور على سجل الشخص برقم الهوية {$citizen->id}";
                $this->recordFailure($citizen->id, null, null, 'Person record not found', 'Citizen ID');
            }

            // Then, process wife_id if it exists and not 0
            if ($citizen->wife_id && $citizen->wife_id !== '0') {
                $personFromWifeId = Person::where('CI_ID_NUM', $citizen->wife_id)->first();
                if ($personFromWifeId) {
                    if ($personFromWifeId->CI_SEX_CD === 'ذكر') {
                        $this->assignAsFather($citizen, $personFromWifeId, $results);
                    } elseif ($personFromWifeId->CI_SEX_CD === 'أنثى') {
                        $this->assignAsMother($citizen, $personFromWifeId, $results);
                    }
                } else {
                    $results['skipped'][] = "لم يتم العثور على سجل زوج الشخص برقم الهوية {$citizen->wife_id}";
                    $this->recordFailure($citizen->id, $citizen->wife_id, null, 'Spouse record not found', 'Wife ID');
                }
            } else {
                $results['skipped'][] = "لا يوجد رقم هوية زوج مرتبط";
                $this->recordFailure($citizen->id, null, null, 'No spouse ID linked', 'Wife ID');
            }

        } catch (Exception $e) {
            $results['errors'][] = $e->getMessage();
            Log::error('Error assigning family members', [
                'citizen_id' => $citizen->id,
                'error' => $e->getMessage()
            ]);
            $this->recordFailure($citizen->id, null, null, 'Exception occurred', $e->getMessage());
        }

        return $results;
    }

    protected function aggregateResults(&$results, $citizen, $newResults)
    {
        $results['father_added'] += $newResults['father_added'];
        $results['mother_added'] += $newResults['mother_added'];
        if (!empty($newResults['errors'])) {
            $results['errors'][] = [
                'citizen_id' => $citizen->id,
                'errors' => $newResults['errors']
            ];
        }
        if (!empty($newResults['skipped'])) {
            $results['skipped'][] = [
                'citizen_id' => $citizen->id,
                'reasons' => $newResults['skipped']
            ];
        }
    }

    public function processCitizenId(Citizen $citizen)
    {
        $results = [
            'father_added' => 0,
            'mother_added' => 0,
            'errors' => [],
            'skipped' => []
        ];

        try {
            $personFromId = Person::where('CI_ID_NUM', $citizen->id)->first();
            if ($personFromId) {
                if ($personFromId->CI_SEX_CD === 'ذكر') {
                    $this->assignAsFather($citizen, $personFromId, $results);
                } elseif ($personFromId->CI_SEX_CD === 'أنثى') {
                    $this->assignAsMother($citizen, $personFromId, $results);
                }
            } else {
                $results['skipped'][] = "لم يتم العثور على سجل الشخص برقم الهوية {$citizen->id}";
                $this->recordFailure($citizen->id, null, null, 'Person record not found', 'Citizen ID');
            }
        } catch (Exception $e) {
            $results['errors'][] = $e->getMessage();
            Log::error('Error processing citizen.id', [
                'citizen_id' => $citizen->id,
                'error' => $e->getMessage()
            ]);
            $this->recordFailure($citizen->id, null, null, 'Exception occurred', $e->getMessage());
        }

        return $results;
    }

    public function processWifeId(Citizen $citizen)
    {
        $results = [
            'father_added' => 0,
            'mother_added' => 0,
            'errors' => [],
            'skipped' => []
        ];

        try {
            if (!$citizen->wife_id || $citizen->wife_id === '0') {
                $results['skipped'][] = "لا يوجد رقم هوية زوج مرتبط";
                $this->recordFailure($citizen->id, null, null, 'No spouse ID linked', 'Wife ID');
                return $results;
            }

            $personFromWifeId = Person::where('CI_ID_NUM', $citizen->wife_id)->first();
            if ($personFromWifeId) {
                if ($personFromWifeId->CI_SEX_CD === 'ذكر') {
                    $this->assignAsFather($citizen, $personFromWifeId, $results);
                } elseif ($personFromWifeId->CI_SEX_CD === 'أنثى') {
                    $this->assignAsMother($citizen, $personFromWifeId, $results);
                }
            } else {
                $results['skipped'][] = "لم يتم العثور على سجل زوج الشخص برقم الهوية {$citizen->wife_id}";
                $this->recordFailure($citizen->id, $citizen->wife_id, null, 'Spouse record not found', 'Wife ID');
            }
        } catch (Exception $e) {
            $results['errors'][] = $e->getMessage();
            Log::error('Error processing wife_id', [
                'citizen_id' => $citizen->id,
                'wife_id' => $citizen->wife_id,
                'error' => $e->getMessage()
            ]);
            $this->recordFailure($citizen->id, $citizen->wife_id, null, 'Exception occurred', $e->getMessage());
        }

        return $results;
    }

    protected function assignAsFather(Citizen $citizen, Person $person, &$results)
    {
        // Skip if already has a father
        if ($this->familyMemberService->getParents($citizen)->where('relationship', 'father')->count() > 0) {
            $results['skipped'][] = "يوجد أب مسجل بالفعل";
            $this->recordFailure($citizen->id, $person->CI_ID_NUM, 'father', 'Father already exists', 'Skipped');
            return;
        }

        try {
            $dateOfBirth = null;
            if ($person->CI_BIRTH_DT) {
                try {
                    $dateOfBirth = Carbon::createFromFormat('d/m/Y', $person->CI_BIRTH_DT)->format('Y-m-d');
                } catch (\Exception $e) {
                    Log::warning('Failed to parse father date_of_birth', [
                        'input' => $person->CI_BIRTH_DT,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            $this->familyMemberService->addMember([
                'firstname' => $person->CI_FIRST_ARB,
                'secondname' => $person->CI_FATHER_ARB,
                'thirdname' => $person->CI_GRAND_FATHER_ARB,
                'lastname' => $person->CI_FAMILY_ARB,
                'date_of_birth' => $dateOfBirth,
                'gender' => 'male',
                'relationship' => 'father',
                'national_id' => $person->CI_ID_NUM,
                'notes' => 'تم إضافته تلقائياً كأب'
            ], $citizen);

            $results['father_added']++;
        } catch (Exception $e) {
            $results['errors'][] = "فشل إضافة الأب: " . $e->getMessage();
            $this->recordFailure($citizen->id, $person->CI_ID_NUM, 'father', 'Failed to add father', $e->getMessage());
        }
    }

    protected function assignAsMother(Citizen $citizen, Person $person, &$results)
    {
        // Skip if already has a mother
        if ($this->familyMemberService->getParents($citizen)->where('relationship', 'mother')->count() > 0) {
            $results['skipped'][] = "يوجد أم مسجلة بالفعل";
            $this->recordFailure($citizen->id, $person->CI_ID_NUM, 'mother', 'Mother already exists', 'Skipped');
            return;
        }

        try {
            $dateOfBirth = null;
            if ($person->CI_BIRTH_DT) {
                try {
                    $dateOfBirth = Carbon::createFromFormat('d/m/Y', $person->CI_BIRTH_DT)->format('Y-m-d');
                } catch (\Exception $e) {
                    Log::warning('Failed to parse mother date_of_birth', [
                        'input' => $person->CI_BIRTH_DT,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            $this->familyMemberService->addMember([
                'firstname' => $person->CI_FIRST_ARB,
                'secondname' => $person->CI_FATHER_ARB,
                'thirdname' => $person->CI_GRAND_FATHER_ARB,
                'lastname' => $person->CI_FAMILY_ARB,
                'date_of_birth' => $dateOfBirth,
                'gender' => 'female',
                'relationship' => 'mother',
                'national_id' => $person->CI_ID_NUM,
                'notes' => 'تم إضافتها تلقائياً كأم'
            ], $citizen);

            $results['mother_added']++;
        } catch (Exception $e) {
            $results['errors'][] = "فشل إضافة الأم: " . $e->getMessage();
            $this->recordFailure($citizen->id, $person->CI_ID_NUM, 'mother', 'Failed to add mother', $e->getMessage());
        }
    }
}
