<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class DistributionCitizensSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $distribution;

    public function __construct($distribution)
    {
        $this->distribution = $distribution;
    }

    public function collection()
    {
        return $this->distribution->citizens->map(function ($citizen) {
            $pivot = $citizen->pivot;
            return [
                'id' => $citizen->id,
                'firstname' => $citizen->firstname,
                'secondname' => $citizen->secondname,
                'thirdname' => $citizen->thirdname,
                'lastname' => $citizen->lastname,
                'family_members' => $citizen->family_members,
                'region_name' => $citizen->region->name ?? '',
                'quantity' => $pivot->quantity,
                'recipient' => $pivot->recipient,
                'note' => $pivot->note,
                'done' => $pivot->done,
                'date' => $pivot->date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Second Name',
            'Third Name',
            'Last Name',
            'Family Members',
            'Region Name',
            'Quantity',
            'Recipient',
            'Note',
            'Done',
            'Date',
        ];
    }

    public function title(): string
    {
        return 'Citizens';
    }
}