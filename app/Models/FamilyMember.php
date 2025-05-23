<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class FamilyMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'citizen_id',
        'firstname',
        'secondname',
        'thirdname',
        'lastname',
        'date_of_birth',
        'gender',
        'relationship', // 'father', 'mother', 'son', 'daughter', 'other'
        'is_accompanying', // for accompanying children
        'national_id',
        'notes',
        'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_accompanying' => 'boolean'
    ];

    /**
     * Get the validation rules for the model.
     *
     * @return array
     */
    public static function rules($id = null)
    {
        return [
            'national_id' => [
                'required',
                'string',
                'size:10',  // Assuming national ID is 10 digits
                Rule::unique('family_members')->ignore($id),
            ],
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'relationship' => 'required|in:father,mother,son,daughter,other',
        ];
    }

    /**
     * Get the citizen (family) that this member belongs to
     */
    public function citizen()
    {
        return $this->belongsTo(Citizen::class);
    }

    /**
     * Get all categories associated with this family member
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'family_member_categories')
            ->withPivot(['value', 'notes', 'date', 'status'])
            ->withTimestamps();
    }

    /**
     * Get all category values for this family member
     */
    public function categoryValues()
    {
        return $this->hasMany(FamilyMemberCategory::class);
    }
} 