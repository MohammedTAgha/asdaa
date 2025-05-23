<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyMemberCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'family_member_id',
        'category_id',
        'category_attribute_id',
        'value',
        'notes',
        'date',
        'status', // e.g., 'pending', 'approved', 'rejected'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the family member that owns this category assignment
     */
    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    /**
     * Get the category associated with this assignment
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the specific attribute associated with this value
     */
    public function attribute()
    {
        return $this->belongsTo(CategoryAttribute::class, 'category_attribute_id');
    }
} 