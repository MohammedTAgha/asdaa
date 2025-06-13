<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use  \App\Traits\LogsActivity;
    protected $table = 'staff';

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['name', 'phone', 'image', 'committee_id','user_id'];

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isManager()
    {
        return $this->hasOne(Committee::class, 'manager_id');
    }
}
