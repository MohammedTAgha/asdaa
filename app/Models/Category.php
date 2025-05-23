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
        'notes',
        'amount',
        'size',
        'date',
        'property1',
        'property2',
        'property3',
        'color',
        'is_active'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the validation rules for the model.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'size' => 'nullable|string|max:50',
            'date' => 'nullable|date',
            'property1' => 'nullable|string|max:255',
            'property2' => 'nullable|string|max:255',
            'property3' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the family members that belong to this category.
     */
    public function familyMembers()
    {
        return $this->belongsToMany(FamilyMember::class)
                    ->withTimestamps();
    }
}
