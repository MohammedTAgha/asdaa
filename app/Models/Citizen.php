<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Citizen extends Model
{
    protected $table='citizens';
    protected $fillable = [
        'id',
        'name',
        'date_of_birth',
        'gender',
        'wife_name',
        'wife_id',
        'widowed',
        'social_status',
        'living_status',
        'job',
        'original_address',
        'elderly_count',
        'region_id ',
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
        return $this->belongsToMany(Distribution::class, 'distribution_citizens');
    }
}