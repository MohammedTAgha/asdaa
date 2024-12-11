<?php

namespace App\Exports;

use App\Services\DistributionReportService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class DistributionDetailsSheet implements FromArray, WithTitle
{
    protected $distribution;
    protected $distributionStatsService ;
    public function __construct($distribution )
    {
        $this->distribution = $distribution;
        
    }

    public function array(): array
    {
        $stats = $this->calculateStats();

        return [
            ['التفاصيل'],
            ['رقم', $this->distribution->id],
            ['التفاصيل', $this->distribution->name],
            ['التاريخ', $this->distribution->date],
            ['الفئة', $this->distribution->category->name ?? ''],
            ['تاريخ التوريد', $this->distribution->arrive_date],
            ['الكمية', $this->distribution->quantity],
            ['المتهدفة', $this->distribution->target],
            ['المصدر', $this->distribution->source->name ?? ''],
            ['الاكتمال', $this->distribution->done ? 'Yes' : 'No'],
            ['عدد المستهدفين المحتملين', $this->distribution->target_count],
            ['عدد الفئة المستهدفة', $this->distribution->expectation],
            ['اقل عدد للاسرة', $this->distribution->min_count],
            ['اقصى عدد للاسرة', $this->distribution->max_count],
            ['ملاحظات', $this->distribution->note],
            ['-------'],
            ['الاحصائيات'],
            ['النسبة ', $stats['benefated_percentage']],
            ['تم استلامهم', $stats['completed_distributions']],
            ['اجمالي المستهدفين', $stats['total_citizens']],
            ['عدد الكمة الموزعة', $stats['total_quantity']],
          
        ];
    }

    private function calculateStats(): array
    {
        $citizens = $this->distribution->citizens;
        $citizens_count = count($citizens);
        $benafated_count =$citizens->where('pivot.done', 1)->count();
        if ($citizens_count !=0){
            $percentage =  ($benafated_count /$citizens_count)*100 ;
        }else{
            $percentage = 0;
        }

        return [
            'benafated'=> $benafated_count,
            'citizens_count'=> $citizens_count ,
            'total_citizens' => $citizens->count(),
            'benefated_percentage'=>$percentage,
            'total_quantity' => $citizens->sum('pivot.quantity'),
            'avg_quantity' => $citizens->avg('pivot.quantity'),
            'completed_distributions' => $citizens->where('pivot.done', 1)->count(),
        ];
    }

    public function title(): string
    {
        return 'تفاصيل التوزيع';
    }
}