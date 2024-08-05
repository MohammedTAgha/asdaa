<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FailedRowsExport implements FromArray, WithHeadings
{
    protected $rows;

    public function __construct(array $rows)
    {
        $this->rows = $this->formatRows($rows);
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'id',
            'firstname',
            'Attribute',
            'Error',
            'Value'
        ];
    }

    private function formatRows(array $rows): array
    {
        $formattedRows = [];
        foreach ($rows as $row) {
            $formattedRows[] = [
                $row['row'] ?? '', // This will be the 'id'
                $row['firstname'] ?? '', // You need to ensure this data is available
                $row['attribute'] ?? '',
                $row['errors'] ?? '',
                $row['values'] ?? ''
            ];
        }
        return $formattedRows;
    }
}