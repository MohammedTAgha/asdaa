<?php

namespace App\Models;

use App\Models\Traits\CitizenFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;
class Citizen extends Model
{
    use SoftDeletes, CitizenFilters;

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
        ->withPivot('id','quantity','recipient','note','done','date');
    }
    
    public function children()
    {
        return $this->hasMany(Child::class);
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
            ]);
            Log::info('non exist citizen added , id: '.$id);
        } elseif ($citizen->trashed()) {
            $citizen->restore();
            $citizen->update(['is_archived' => true]);
        }

        return $citizen;
    }

      /**
     * Scope to only get archived citizens.
     */
    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }


}