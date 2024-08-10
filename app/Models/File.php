<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public $table = 'files';

    public $fillable = [
        'name',
        'path',
        'hidden'
    ];

    protected $casts = [
        'name' => 'string',
        'path' => 'string',
        'hidden' => 'boolean'
    ];

    public static array $rules = [
        
    ];

    
}
