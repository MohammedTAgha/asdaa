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

    public function __construct($regionId = null)
    {
        $this->regionId = $regionId;
    }

    public function model(array $row)
    {
        // Handle Arabic headers by translating them to your column names
        $row = $this->translateHeaders($row);

        // Assign region_id from file or default to the one passed to the constructor
        $regionId = $this->regionId ?? $row['region_id'] ?? null;

        return new Citizen([
            'id' => $row['id'] ?? null,
            'firstname' => $row['firstname'] ?? null,
            'secondname' => $row['secondname'] ?? null,
            'thirdname' => $row['thirdname'] ?? null,
            'lastname' => $row['lastname'] ?? null,
            'phone' => $row['phone'] ?? null,
            'phone2' => $row['phone2'] ?? null,
            'family_members' => $row['family_members'] ?? null,
            'wife_id' => $row['wife_id'] ?? null,
            'wife_name' => $row['wife_name'] ?? null,
            'mails_count' => $row['mails_count'] ?? null,
            'femails_count' => $row['femails_count'] ?? null,
            'leesthan3' => $row['leesthan3'] ?? null,
            'obstruction' => $row['obstruction'] ?? null,
            'obstruction_description' => $row['obstruction_description'] ?? null,
            'disease' => $row['disease'] ?? null,
            'disease_description' => $row['disease_description'] ?? null,
            'job' => $row['job'] ?? null,
            'living_status' => $row['living_status'] ?? null,
            'original_address' => $row['original_address'] ?? null,
            'note' => $row['note'] ?? null,
            'region_id' => $regionId,
            'social_status' => $row['social_status'] ?? null,
            // 'date_of_birth' => $row['date_of_birth'] ?? null,
            // 'gender' => $row['gender'] ?? null,
            // 'elderly_count' => $row['elderly_count'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'required|unique:citizens,id',
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
                'id' => $failure->values()['id'] ?? '',
                'firstname' => $failure->values()['firstname'] ?? '',
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

    private function translateHeaders(array $row): array
    {
        return [
            'id' => $row['رقم الهوية'],
            'firstname' => $row['الاسم الاول'],
            'secondname' => $row[' اسم الاب'],
            'thirdname' => $row['اسم الجد'],
            'lastname' => $row['اسم العائلة'],
            'phone' => $row['رقم الجوال'] ?? null,
            'phone2' => $row['رقم الجوال البديل'] ?? null,
            'family_members' => $row['عدد الأفراد'] ?? null,
            'wife_id' => $row['هوية الزوجة'] ?? null,
            'wife_name' => $row['اسم الزوجة رباعي'] ?? null,
            'mails_count' => $row['عدد الذكور'] ?? null,
            'femails_count' => $row['عدد الاناث'] ?? null,
            'leesthan3' => $row['عدد الافراد اقل من 3 سنوات'] ?? null,
            'obstruction' => $row['عدد الافراد ذوي الاحتياجات الخاصة'] ?? null,
            'obstruction_description' => $row['وصف الاحتياجات الخاصة'] ?? null,
            'disease' => $row['عدد الافراد ذوي الامراض المزمنة'] ?? null,
            'disease_description' => $row['وصف الامراض المزمنة'] ?? null,
            'job' => $row['العمل'] ?? null,
            'living_status' => $row['حالة السكن'] ?? null,
            'original_address' => $row['العنوان الأصلي'] ?? null,
            'note' => $row['ملاحظات'] ?? null,
            'region_id' => $row['رقم المنطقة'],
        ];
    }
}
