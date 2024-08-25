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
    public $regionId =null ;
    public function __construct($regionId=null)
    {
        $this->regionId = $regionId;
    }
    
    public function model(array $row)
    {
        // Skip rows with empty or duplicate IDs

        // if (!isset($row['id']) || empty($row['id'])) {
        //     $this->failedRows[] = ['row' => $row, 'reason' => 'Empty ID'];
        //     return null;
        // }

        // if (Citizen::where('id', $row['id'])->exists()) {
        //     $this->failedRows[] = ['row' => $row, 'reason' => 'تكرر رقم الهوية'];
        //     return null;
        // }

        // if (empty($row['id']) || Citizen::where('id', $row['id'])->exists()) {
        //     $this->failedRows[] = [
        //         'row' => $row['id'] ?? 'no id ',
        //         'id' => $row['id'] ?? 'no id ',
        //         'firstname' => $row['firstname'] ?? '', // Adjust this based on your actual column name
        //         'lastname' => $row['lastname'] ?? '',
        //         'attribute' => 'الهوية',
        //         'errors' => empty($row['id']) ? 'Empty ID' : 'تكرر رقم الهوية',
        //         'values' => empty($row['id']) ? 'Empty ID' : 'تكرر رقم الهوية',  
        //         ];
        //     return null;
        // }
        $regionId =null;
        if($this->regionId ==null){
            $regionId ==null;
        }else{
            $regionId =$this->regionId;
        }
        return new Citizen([
            'id' => $row['رقم الهوية'],
            'firstname' => $row['الاسم الاول'],
            'secondname' => $row[' اسم الاب'],
            'thirdname' => $row['اسم الجد'],
            'lastname' => $row['اسم العائلة'],
            'phone' => $row['رقم الجوال'] ?? null,
            'phone2' => $row['رقم الجوال البديل']?? null,
            'family_members' => $row['عدد الأفراد']?? null,
            'wife_id' => $row['هوية الزوجة']?? null,
            'wife_name' => $row['اسم الزوجة رباعي']?? null,
            'mails_count' => $row['عدد الذكور']?? null,
            'femails_count' => $row['عدد الاناث']?? null,
            'leesthan3' => $row['عدد الافراد اقل من 3 سنوات']?? null,
            'obstruction' => $row['عدد الافراد ذوي الاحتياجات الخاصة']?? null,
            'obstruction_description' => $row['وصف الاحتياجات الخاصة']?? null,
            'disease' => $row['عدد الافراد ذوي الامراض المزمنة']?? null,
            'disease_description' => $row['وصف الامراض المزمنة']?? null,
            'job' => $row['العمل']?? null,
            'living_status' => $row['حالة السكن']?? null,
            'original_address' => $row['original_address']?? null,
            'note' => $row['note']?? null,
            'region_id' => $row['رقم المنطقة'],

            //
            'social_status' => $row['الحالة الاجتماعية'],
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