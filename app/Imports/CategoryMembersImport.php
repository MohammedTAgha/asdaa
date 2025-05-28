<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\FamilyMember;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CategoryMembersImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $category;
    protected $successes = 0;
    protected $failures = [];

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                // Find the family member by national ID
                $member = FamilyMember::where('national_id', $row['national_id'])->first();

                if (!$member) {
                    $this->failures[] = [
                        'row' => $row,
                        'error' => 'لم يتم العثور على العضو برقم الهوية: ' . $row['national_id']
                    ];
                    continue;
                }

                // Prepare pivot data
                $pivotData = [
                    'size' => $row['size'] ?? null,
                    'description' => $row['description'] ?? null,
                    'date' => $row['date'] ?? null,
                    'amount' => $row['amount'] ?? null,
                    'property1' => $row['property1'] ?? null,
                    'property2' => $row['property2'] ?? null,
                    'property3' => $row['property3'] ?? null,
                    'property4' => $row['property4'] ?? null,
                ];

                // Attach member to category with pivot data
                $this->category->familyMembers()->syncWithoutDetaching([
                    $member->id => $pivotData
                ]);

                $this->successes++;
            } catch (\Exception $e) {
                Log::error('Error importing category member', [
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
            'national_id' => 'required',
            'size' => 'nullable',
            'description' => 'nullable',
            'date' => 'nullable',
            'amount' => 'nullable',
            'property1' => 'nullable',
            'property2' => 'nullable',
            'property3' => 'nullable',
            'property4' => 'nullable',
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