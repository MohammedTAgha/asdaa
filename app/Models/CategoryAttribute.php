<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryAttribute extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'type', // e.g., 'text', 'number', 'date', 'select', etc.
        'description',
        'is_required',
        'options', // JSON field for select/multi-select options
        'validation_rules', // JSON field for validation rules
        'order', // For ordering attributes in forms
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'options' => 'array',
        'validation_rules' => 'array',
    ];

    /**
     * Get the category that owns this attribute
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all family member category values for this attribute
     */
    public function familyMemberValues()
    {
        return $this->hasMany(FamilyMemberCategory::class, 'category_attribute_id');
    }
} 