<?php

namespace App\Exports;

use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use App\Traits\LogsExports;

class CitizensDetailedExport implements WithMultipleSheets
{
    use LogsExports;

    protected $citizens;

    public function __construct($citizens)
    {
        $this->citizens = $citizens;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        
        // Group citizens by region
        $citizensByRegion = $this->citizens->groupBy('region_id');
        
        // Create a sheet for each region
        foreach ($citizensByRegion as $regionId => $regionCitizens) {
            $regionName = $regionCitizens->first()->region->name ?? 'غير محدد';
            $sheets[] = new CitizensSheet($regionCitizens, $regionName);
        }
        
        return $sheets;
    }
}

class CitizensSheet implements FromCollection, WithHeadings, WithStyles
{
    protected $citizens;
    protected $sheetName;

    public function __construct($citizens, $sheetName)
    {
        $this->citizens = $citizens;
        $this->sheetName = $sheetName;
    }

    public function collection()
    {
        return $this->citizens->map(function ($citizen) {
            return [
                $citizen->id,
                $citizen->fullName ?? null,
                $citizen->firstname,
                $citizen->secondname,
                $citizen->thirdname,
                $citizen->lastname,
                $citizen->phone,
                $citizen->phone2,
                $citizen->wife_id,
                $citizen->wife_name,
                $citizen->family_members,
                $citizen->mails_count,
                $citizen->femails_count,
                $citizen->social_status,
                $citizen->original_address,
                $citizen->disease_description,
                $citizen->note,
                $citizen->leesthan3,
                $citizen->disease,
                $citizen->obstruction,
                $citizen->job,
                $citizen->living_status,
                $citizen->obstruction_description,
                $citizen->original_address,
                $citizen->elderly_count,
                $citizen->date_of_birth,
                $citizen->gender,
                $citizen->categoryString,
                $citizen->is_archived,
                $citizen->region->representatives->first()->name ?? 'مندوب غير محدد',
                $citizen->region ? $citizen->region->name : null,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'رقم الهوية',
            ' الاسم رباعي',
            'الاسم الاول',
            'اسم الاب',
            'اسم الجد',
            'اسم العائلة',
            'رقم الجوال',
            'رقم الجوال البديل',
            'رقم هوية الزوجة',
            'اسم الزوجة رباعي',
            'عدد الافراد',
            'عدد الذكور',
            'عدد الاناث',
            'الحالة الاجتماعية',
            'مكان السكن الاصلي',
            'وصف ذوي الامراض المزمنة',
            'ملاحظات',
            'عدد الافراد اقل من 3 سنوات',
            'عدد الافراد ذوي الامراض المزمنة',
            'عدد الافراد ذوي الاحتياجات الخاصة',
            'معيل الاسرة ( 1. لا يعمل , 2. عامل , 3. موظف )',
            'حالة السكن ( 1. سيئ , 2. جيد ,3.ممتاز)',
            'وصف ذوي الاحتياجات الخاصة',
            'مكان السكن الاصلي',
            'عدد كبار السن',
            'تاريخ الميلاد',
            'الجنس',
            'التصنيفات',
            'is_archived',
            'المندوب',
            'المنظقة',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set sheet direction to right-to-left
        $sheet->getStyle('A1:AD1')->getAlignment()->setHorizontal('right');

        // Apply bold styling to the header row and set background color
        return [
            // Styling for header row
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4CAF50'], // Green background
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function title(): string
    {
        return $this->sheetName;
    }
} 