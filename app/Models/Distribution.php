<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
     // use HasFactory;
     protected $table='distributions';
     protected $primaryKey='id';
     protected $fillable = [
        'name',
        'date',
        'distribution_category_id',
        'arrive_date',
        'quantity',
        'target',
        'source',
        'done',
        'target_count',
        'expectation',
        'min_count',
        'max_count',
        'note'
        ];
    public function category()
    {
        return $this->belongsTo(DistributionCategory::class,'distribution_category_id');
    }

    public function citizens()
    {
        return $this->belongsToMany(Citizen::class, 'distribution_citizens')
        ->withPivot('id','quantity','recipient','note','done','date');
        
    }
}