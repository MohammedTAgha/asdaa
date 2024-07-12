<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function distributions()
    {
        return $this->belongsToMany(Distribution::class, 'distribution_citizens');
    }
}