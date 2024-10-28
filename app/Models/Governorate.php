<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function citizens()
    {
        return $this->hasMany(Citizen::class, 'original_governorate_id');
    }
}