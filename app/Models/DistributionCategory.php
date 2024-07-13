<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionCategory extends Model
{
    protected $table='distribution_categories';
    protected $primaryKey='id';
    protected $fillable = [
        'name',
        'description'

    ];
    public function distributions()
    {
        return $this->hasMany(Distribution::class);
    }
}