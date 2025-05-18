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
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                $citizen = Citizen::find($row['citizen_id']);
                
                if (!$citizen) {
                    $this->failures[] = [
                        'row' => $row,
                        'error' => 'رقم هوية رب الأسرة غير موجود'
                    ];
                    continue;
                }

                $dateOfBirth = null;
                try {
                    $dateOfBirth = Carbon::createFromFormat('Y-m-d', $row['date_of_birth'])->format('Y-m-d');
                } catch (\Exception $e) {
                    $this->failures[] = [
                        'row' => $row,
                        'error' => 'صيغة تاريخ الميلاد غير صحيحة. يجب أن تكون YYYY-MM-DD'
                    ];
                    continue;
                }

                $memberData = [
                    'firstname' => $row['firstname'],
                    'secondname' => $row['secondname'],
                    'thirdname' => $row['thirdname'] ?? null,
                    'lastname' => $row['lastname'],
                    'date_of_birth' => $dateOfBirth,
                    'gender' => $row['gender'],
                    'relationship' => $row['relationship'],
                    'is_accompanying' => $row['is_accompanying'] ?? false,
                    'national_id' => $row['national_id'],
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
    }

    public function rules(): array
    {
        return [
            'citizen_id' => 'required',
            'firstname' => 'required|string|max:255',
            'secondname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'relationship' => 'required|in:father,mother,son,daughter',
            'national_id' => 'required|string|unique:family_members,national_id',
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
