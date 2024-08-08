<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class CitizensdDistReportExport implements FromCollection, WithHeadings
{
    protected $report;

    public function __construct($report)
    {
        $this->report = $report;
    }

    public function collection()
    {
        $data = [];

        foreach ($this->report['added']['citizens'] as $citizen) {
            $data[] = [
                'id' => $citizen['id'],
                'name' => $citizen['firstname'] . ' ' . $citizen['lastname'],
                'status' => 'تمت الإضافة'
            ];
        }

        foreach ($this->report['existing']['citizens'] as $citizenId) {
            $data[] = [
                'id' => $citizenId,
                'name' => 'غير محدد',
                'status' => 'موجود مسبقاً'
            ];
        }

        foreach ($this->report['nonexistent']['citizens'] as $citizenId) {
            $data[] = [
                'id' => $citizenId,
                'name' => 'غير محدد',
                'status' => 'غير موجود'
            ];
        }

        return new Collection($data);
    }

    public function headings(): array
    {
        return ['المعرف', 'الاسم', 'الحالة'];
    }
}