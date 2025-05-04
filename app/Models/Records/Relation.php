<?php

namespace App\Models\Records;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    use HasFactory;

    protected $connection = 'sqlite';  // Specify the SQLite connection
    public $timestamps = false;

    public function person()
    {
        return $this->belongsTo(Person::class, 'CF_ID_NUM', 'CI_ID_NUM');
    }

    public function relative()
    {
        return $this->belongsTo(Person::class, 'CF_ID_RELATIVE', 'CI_ID_NUM');
    }

    public function getRelationNameAttribute()
    {
        $relations = [
            1 => 'اب',
            2 => 'ام',
            3 => 'ابن',
            4 => 'زوج/ة',
            5 => 'طلاق',
        ];
       
        
        return $relations[$this->CF_RELATIVE_CD] ?? 'Unknown';
    }
}
