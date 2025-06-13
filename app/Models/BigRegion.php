<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class BigRegion extends Model
{
    use  \App\Traits\LogsActivity;
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
        return $this->belongsTo(RegionRepresentative::class, 'representative_id')
            ->where('is_big_region_representative', true);
    }

    public function citizens()
    {
        return $this->hasManyThrough(Citizen::class, Region::class, 'big_region_id', 'region_id');
    }

    public function distributions()
    {
        return Distribution::whereHas('citizens', function($query) {
            $query->whereHas('region', function($query) {
                $query->where('big_region_id', $this->id);
            });
        });
    }
}