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

    private $errors = [];

    public function model(array $row)
    {
        // Skip rows with empty or duplicate IDs
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

    public function rules(): array
    {
        return [
            '*.id' => 'required|distinct',
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

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $event) {
                $this->errors = [];
            },
        ];
    }
}