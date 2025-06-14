<?php

namespace App\Models;

use App\Models\Traits\CitizenFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Citizen extends Model
{
    use SoftDeletes, CitizenFilters, \App\Traits\LogsActivity;

    protected $table='citizens';
    
    protected $fillable = [
        'id',
        'firstname',
        'secondname',
        'thirdname',
        'lastname',
        'phone',
        'phone2',
        'family_members',
        'wife_id',
        'wife_name',
        'mails_count',
        'femails_count',
        'leesthan3',        
        'obstruction',
        'obstruction_description',
        'disease',
        'disease_description',
        'job',
        'living_status',
        'original_governorate_id',
        'original_address',
        'note',
        'region_id',
        // other
        'date_of_birth',
        'gender',
        'widowed',
        'social_status',
        'elderly_count',
        'is_archived', // Archived flag
        ];
   
    protected $primaryKey='id';
    public $incrementing=false;

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function distributions()
    {
        return $this->belongsToMany(Distribution::class, 'distribution_citizens')
            ->withPivot(['id', 'quantity', 'recipient', 'note', 'done', 'date'])
            ->select(['distributions.*'])  // Only select base distribution fields when eager loading
            ->withTimestamps();
    }
    
    public function children()
    {
        return $this->hasMany(Child::class);
    }

    // public function familyMembers()
    // {
    //     return $this->hasMany(Child::class);
    // }

    public function originalGovernorate()
    {
        return $this->belongsTo(Governorate::class, 'original_governorate_id');
    }

    public function isArchived()
    {
        return $this->is_archived;
    }

    public static function findOrCreateById($id, $additionalData = [])
    {
        Log::info('adding id :'.$id);
        $citizen = self::withTrashed()->find($id);

        if (!$citizen) {
            Log::info('non exist citizen adding , id: '.$id);
            $citizen = self::create([
                'id' => $id,
                'firstname' => $additionalData['firstname'] ?? 'بلا اسم',
                'lastname' => $additionalData['lastname'] ?? 'مجهول',
                'region_id' =>$additionalData['region_id'] ?? 0,
                'is_archived' => true,
                'note' =>'اضافة خارجية من تحميل كشف' ,
            ]);
            Log::info('non exist citizen added , id: '.$id);
        } elseif ($citizen->trashed()) {
            $citizen->restore();
            $citizen->update(['is_archived' => true]);
        }

        return $citizen;
    }

      // Scope for region-based filtering
      public function scopeForUserRegions($query)
      {
        Log::info('using scope');
          // If user is a region manager
          if (auth()->user() && auth()->user()->role_id ==3) {
              Log::info('is region manager');
              Log::info(auth()->user()->role_id);

              $regionIds = auth()->user()->regions->pluck('id')->toArray();  // Assuming the user has related regions
              return $query->whereIn('region_id', $regionIds);
          }
          
          // If user is not restricted by region, return all citizens
          return $query;
      }
  
      /**
     * Scope to only get archived citizens.
     */
    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    
      /**
     * Scope to only get archived citizens.
     */
    public function scopeActive($query)
    {
        return $query->where('is_archived', 0);
    }

    /**
     * Get all family members associated with this citizen
     */
    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }

    /**
     * Get the father of the family (if exists)
     */
    public function father()
    {
        return $this->hasOne(FamilyMember::class)->where('relationship', 'father');
    }

    /**
     * Get the mother of the family (if exists)
     */
    public function mother()
    {
        return $this->hasOne(FamilyMember::class)->where('relationship', 'mother');
    }

    /**
     * Get all children (including accompanying children)
     */
    public function allChildren()
    {
        return $this->hasMany(FamilyMember::class)
            ->where(function($query) {
                $query->where('relationship', 'son')
                      ->orWhere('relationship', 'daughter')
                      ->where('is_accompanying', true);
            });
    }

    public function getCategoriesAttribute()
    {
      $members = $this->familyMembers;
      $categories = [];
      foreach ($members as $member) {
        foreach ($member->categories as $category ) {
            $categories[]= $category->name;
        }
      }
      return array_unique($categories);   

    }

    public function getCategoryStringAttribute()
    {
        return implode(' - ', $this->categories);
    }
    /**
     * Get only accompanying children
     */
    public function accompanyingChildren()
    {
        return $this->hasMany(FamilyMember::class)
            ->where(function($query) {
                $query->where('relationship', 'son')
                      ->orWhere('relationship', 'daughter');
            })
            ->where('is_accompanying', true);
    }
    
    /**
     * Get the care provider family member
     */
    public function careProvider()
    {
        return $this->belongsTo(FamilyMember::class, 'care_provider_id');
    }

      public function getFullNameAttribute()
    {
        
        $cacheKey = "person_fullname_{$this->id}";
        return Cache::remember($cacheKey, $this->cacheDuration, function () {
            return "{$this->firstname} {$this->secondname} {$this->thirdname} {$this->lastname}";
        });
    }



}