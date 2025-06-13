<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionCitizen extends Model
{
    use  \App\Traits\LogsActivity;
    protected $table = 'distribution_citizens';
    protected $primaryKey='id';
    protected $fillable = [
        'distribution_id ',
        'citizen_id ',
        'quantity',
        'recipient',
        'note',
        'done',
        'date',
    ];

    

}