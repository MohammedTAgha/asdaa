<?php

namespace App\Imports;

use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Illuminate\Support\Collection;

class CitizensImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithEvents
{
    use SkipsFailures;
    public $failedRows = [];
    private $errors = [];

    public function model(array $row)
    {
        // Skip rows with empty or duplicate IDs

        if (!isset($row['id']) || empty($row['id'])) {
            $this->failedRows[] = ['row' => $row, 'reason' => 'Empty ID'];
            return null;
        }

        if (Citizen::where('id', $row['id'])->exists()) {
            $this->failedRows[] = ['row' => $row, 'reason' => 'Duplicate ID'];
            return null;
        }

        if (empty($row['id']) || Citizen::where('id', $row['id'])->exists()) {
            $this->errors[] = [
                'row' => $row,
                'reason' => empty($row['id']) ? 'Empty ID' : 'Duplicate ID',
            ];
            return null;
        }

        return new Citizen([
            'id' => $row['id'],
            'firstname' => $row['firstname'],
            'secondname' => $row['secondname'],
            'thirdname' => $row['thirdname'],
            'lastname' => $row['lastname'],
            'phone' => $row['phone'],
            'family_members' => $row['family_members'],
            'wife_id' => $row['wife_id'],
            'wife_name' => $row['wife_name'],
            'date_of_birth' => $row['date_of_birth'],
            'gender' => $row['gender'],
            'elderly_count' => $row['elderly_count'],
            'obstruction' => $row['obstruction'],
            'obstruction_description' => $row['obstruction_description'],
            'disease' => $row['disease'],
            'disease_description' => $row['disease_description'],
            'job' => $row['job'],
            'living_status' => $row['living_status'],
            'social_status' => $row['social_status'],
            'original_address' => $row['original_address'],
            'region_id' => $row['region_id'],
            'note' => $row['note'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.id' => 'required|distinct',
            'firstname' => 'required',
            'lastname' => 'required',
            'region_id' => 'required|exists:regions,id',
        ];
    }


    public function customValidationMessages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'distinct' => 'The :attribute field has a duplicate value.',
        ];
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->failedRows[] = [
                'row' => $failure->row(),
                'fullname' => $failure->values()['fullname'] ?? '', // Adjust this based on your actual column name
                'attribute' => $failure->attribute(),
                'errors' => implode(', ', $failure->errors()),
                'values' => $failure->values()[$failure->attribute()] ?? ''
            ];
        }
    }
    
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $event) {
                $this->errors = [];
            },
        ];
    }
}