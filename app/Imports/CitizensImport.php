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
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Str;
class CitizensImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithEvents
{

     use Importable, SkipsFailures;
    public $failedRows = [];
    private $errors = [];
    private $regionId;
    private $regionRule;
    // Arabic to English header mapping
    private $headerMapping = [
        'رقم الهوية' => 'id',
        'الاسم الاول' => 'firstname',
        'اسم الاب' => 'secondname',
        'اسم الجد' => 'thirdname',
        'اسم العائلة' => 'lastname',
        'رقم الجوال' => 'phone',
        'رقم الجوال البديل' => 'phone2',
        'عدد الافراد' => 'family_members',
        'رقم هوية الزوجة' => 'wife_id',
        'اسم الزوجة رباعي' => 'wife_name',
        'عدد الذكور' => 'mails_count',
        'عدد الاناث' => 'femails_count',
        'عدد الافراد اقل من 3 سنوات' => 'leesthan3',
        'عدد الافراد ذوي الاحتياجات الخاصة' => 'obstruction',
        'وصف ذوي الاحتياجات الخاصة' => 'obstruction_description',
        'عدد الافراد ذوي الامراض المزمنة' => 'disease',
        'وصف ذوي الامراض المزمنة' => 'disease_description',
        'معيل الاسرة ( 1. لا يعمل , 2. عامل , 3. موظف )' => 'job',
        'حالة السكن ( 1. سيئ , 2. جيد ,3.ممتاز)' => 'living_status',
        'رقم المحافظة الاصلية' => 'original_governorate_id',
        'مكان السكن الاصلي' => 'original_address',
        'ملاحظات' => 'note',
        '2 ملاحظات' => 'note2',
        'الحالة الاجتماعية' => 'social_status',
        'تاريخ الميلاد' => 'date_of_birth',
        'الجنس'=>'gender',
        'عدد كبار السن'=>'elderly_count',

    ];

    private $slugToOriginal = [];

    public function __construct($regionId)
    {
        $this->regionId = $regionId;
        if ($regionId === null || $regionId === '') {
            Log::alert('region is null');
            Log::alert($regionId);
            $this->regionRule = 'required|exists:regions,id';
        } else {
            Log::alert('region is not null');
            $this->regionRule = 'nullable';
        }

        // Create a mapping of slugified headers to original headers
        foreach ($this->headerMapping as $arabicHeader => $englishColumn) {
            $slug = Str::slug($arabicHeader, '_');
            $this->slugToOriginal[$slug] = $arabicHeader;
        }
    }

    public function model(array $row)
    {
        $mappedRow = $this->mapRow($row);
        $regionId = $this->regionId ?? $mappedRow['region_id'] ?? 0;

        return new Citizen([
            'id' => $mappedRow['id'],
            'firstname' => $mappedRow['firstname'],
            'secondname' => $mappedRow['secondname'] ?? null,
            'thirdname' => $mappedRow['thirdname'] ?? null,
            'lastname' => $mappedRow['lastname'],
            'phone' => $mappedRow['phone'] ?? null,
            'phone2' => $mappedRow['phone2'] ?? null,
            'family_members' => $mappedRow['family_members'] ?? null,
            'wife_id' => $mappedRow['wife_id'] ?? null,
            'wife_name' => $mappedRow['wife_name'] ?? null,
            'mails_count' => $mappedRow['mails_count'] ?? null,
            'femails_count' => $mappedRow['femails_count'] ?? null,
            'leesthan3' => $mappedRow['leesthan3'] ?? null,
            'obstruction' => $mappedRow['obstruction'] ?? null,
            'obstruction_description' => $mappedRow['obstruction_description'] ?? null,
            'disease' => $mappedRow['disease'] ?? null,
            'disease_description' => $mappedRow['disease_description'] ?? null,
            'job' => $mappedRow['job'] ?? null,
            'living_status' => $mappedRow['living_status'] ?? null,
            'original_address' => $mappedRow['original_address'] ?? null,
            'note' => $mappedRow['note']?? null,
            'region_id' => $regionId,
            'social_status' => $mappedRow['social_status'] ?? null,
             'is_archived'=>$row['is_archived'] ?? 0
        ]);
    }

    private function mapRow(array $row)
    {
        $mappedRow = [];
        foreach ($row as $key => $value) {
            if (isset($this->slugToOriginal[$key])) {
                $originalHeader = $this->slugToOriginal[$key];
                $englishColumn = $this->headerMapping[$originalHeader];
                $mappedRow[$englishColumn] = $value;
            }
        }
        return $mappedRow;
    }

    public function rules(): array
    {
        return [
            'rkm_alhoy' => 'required|unique:citizens,id',
            'alasm_alaol' => 'required',
            'asm_alaaayl' => 'required',
            'region_id' => $this->regionRule,
        ];
    }

    public function customValidationMessages()
    {
        return [
            'rkm_alhoy.required' => 'الهوية مطلوبة.',
            'alasm_alaol.required' => 'الاسم الاول مطلوب.',
            'asm_alaaayl.required' => 'اسم العائلة مطلوب',
            'distinct' => 'لا يمكن : ان تكون مكررة.',
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
                'id' => $failure->values()['رقم الهوية'] ?? '',
                'firstname' => $failure->values()['الاسم الاول'] ?? '',
                'lastname' => $failure->values()['اسم العائلة'] ?? '',
                'attribute' => $failure->attribute(),
                'errors' => implode(', ', $failure->errors()),
                'values' => $failure->values()[$failure->attribute()] ?? ''
            ];
        }
    }


    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $this->errors = [];
            },
        ];
    }

}
