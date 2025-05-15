<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ImportReportSheet implements FromArray, WithTitle, ShouldAutoSize, WithStyles, WithHeadings
{
    protected $data;
    protected $title;
    protected $headers;

    public function __construct(array $data, string $title, array $headers)
    {
        $this->data = $data;
        $this->title = $title;
        $this->headers = $headers;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function headings(): array
    {
        return $this->headers;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

class ImportReportExport implements WithMultipleSheets
{
    protected $importResult;

    public function __construct(array $importResult)
    {
        $this->importResult = $importResult;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Summary Sheet
        $summaryData = [
            [
                'إجمالي السجلات' => $this->importResult['summary']['total_processed'],
                'تمت الإضافة' => $this->importResult['summary']['new_added'],
                'تم التحديث' => $this->importResult['summary']['updated'],
                'تم التخطي' => $this->importResult['summary']['skipped'],
                'فشل' => $this->importResult['summary']['failed'],
                'المنطقة المستهدفة' => $this->importResult['summary']['target_region'],
            ]
        ];
        $sheets[] = new ImportReportSheet(
            $summaryData,
            'ملخص',
            ['إجمالي السجلات', 'تمت الإضافة', 'تم التحديث', 'تم التخطي', 'فشل', 'المنطقة المستهدفة']
        );

        // Successful Imports Sheet
        if (!empty($this->importResult['successful_imports'])) {
            $successData = array_map(function ($row) {
                return [
                    'رقم الهوية' => $row['id'],
                    'الاسم' => $row['name'],
                    'المنطقة' => $row['region'],
                    'الحالة' => $row['status']
                ];
            }, $this->importResult['successful_imports']);

            $sheets[] = new ImportReportSheet(
                $successData,
                'تمت الإضافة',
                ['رقم الهوية', 'الاسم', 'المنطقة', 'الحالة']
            );
        }

        // Updated Citizens Sheet
        if (!empty($this->importResult['updated_citizens'])) {
            $updatedData = array_map(function ($row) {
                return [
                    'رقم الهوية' => $row['id'],
                    'الاسم' => $row['name'],
                    'المنطقة السابقة' => $row['old_region'],
                    'المنطقة الجديدة' => $row['new_region'],
                    'الحالة' => $row['status']
                ];
            }, $this->importResult['updated_citizens']);

            $sheets[] = new ImportReportSheet(
                $updatedData,
                'تم التحديث',
                ['رقم الهوية', 'الاسم', 'المنطقة السابقة', 'المنطقة الجديدة', 'الحالة']
            );
        }

        // Failed Imports Sheet
        if (!empty($this->importResult['failed_imports'])) {
            $failedData = array_map(function ($row) {
                return [
                    'الصف' => $row['row'],
                    'رقم الهوية' => $row['id'],
                    'الاسم' => $row['name'],
                    'السبب' => $row['error']
                ];
            }, $this->importResult['failed_imports']);

            $sheets[] = new ImportReportSheet(
                $failedData,
                'فشل الاستيراد',
                ['الصف', 'رقم الهوية', 'الاسم', 'السبب']
            );
        }

        return $sheets;
    }
} 