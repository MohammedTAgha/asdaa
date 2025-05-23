<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CategoryMembersExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize, WithStyles
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->category->familyMembers()
            ->with(['citizen'])
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'Citizen ID',
            'Family Member Name',
            'Relationship',
            'Date of Birth',
            'Gender',
            'Notes',
            'Category Details',
            'Amount',
            'Size',
            'Date',
            'Property 1',
            'Property 2',
            'Property 3'
        ];
    }

    /**
     * @param mixed $familyMember
     * @return array
     */
    public function map($familyMember): array
    {
        return [
            $familyMember->id,
            $familyMember->citizen->id,
            $familyMember->firstname . ' ' . $familyMember->lastname,
            $familyMember->relationship,
            $familyMember->date_of_birth ? $familyMember->date_of_birth->format('Y-m-d') : '',
            $familyMember->gender,
            $familyMember->notes,
            $this->category->description,
            $this->category->amount,
            $this->category->size,
            $this->category->date ? $this->category->date->format('Y-m-d') : '',
            $this->category->property1,
            $this->category->property2,
            $this->category->property3
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Category - ' . $this->category->name;
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ]
        ];
    }
}
