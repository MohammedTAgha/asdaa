<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FailedRowsExport implements FromArray, WithHeadings
{
    protected $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function headings(): array
    {
        // Adjust these headings based on your data structure
        return [
            'Row',
            'Attribute',
            'Error',
            'Value',
        ];
    }
}