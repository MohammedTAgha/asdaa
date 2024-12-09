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
    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }

    public function representatives()
    {
        return $this->hasMany(RegionRepresentative::class);
    }
    public function manager()
    {
        return $this->belongsToMany(User::class, 'region_users', 'region_id', 'user_id');
    }

    public function bigRegion()
    {
        return $this->belongsTo(BigRegion::class, 'big_region_id');
    }
    public function bigRegionManager()
    {
        return $this->bigRegion->representative();
    }
}
