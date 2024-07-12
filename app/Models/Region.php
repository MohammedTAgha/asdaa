<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }

    public function representatives()
    {
        return $this->hasMany(RegionRepresentative::class);
    }
}
