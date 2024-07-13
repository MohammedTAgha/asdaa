<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionRepresentative extends Model
{
    protected $table='region_representatives';
    protected $primaryKey='id';
    protected $fillable = [
        'id',
        'name',
        'region_id',
        'phone',
        'address',
        'note',
    ];
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}