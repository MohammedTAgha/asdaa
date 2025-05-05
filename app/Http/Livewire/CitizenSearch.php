<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Citizen;
use Illuminate\Support\Facades\Log;

class CitizenSearch extends Component
{
    public $searchId = '';
    public $searchName = '';
    public $isValid = false;
    public $errorMessage = '';
    public $citizens = [];
    public $searchType = 'id'; // 'id' or 'name'

    public function updatedSearchId()
    {
        if ($this->searchType === 'id') {
            $this->validateId();
        }
    }

    public function updatedSearchName()
    {
        if ($this->searchType === 'name' && strlen($this->searchName) >= 3) {
            $this->searchByName();
        }
    }

    public function setSearchType($type)
    {
        $this->searchType = $type;
        $this->reset(['searchId', 'searchName', 'citizens', 'errorMessage']);
    }

    public function searchCitizen()
    {
        if ($this->searchType === 'id') {
            $this->searchById();
        } else {
            $this->searchByName();
        }
    }

    protected function searchById()
    {
        try {
            if ($this->validateId()) {
                $citizen = Citizen::where('id', $this->searchId)->first();
                if ($citizen) {
                    $this->citizens = [$citizen];
                    $this->errorMessage = '';
                } else {
                    $this->errorMessage = 'لم يتم العثور على مواطن بهذا الرقم';
                    $this->citizens = [];
                }
            }
        } catch (\Exception $e) {
            $this->errorMessage = 'حدث خطأ في البحث';
        }
    }

    protected function searchByName()
    {
        if (strlen($this->searchName) < 3) {
            $this->errorMessage = 'يجب إدخال 3 أحرف على الأقل';
            return;
        }

        $searchTerms = explode(' ', $this->searchName);
        $query = Citizen::query();
        
        foreach ($searchTerms as $term) {
            $query->where(function($q) use ($term) {
                $q->where('firstname', 'like', "%{$term}%")
                    ->orWhere('secondname', 'like', "%{$term}%")
                    ->orWhere('thirdname', 'like', "%{$term}%")
                    ->orWhere('lastname', 'like', "%{$term}%");
            });
        }

        $this->citizens = $query->limit(10)->get();
        
        if ($this->citizens->isEmpty()) {
            $this->errorMessage = 'لم يتم العثور على نتائج';
        } else {
            $this->errorMessage = '';
        }
    }

    protected function validateId()
    {
        if (!preg_match('/^\d{9}$/', $this->searchId)) {
            $this->errorMessage = 'رقم الهوية يجب أن يتكون من 9 أرقام';
            $this->isValid = false;
            return false;
        }

        if (!$this->validateLuhn($this->searchId)) {
            $this->errorMessage = 'رقم الهوية غير صالح';
            $this->isValid = false;
            return false;
        }

        $this->isValid = true;
        $this->errorMessage = '';
        return true;
    }

    private function validateLuhn($id)
    {
        $sum = 0;
        $id = strrev($id);
    
        for ($i = 0; $i < 8; $i++) {
            $digit = (int) substr($id, $i, 1);
            if ($i % 2 === 1) {
                $doubled = $digit * 2;
                $sum += $doubled > 9 ? $doubled - 9 : $doubled;
            } else {
                $sum += $digit;
            }
        }
    
        $checkDigit = (10 - ($sum % 10)) % 10;
        return $checkDigit === (int) substr($id, 8, 1);
    }

    public function render()
    {
        return view('livewire.citizen-search');
    }
}
