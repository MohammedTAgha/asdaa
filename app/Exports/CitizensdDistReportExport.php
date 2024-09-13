<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
/*
* export a report of citizens addition to a distribution
*
* @param array $citizenIds
* @return \Illuminate\Database\Eloquent\Collection
*/
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
                'status' => 'تمت الإضافة',
                'count' =>$this->report['added']['count']
            ];
        }

        foreach ($this->report['existing']['citizens'] as $citizen) {

            $data[] = [
                'id' => $citizen['id'],
                'name' => $citizen['firstname'] . ' ' . $citizen['lastname'],
                'status' => 'موجود مسبقاً',
                'count' =>$this->report['existing']['count']
            ];
        }

        if(isset($this->report['updated'])){
            foreach ($this->report['updated']['citizens'] as   $citizen) {
                $data[] = [
                    'id' => $citizen['id'],
                    'name' => $citizen['firstname'] . ' ' . $citizen['lastname'],
                    'status' => 'محدث : موجود مسبقاً',
                    'count' =>$this->report['updated']['count']
                    
                    ];
            }
        }
        foreach ($this->report['nonexistent']['citizens'] as $citizenId) {
            $data[] = [
                'id' => $citizenId,
                'name' => 'غير محدد',
                'status' => 'غير موجود في البيانات',
                'count' =>$this->report['nonexistent']['count']

            ];
        }

        return new Collection($data);
    }

    public function headings(): array
    {
        return ['المعرف', 'الاسم', 'الحالة','cc'];
    }
}