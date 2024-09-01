<?php

namespace App\Http\Livewire;


use Livewire\Component;
use App\Models\Citizen;

class CitizenAddToDistribution extends Component
{
    public $distributionId;
    public $search = '';
    public $selectedCitizens = [];
    public $citizenResults = [];

    public function updatedSearch()
    {
        $this->citizenResults = Citizen::where('id', 'like', "%{$this->search}%")
            ->orWhere('firstname', 'like', "%{$this->search}%")
            ->orWhere('lastname', 'like', "%{$this->search}%")
            ->take(10)
            ->get();
    }

    public function addCitizen($citizenId)
    {
        if (!in_array($citizenId, $this->selectedCitizens)) {
            $this->selectedCitizens[] = $citizenId;
        }
    }

    public function removeCitizen($citizenId)
    {
        $this->selectedCitizens = array_diff($this->selectedCitizens, [$citizenId]);
    }

    public function submit()
    {
        // Perform the logic to add the citizens to the distribution
        $this->emit('citizensAdded', $this->selectedCitizens, $this->distributionId);

        // Clear the modal after submission
        $this->reset('selectedCitizens', 'citizenResults', 'search');
    }

    public function render()
    {
        return view('livewire.citizen-add-to-distribution', [
            'citizens' => Citizen::whereIn('id', $this->selectedCitizens)->get(),
        ]);
    }
}