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
        'is_active',
        'type', // e.g., 'disability', 'housing', 'medical', etc.
        'icon', // Optional: for UI representation
        'color', // Optional: for UI representation
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the attributes associated with this category
     */
    public function attributes()
    {
        return $this->hasMany(CategoryAttribute::class);
    }

    /**
     * Get all family members that belong to this category
     */
    public function familyMembers()
    {
        return $this->belongsToMany(FamilyMember::class, 'family_member_categories')
            ->withPivot(['value', 'notes', 'date', 'status'])
            ->withTimestamps();
    }

    /**
     * Scope a query to only include active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
