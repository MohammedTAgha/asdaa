<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class BigRegion extends Model
{
    protected $table = 'big_regions';

    protected $fillable = [
        'name',
        'note',
        'representative_id',
    ];

    public function regions()
    {
        return $this->hasMany(Region::class, 'big_region_id');
    }

    public function representative()
    {
        return $this->belongsTo(RegionRepresentative::class, 'representative_id');
    }
    public function bigRegion()
    {
        return $this->hasOne(BigRegion::class, 'representative_id');
    }
    public function citizens()
    {
        return $this->hasManyThrough(Citizen::class, Region::class, 'big_region_id', 'region_id');
    }
}