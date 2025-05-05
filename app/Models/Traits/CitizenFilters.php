<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CitizenFilters
{
    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $searchTerms = explode(' ', $search);
                $query->where(function ($q) use ($searchTerms, $search) {
                    // Full name search across name columns
                    $q->where(function ($nameQ) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            $nameQ->where(function ($termQ) use ($term) {
                                $termQ->where('firstname', 'like', '%' . $term . '%')
                                    ->orWhere('secondname', 'like', '%' . $term . '%')
                                    ->orWhere('thirdname', 'like', '%' . $term . '%')
                                    ->orWhere('lastname', 'like', '%' . $term . '%');
                            });
                        }
                    });
                    // Original single-term searches for other columns
                    $q->orWhere('wife_name', 'like', '%' . $search . '%')
                        ->orWhere('id', 'like', '%' . $search . '%')
                        ->orWhere('note', 'like', '%' . $search . '%');
                });
            });
        }); 


        $query->when($filters['region_id'] ?? null, function ($query, $regionId) {
            $query->where('region_id', $regionId);
        });
        $query->when($filters['first_name'] ?? null, function ($query, $first_name) {
            $query->where('firstname', 'like', '%' . $first_name . '%');
        });
        $query->when($filters['third_name'] ?? null, function ($query, $third_name) {
            $query->where('thirdname', 'like', '%' . $third_name . '%');
        });
        $query->when($filters['second_name'] ?? null, function ($query, $second_name) {
            $query->where('secondname', 'like', '%' . $second_name . '%');
        });
        $query->when($filters['last_name'] ?? null, function ($query, $last_name) {
            $query->where('lastname', 'like', '%' . $last_name . '%');
        });
        $query->when($filters['id'] ?? null, function ($query, $id) {
            $query->where('id',$id);
        });

        $query->when($filters['minMembers'] ?? null, function ($query, $minMembers) {
            $query->where('family_members', '>=',$minMembers);
        });

        $query->when($filters['maxMembers'] ?? null, function ($query, $maxMembers) {
            $query->where('family_members', '<=',$maxMembers);
        });

        $query->when($filters['regions'] ?? null, function ($query, $regions) {
            $query->whereIn('region_id', $regions);
        });

        $query->when($filters['gender'] ?? null, function ($query, $gender) {
            $query->where('gender', $gender);
        });

        $query->when($filters['social_status'] ?? null, function ($query, $socialStatus) {
            $query->where('social_status', $socialStatus);
        });

        $query->when($filters['living_status'] ?? null, function ($query, $livingStatus) {
            $query->where('living_status', $livingStatus);
        });

        $query->when($filters['job'] ?? null, function ($query, $job) {
            $query->where('job', $job);
        });

        $query->when($filters['obstruction'] ?? null, function ($query) {
            $query->where('obstruction', '>', 0);
        });

        $query->when($filters['disease'] ?? null, function ($query) {
            $query->where('disease', '>', 0);
        });

        $query->when($filters['widowed'] ?? null, function ($query) {
            $query->where('widowed', '>', 0);
        });

        $query->when($filters['family_size_min'] ?? null, function ($query, $minSize) {
            $query->where('family_members', '>=', $minSize);
        });

        $query->when($filters['family_size_max'] ?? null, function ($query, $maxSize) {
            $query->where('family_members', '<=', $maxSize);
        });

        $query->when($filters['date_of_birth_from'] ?? null, function ($query, $fromDate) {
            $query->where('date_of_birth', '>=', $fromDate);
        });

        $query->when($filters['date_of_birth_to'] ?? null, function ($query, $toDate) {
            $query->where('date_of_birth', '<=', $toDate);
        });

        $query->when($filters['is_archived'] ?? null, function ($query, $isArchived) {
            $query->where('is_archived', $isArchived);
        });

        
        $query->when($filters['citizen_status'] ?? null, function ($query, $citizen_status) {
            // $query->where('is_archived', $isArchived);
            switch ($citizen_status) {
                case 'deleted':
                    $query->onlyTrashed();
                    break;
                case 'archived':
                    $query->where('is_archived', true);
                    break;
                case 'all':
                    $query->withTrashed();
                    break;
                default:
                    $query->where('is_archived', false);
                    break;
            }
        });


        return $query;
    }
}