<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    use  \App\Traits\LogsActivity;
    protected $table = 'committees';
    protected $fillable = ['name', 'manager_id', 'description', 'note'];

    public function manager()
    {
        return $this->belongsTo(Staff::class, 'manager_id');
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
}
