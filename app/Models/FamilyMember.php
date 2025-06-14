<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class FamilyMember extends Model
{
    use HasFactory, SoftDeletes ,\App\Traits\LogsActivity;

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
                'size:22',  // Assuming national ID is 10 digits
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
     * Get the categories that belong to this family member
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class)
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

    public function getFullNameAttribute()
    {
        
        $cacheKey = "person_fullname_{$this->id}";
        return Cache::remember($cacheKey, $this->cacheDuration, function () {
            return "{$this->firstname} {$this->secondname} {$this->thirdname} {$this->lastname}";
        });
    }

    /**
     * Get all category names as an array
     */
    public function getCategoryNamesAttribute()
    {
        return $this->categories->pluck('name')->toArray();
    }

    /**
     * Get all category names as a comma-separated string
     */
    public function getCategoryNamesStringAttribute()
    {
        return implode(' - ', $this->category_names);
    }
/**
 * Get the age of the family member
 */
public function getAgeAttribute()
{
    if (!$this->date_of_birth) {
        return null;
    }

    return Carbon::parse($this->date_of_birth)->age;
}
} 