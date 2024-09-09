<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Citizen extends Model
{
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
        $citizen = self::withTrashed()->find($id);

        if (!$citizen) {
            $citizen = self::create([
                'id' => $id,
                'firstname' => $additionalData['firstname'] ?? 'Unknown',
                'lastname' => $additionalData['lastname'] ?? 'Unknown',
                'region_id' => 0,
                'is_archived' => true,
            ]);
        } elseif ($citizen->trashed()) {
            $citizen->restore();
            $citizen->update(['is_archived' => true]);
        }

        return $citizen;
    }
}