<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'position',
        'note',
        'big_region_id',
    ];

    // Default eager loading for statistics
    protected $with = ['citizens', 'representatives', 'bigRegion.representative'];

    // Append computed attributes
    protected $appends = ['total_family_members', 'total_projects'];

    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }

    public function representatives()
    {
        return $this->hasMany(RegionRepresentative::class)->where('is_big_region_representative', false);
    }

    public function manager()
    {
        return $this->belongsToMany(User::class, 'region_users', 'region_id', 'user_id');
    }

    public function bigRegion()
    {
        return $this->belongsTo(BigRegion::class, 'big_region_id');
    }

    public function getBigRegionManagerAttribute()
    {
        return $this->bigRegion ? $this->bigRegion->representative : null;
    }

    public function isSubRegion()
    {
        return !is_null($this->big_region_id);
    }

    public function getTotalFamilyMembersAttribute()
    {
        return $this->citizens->sum('family_members');
    }

    public function getCountAttribute()
    {
        return $this->citizens->count('id');
    }
    public function getTotalProjectsAttribute()
    {
        return $this->citizens->flatMap->distributions->unique()->count();
    }
}
