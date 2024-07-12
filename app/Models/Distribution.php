<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    public function category()
    {
        return $this->belongsTo(DistributionCategory::class);
    }

    public function citizens()
    {
        return $this->belongsToMany(Citizen::class, 'distribution_citizens');
    }
}