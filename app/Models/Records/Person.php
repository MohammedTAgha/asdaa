<?php

namespace App\Models\Records;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Person extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'CI_ID_NUM';
    public $timestamps = false;
    protected $table = 'persons';
    protected $connection = 'sqlite';

    // Only load essential attributes by default
    protected $with = [];
    protected $appends = ['age', 'full_name'];

    // Cache duration for attributes and relationships
    protected $cacheDuration = 1440; // 24 hours in minutes

    // Define which attributes should be eagerly loaded
    protected $visible = [
        'CI_ID_NUM',
        'CI_FIRST_ARB',
        'CI_FATHER_ARB',
        'CI_GRAND_FATHER_ARB',
        'CI_FAMILY_ARB',
        'CI_PERSONAL_CD',
        'CI_BIRTH_DT',
        'CI_SEX_CD',
        'CI_DEAD_DT',
        'age',
        'full_name'
    ];

    protected $fillable = [
        'CI_ID_NUM',
        'CI_FIRST_ARB',
        'CI_FATHER_ARB',
        'CI_GRAND_FATHER_ARB',
        'CI_FAMILY_ARB',
        'CI_PERSONAL_CD',
        'CITTTTY',
        'CITY',
        'CI_BIRTH_DT',
        'CI_SEX_CD',
        'CI_DEAD_DT'
    ];

    public function relations()
    {
        return $this->hasMany(Relation::class, 'CF_ID_NUM', 'CI_ID_NUM');
    }

    public function getFullNameAttribute()
    {
        $cacheKey = "person_fullname_{$this->CI_ID_NUM}";
        return Cache::remember($cacheKey, $this->cacheDuration, function () {
            return "{$this->CI_FIRST_ARB} {$this->CI_FATHER_ARB} {$this->CI_GRAND_FATHER_ARB} {$this->CI_FAMILY_ARB}";
        });
    }

    public function getAgeAttribute()
    {
        if ($this->CI_BIRTH_DT) {
            try {
                $birthDate = \Carbon\Carbon::createFromFormat('d/m/Y', $this->CI_BIRTH_DT);
                return $birthDate->age;
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    public function getWifes()
    {
        if ($this->CI_PERSONAL_CD !== "متزوج") {
            return collect();
        }

        $cacheKey = "person_wives_{$this->CI_ID_NUM}";
        return Cache::remember($cacheKey, $this->cacheDuration, function () {
            return $this->select('persons.*')
                ->join('relations', 'persons.CI_ID_NUM', '=', 'relations.CF_ID_RELATIVE')
                ->where('relations.CF_ID_NUM', $this->CI_ID_NUM)
                ->where('relations.CF_RELATIVE_CD', 4)
                ->get();
        });
    }

    public function getWife()
    {
        if ($this->CI_PERSONAL_CD !== "متزوج") {
            return null;
        }

        $cacheKey = "person_wife_{$this->CI_ID_NUM}";
        return Cache::remember($cacheKey, $this->cacheDuration, function () {
            return $this->select('persons.*')
                ->join('relations', 'persons.CI_ID_NUM', '=', 'relations.CF_ID_RELATIVE')
                ->where('relations.CF_ID_NUM', $this->CI_ID_NUM)
                ->where('relations.CF_RELATIVE_CD', 4)
                ->first();
        });
    }

    // Query scopes for better reusability
    public function scopeWithFamily($query)
    {
        return $query->with(['relations' => function($q) {
            $q->whereIn('CF_RELATIVE_CD', [4, 1, 2]) // Wife, Children, Parents
                ->with('relative');
        }]);
    }

    public function scopeByIdNumber($query, $idNumber)
    {
        return $query->where('CI_ID_NUM', 'like', "%{$idNumber}%");
    }

    public function scopeByName($query, $firstName = null, $fatherName = null, $grandfatherName = null, $familyName = null)
    {
        return $query->when($firstName, fn($q) => $q->where('CI_FIRST_ARB', 'like', "%{$firstName}%"))
                    ->when($fatherName, fn($q) => $q->where('CI_FATHER_ARB', 'like', "%{$fatherName}%"))
                    ->when($grandfatherName, fn($q) => $q->where('CI_GRAND_FATHER_ARB', 'like', "%{$grandfatherName}%"))
                    ->when($familyName, fn($q) => $q->where('CI_FAMILY_ARB', 'like', "%{$familyName}%"));
    }
}
