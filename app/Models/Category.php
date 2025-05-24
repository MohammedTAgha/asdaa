<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'size',
        'amount',
        'date',
        'property1',
        'property2',
        'property3',
        'property4',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];

    /**
     * Get the family members that belong to this category
     */
    public function familyMembers()
    {
        return $this->belongsToMany(FamilyMember::class)
            ->withPivot([
                'size',
                'description',
                'date',
                'amount',
                'property1',
                'property2',
                'property3',
                'property4'
            ])
            ->withTimestamps();
    }
}
