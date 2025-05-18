<?php

namespace App\Imports;

use App\Models\Citizen;
use App\Models\FamilyMember;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Services\FamilyMemberService;
use Illuminate\Support\Facades\Log;

class FamilyMembersImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $successes = 0;
    protected $failures = [];
    protected $familyMemberService;

    public function __construct(FamilyMemberService $familyMemberService)
    {
        $this->familyMemberService = $familyMemberService;
    }    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                // Log the current row for debugging
                Log::info('Processing row:', ['row' => $row]);

                // Check for citizen
                $citizen = Citizen::find($row['citizen_id']);
                if (!$citizen) {
                    $this->failures[] = [
                        'row' => $row,
                        'error' => sprintf('رقم هوية رب الأسرة غير موجود: %s', $row['citizen_id'])
                    ];
                    continue;
                }

                // Handle date of birth
                $dateOfBirth = null;
                try {
                    // Try multiple date formats
                    $dateFormats = ['Y-m-d', 'd/m/Y', 'm/d/Y', 'Y/m/d'];
                    $dateValue = $row['date_of_birth'];
                    
                    foreach ($dateFormats as $format) {
                        try {
                            $dateOfBirth = Carbon::createFromFormat($format, $dateValue)->format('Y-m-d');
                            break;
                        } catch (\Exception $e) {
                            continue;
                        }
                    }

                    if (!$dateOfBirth) {
                        throw new \Exception('Unable to parse date');
                    }

                } catch (\Exception $e) {
                    $this->failures[] = [
                        'row' => $row,
                        'error' => sprintf('صيغة تاريخ الميلاد غير صحيحة للقيمة "%s". الصيغ المقبولة: YYYY-MM-DD, DD/MM/YYYY, MM/DD/YYYY', $row['date_of_birth'])
                    ];
                    continue;
                }                // Validate gender
                $gender = strtolower(trim($row['gender']));
                if (!in_array($gender, ['male', 'female', 'ذكر', 'انثى', 'أنثى'])) {
                    $this->failures[] = [
                        'row' => $row,
                        'error' => sprintf('قيمة الجنس غير صحيحة: %s. القيم المقبولة: male, female, ذكر, انثى', $row['gender'])
                    ];
                    continue;
                }

                // Convert Arabic gender to English
                if (in_array($gender, ['ذكر'])) {
                    $gender = 'male';
                } elseif (in_array($gender, ['انثى', 'أنثى'])) {
                    $gender = 'female';
                }                // Handle national_id - ensure it's a string and has 9 digits
                $nationalId = (string) $row['national_id'];
                if (!preg_match('/^\d{9}$/', $nationalId)) {
                    $this->failures[] = [
                        'row' => $row,
                        'error' => sprintf('رقم الهوية يجب أن يتكون من 9 أرقام. القيمة المدخلة: %s', $row['national_id'])
                    ];
                    continue;
                }

                // Prepare member data
                $memberData = [
                    'firstname' => $row['firstname'],
                    'secondname' => $row['secondname'],
                    'thirdname' => $row['thirdname'] ?? null,
                    'lastname' => $row['lastname'],
                    'date_of_birth' => $dateOfBirth,
                    'gender' => $gender,
                    'relationship' => strtolower(trim($row['relationship'])),
                    'is_accompanying' => isset($row['is_accompanying']) ? filter_var($row['is_accompanying'], FILTER_VALIDATE_BOOLEAN) : false,
                    'national_id' => $nationalId,
                    'notes' => $row['notes'] ?? null,
                ];

                $this->familyMemberService->addMember($memberData, $citizen);
                $this->successes++;

            } catch (\Exception $e) {
                Log::error('Error importing family member', [
                    'row' => $row,
                    'error' => $e->getMessage()
                ]);

                $this->failures[] = [
                    'row' => $row,
                    'error' => $e->getMessage()
                ];
            }
        }
    }    public function rules(): array
    {
        return [
            'citizen_id' => 'required|exists:citizens,id',
            'firstname' => 'required|string|max:255',
            'secondname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'relationship' => 'required',
            'national_id' => 'required',  // We'll handle the validation in the collection method
            'thirdname' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }

    public function getReport(): array
    {
        return [
            'successes' => $this->successes,
            'failures' => $this->failures
        ];
    }
}
