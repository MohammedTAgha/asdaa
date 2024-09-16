<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CitizenFilters
{
    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('firstname', 'like', '%' . $search . '%')
                    ->orWhere('secondname', 'like', '%' . $search . '%')
                    ->orWhere('thirdname', 'like', '%' . $search . '%')
                    ->orWhere('lastname', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('phone2', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['region_id'] ?? null, function ($query, $regionId) {
            $query->where('region_id', $regionId);
        });
        $query->when($filters['first_name'] ?? null, function ($query, $first_name) {
            $query->where('first_name',$first_name);
        });
        $query->when($filters['third_name'] ?? null, function ($query, $third_name) {
            $query->where('third_name',$third_name);
        });
        $query->when($filters['second_name'] ?? null, function ($query, $second_name) {
            $query->where('second_name',$second_name);
        });
        $query->when($filters['id'] ?? null, function ($query, $id) {
            $query->where('id',$id);
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

        return $query;
    }
}