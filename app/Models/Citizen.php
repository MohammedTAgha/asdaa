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
        'date_of_birth',
        'gender',
        'obstruction',
        'obstruction_description',
        'disease',
        'disease_description',
        'wife_name',
        'wife_id',
        'widowed',
        'social_status',
        'living_status',
        'job',
        'original_address',
        'elderly_count',
        'region_id',
        'note',
    
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
}