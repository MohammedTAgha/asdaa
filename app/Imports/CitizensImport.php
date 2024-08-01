<?php
namespace App\Imports;

use App\Models\Citizen;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class CitizensImport implements ToModel
{

    public function model(array $row)
    {

        return new Citizen([
            'id' => $row['id'],
            'firstname' => $row['firstname'],
            'secondname' => $row['secondname'],
            'thirdname' => $row['thirdname'],
            'lastname' => $row['lastname'],
            'date_of_birth' => $row['date_of_birth'],
            'gender' => $row['gender'],
            'region_id' => $row['region_id'],
            'wife_id' => $row['wife_id'],
            'wife_name' => $row['wife_name'],
            'widowed' => $row['widowed'],
            'social_status' => $row['social_status'],
            'living_status' => $row['living_status'],
            'job' => $row['job'],
            'original_address' => $row['original_address'],
            'elderly_count' => $row['elderly_count'],
            'note' => $row['note'],
        ]);
    }

}