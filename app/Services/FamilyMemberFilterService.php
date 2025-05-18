<?php

namespace App\Services;

use App\Models\FamilyMember;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Exception;

class FamilyMemberFilterService
{
    /**
     * Apply filters to family members query
     */
    public function applyFilters(Builder $query, array $filters): Builder
    {
        if (!empty($filters['type'])) {
            $query->where('relationship', $filters['type']);
        }

        if (!empty($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        if (!empty($filters['region'])) {
            $query->whereHas('citizen', function ($q) use ($filters) {
                $q->where('region', $filters['region']);
            });
        }

        if (!empty($filters['min_age'])) {
            $maxDate = Carbon::now()->subYears($filters['min_age']);
            $query->where('date_of_birth', '<=', $maxDate);
        }

        if (!empty($filters['max_age'])) {
            $minDate = Carbon::now()->subYears($filters['max_age'] + 1);
            $query->where('date_of_birth', '>', $minDate);
        }

        return $query;
    }

    /**
     * Get all available regions from family members
     */
    public function getAvailableRegions(): Collection
    {
        return FamilyMember::query()
            ->join('citizens', 'family_members.citizen_id', '=', 'citizens.id')
            ->select('citizens.region')
            ->distinct()
            ->pluck('region');
    }

    /**
     * Export filtered family members to CSV
     */
    public function exportToCsv(Collection $members): string
    {
        try {
            $headers = [
                'الاسم الكامل',
                'رقم الهوية',
                'تاريخ الميلاد',
                'العمر',
                'الجنس',
                'صلة القرابة',
                'المنطقة',
                'ملاحظات'
            ];

            $rows = $members->map(function ($member) {
                return [
                    $member->firstname . ' ' . $member->secondname . ' ' . $member->lastname,
                    $member->national_id,
                    $member->date_of_birth->format('Y-m-d'),
                    $member->date_of_birth->age,
                    $member->gender === 'male' ? 'ذكر' : 'أنثى',
                    $this->getRelationshipInArabic($member->relationship),
                    $member->citizen->region,
                    $member->notes
                ];
            });

            $csv = implode(',', $headers) . "\n";
            foreach ($rows as $row) {
                $csv .= implode(',', array_map(function ($field) {
                    return '"' . str_replace('"', '""', $field) . '"';
                }, $row)) . "\n";
            }

            return $csv;
        } catch (Exception $e) {
            throw new Exception('حدث خطأ أثناء تصدير البيانات: ' . $e->getMessage());
        }
    }

    /**
     * Get relationship name in Arabic
     */
    private function getRelationshipInArabic(string $relationship): string
    {
        return match ($relationship) {
            'father' => 'أب',
            'mother' => 'أم',
            'son' => 'ابن',
            'daughter' => 'ابنة',
            default => 'أخرى'
        };
    }
} 