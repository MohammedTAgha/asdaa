<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $connection = 'sqlite'; 
    protected $primaryKey = 'CI_ID_NUM';
    public $timestamps = false;
    protected $table = 'persons';
    // public function relations()
    // {
    //     return $this->hasMany(Relation::class, 'CF_ID_NUM', 'CI_ID_NUM');
    // }

    // Accessor to calculate age
    public function getAgeAttribute()
    {
        if ($this->CI_BIRTH_DT) {
            // Parse the date in DD/MM/YYYY format
            try {
                $birthDate = Carbon::createFromFormat('d/m/Y', $this->CI_BIRTH_DT);
                return $birthDate->age;
            } catch (\Exception $e) {
                // Return null if the date format is invalid
                return null;
            }
        }

        return null; // Return null if CI_BIRTH_DT is not set
    }

}
