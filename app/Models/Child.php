<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Child extends Model
{
    // use HasFactory;
    protected $table='childrens';
    protected $primaryKey='id';
    public $incrementing=false;

    protected $fillable = [
    'id',
    'name',
    'date_of_birth',
    'gender',
    'citizen_id',
    'orphan',
    'infant',
    'bambers_size',
    'disease',
    'disease_description',
    'obstruction',
    'obstruction_description',
    'note',
    ];
    
    public function citizen() //father
    {
        return $this->belongsTo(Citizen::class);
    }

    public function age()
    {
        return \Carbon\Carbon::parse($this->date_of_birth)->age;
    }
}