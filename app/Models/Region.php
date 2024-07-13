<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table='regions';
    protected $primaryKey='id';
    protected $fillable = [
        'name',
        'position',
        'note'

    ];
    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }

    public function representatives()
    {
        return $this->hasMany(RegionRepresentative::class);
    }
}
