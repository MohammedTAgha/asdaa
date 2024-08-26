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
use Maatwebsite\Excel\Validators\Failure;
class CitizensImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithEvents
{
    use SkipsFailures;
    public $failedRows = [];
    private $errors = [];
    private $regionId;
    private $regionRule;

    public function __construct($regionId = null)
    {
        $this->regionId = $regionId;
        if ($regionId==null || $regionId=='' ){
            $this->regionRule = 'required|exists:regions,id';
        }else{
            $this->regionRule='nullable';
        }
    }
    public function model(array $row)
    {
        $regionId = $this->regionId ?? $row['region_id'] ?? 0;
        return new Citizen([
            'id' => $row['id'],
            'firstname' => $row['firstname'],
            'secondname' => $row['secondname']??null,
            'thirdname' => $row['thirdname']??null,
            'lastname' => $row['lastname'],
            'phone' => $row['phone']??null,
            'phone2' => $row['phone2']??null,
            'family_members' => $row['family_members']??null,
            'wife_id' => $row['wife_id']??null,
            'wife_name' => $row['wife_name']??null,
            'mails_count' => $row['mails_count']??null,
            'femails_count' => $row['femails_count']??null,
            'leesthan3' => $row['leesthan3']??null,
            'obstruction' => $row['obstruction']??null,
            'obstruction_description' => $row['obstruction_description']??null,
            'disease' => $row['disease']??null,
            'disease_description' => $row['disease_description']??null,
            'job' => $row['job']??null,
            'living_status' => $row['living_status']??null,
            'original_address' => $row['original_address']??null,
            'note' => $row['note']??null,
            'region_id' =>  $regionId,

            //
            'social_status' => $row['social_status']??null,
            // 'date_of_birth' => $row['date_of_birth'],
            // 'gender' => $row['gender'],
            // 'elderly_count' => $row['elderly_count'],


        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'required|unique:citizens,id',
            'firstname' => 'required',
            'lastname' => 'required',
            'region_id' => $this->regionRule,
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
                'id' => $failure->values()['id'] ?? '',
                'firstname' => $failure->values()['firstname'] ?? '', // Adjust this based on your actual column name
                'lastname' => $failure->values()['lastname'] ?? '',
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