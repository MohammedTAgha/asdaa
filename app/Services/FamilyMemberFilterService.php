<?php

namespace App\Services;

use App\Models\FamilyMember;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Exports\FamilyMembersExport;

class FamilyMemberFilterService
{
    public function getFilteredMembers(array $filters, bool $paginate = true)
    {
        $query = FamilyMember::query()
            ->with(['citizen' => function($query) {
                $query->select('id', 'firstname', 'secondname', 'thirdname', 'lastname', 'date_of_birth', 'region_id');
            }, 'citizen.region']);

        if (!empty($filters['relationship'])) {
            $query->where('relationship', $filters['relationship']);
        }

        if (!empty($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        if (!empty($filters['region_id'])) {
            $query->whereHas('citizen', function (Builder $query) use ($filters) {
                $query->where('region_id', $filters['region_id']);
            });
        }

        if (!empty($filters['min_age']) || !empty($filters['max_age'])) {
            $query->where(function (Builder $query) use ($filters) {
                if (!empty($filters['min_age'])) {
                    $maxDate = Carbon::now()->subYears($filters['min_age']);
                    $query->where('date_of_birth', '<=', $maxDate);
                }
                if (!empty($filters['max_age'])) {
                    $minDate = Carbon::now()->subYears($filters['max_age'] + 1);
                    $query->where('date_of_birth', '>', $minDate);
                }
            });
        }

        return $paginate ? $query->paginate(15) : $query->get();
    }

    public function export($filters)
    {
        // Get all filtered members without pagination
        $members = $this->getFilteredMembers($filters, false);
        $timestamp = now()->format('Y-m-d_H-i-s');
        return Excel::download(new FamilyMembersExport($members), "family_members_{$timestamp}.xlsx");
    }
}
 