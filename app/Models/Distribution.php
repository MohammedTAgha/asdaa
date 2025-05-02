<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'source_id',
        'done',
        'pakages_count',
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

    // Define the relationship with Source
    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function citizensCount()
    {
        return $this->citizens()->count();
    }

    public function getRegionsSummary()
    {
        return DB::table('citizens')
            ->join('distribution_citizens', 'citizens.id', '=', 'distribution_citizens.citizen_id')
            ->join('regions', 'citizens.region_id', '=', 'regions.id')
            ->where('distribution_citizens.distribution_id', $this->id)
            ->whereNull('citizens.deleted_at')
            ->select(
                'regions.name',
                DB::raw('count(DISTINCT citizens.id) as count'),
                DB::raw('SUM(CASE WHEN distribution_citizens.done = 1 THEN 1 ELSE 0 END) as completed'),
                DB::raw('SUM(distribution_citizens.quantity) as total_quantity')
            )
            ->groupBy('regions.name', 'distribution_citizens.distribution_id', 'distribution_citizens.citizen_id', 'distribution_citizens.id', 'distribution_citizens.quantity', 'distribution_citizens.recipient', 'distribution_citizens.note', 'distribution_citizens.done', 'distribution_citizens.date')
            ->orderBy('count', 'desc')
            ->get();
    }
}
