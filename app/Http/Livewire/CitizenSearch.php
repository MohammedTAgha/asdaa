<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Citizen; // Assuming you have a Citizen model

class CitizenSearch extends Component
{
    public $searchId = '';
    public $isValid = false;
    public $errorMessage = '';
    public $citizen = null;

    public function updatedSearchId()
    {
        $this->validate();
    }

    public function searchCitizen()
    {
        $this->validate();

        if ($this->isValid) {
            $this->citizen = Citizen::where('id', $this->searchId)->first();
            if (!$this->citizen) {
                $this->errorMessage = 'Citizen not found';
            }
        }
    }

    public function rules()
    {
        return [
            'searchId' => [
                'required',
                'string',
                'size:9',
                'regex:/^\d{9}$/',
                function ($attribute, $value, $fail) {
                    if (!$this->validateLuhn($value)) {
                        $fail('Invalid ID');
                    } else {
                        $this->isValid = true;
                    }
                },
            ],
        ];
    }

    private function validateLuhn($id)
    {
        $sum = 0;
        for ($i = 0; $i < 8; $i++) {
            $digit = (int) $id[$i];
            if ($i % 2 === 0) {
                $sum += $digit;
            } else {
                $doubled = $digit * 2;
                $sum += $doubled > 9 ? $doubled - 9 : $doubled;
            }
        }

        $checkDigit = (10 - ($sum % 10)) % 10;
        return $checkDigit === (int) $id[8];
    }

    public function render()
    {
        return view('livewire.citizen-search');
    }
}
