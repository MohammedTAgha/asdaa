<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionRepresentative extends Model
{
    use  \App\Traits\LogsActivity;
    protected $table='region_representatives';
    protected $primaryKey='id';
    protected $fillable = [
        'id',
        'name',
        'region_id',
        'phone',
        'address',
        'note',
        'is_big_region_representative',
    ];

    // A representative can manage either a regular region or a big region
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function managedBigRegion()
    {
        return $this->hasOne(BigRegion::class, 'representative_id');
    }

    public function managedRegions()
    {
        return $this->hasMany(Region::class, 'region_id');
    }

    // Helper method to check representative type
    public function isBigRegionManager()
    {
        return $this->is_big_region_representative;
    }
}