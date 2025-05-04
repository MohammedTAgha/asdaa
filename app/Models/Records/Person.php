<?php

namespace App\Models\Records;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Constraint\Count;

class Person extends Model
{
    use HasFactory;
    protected $primaryKey = 'CI_ID_NUM';
    public $timestamps = false;
    protected $table = 'persons';
    protected $connection = 'sqlite';  // Specify the SQLite connection

    public function relations()
    {
        return $this->hasMany(Relation::class, 'CF_ID_NUM', 'CI_ID_NUM');
    }
    public function fullName(){
        return  $this->CI_FIRST_ARB .' '. $this->CI_FATHER_ARB .' '. $this->CI_GRAND_FATHER_ARB  .' '.$this->CI_FAMILY_ARB;
    }

    public function getWifes(){
        if ($this->CI_PERSONAL_CD ==  "متزوج") {
            $wifes = Person::join('relations', 'persons.CI_ID_NUM', '=', 'relations.CF_ID_RELATIVE')
                ->where('relations.CF_ID_NUM', $this->CI_ID_NUM)
                ->where('relations.CF_RELATIVE_CD', '=', 4)
                ->select('persons.*')
                ->get();
            return $wifes;
        }
        return [];
    }

    public function getWife(){
        if ($this->CI_PERSONAL_CD ==  "متزوج") {
            $wife = Person::join('relations', 'persons.CI_ID_NUM', '=', 'relations.CF_ID_RELATIVE')
                ->where('relations.CF_ID_NUM', $this->CI_ID_NUM)
                ->where('relations.CF_RELATIVE_CD', '=', 4)
                ->select('persons.*')
                ->first();
            return $wife;
        }
        return null;
    }
    // Accessor to calculate age
    public function getAgeAttribute()
    {
        if ($this->CI_BIRTH_DT) {
            // Parse the date in DD/MM/YYYY format
            static $ages = [];
            $personId = $this->CI_ID_NUM;

            if (isset($ages[$personId])) {
                return $ages[$personId];
            }

            try {
                $birthDate = \DateTime::createFromFormat('d/m/Y', $this->CI_BIRTH_DT);
                if (!$birthDate) {
                    return null;
                }
                $ages[$personId] = $birthDate->diff(new \DateTime('now'))->y;
                return $ages[$personId];
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }

}
