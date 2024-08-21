<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;
    protected $table= 'sources';
    protected $fillable = ['name', 'phone', 'email'];


     // Define the relationship with Distribution
     public function distributions()
     {
         return $this->hasMany(Distribution::class);
     }

}