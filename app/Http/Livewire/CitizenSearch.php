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
        $id = strrev($id); // Reverse the string to iterate from right to left
    
        for ($i = 0; $i < 8; $i++) {
            $digit = (int) substr($id, $i, 1); // Extract each digit
            if ($i % 2 === 1) { // Note: We changed this condition because we reversed the string
                $doubled = $digit * 2;
                $sum += $doubled > 9 ? $doubled - 9 : $doubled;
            } else {
                $sum += $digit;
            }
        }
    
        $checkDigit = (10 - ($sum % 10)) % 10;
        return $checkDigit === (int) substr($id, 8, 1); // Compare with the last digit
    }

    public function render()
    {
        return view('livewire.citizen-search');
    }
}
