<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Citizen;
use App\Models\Distribution;

class AddCitizensToDistribution extends Component
{
    public $distributionId;
    public $searchTerm = '';
    public $selectedCitizens = [];
    public $searchResults = [];
    
    public function updatedSearchTerm()
    {
        $this->searchResults = Citizen::where('firstname', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('id', 'like', '%' . $this->searchTerm . '%')
            ->get(); // This ensures it's treated as an array
    }


    public function addCitizen($citizenId)
    {
        $citizen = Citizen::find($citizenId);

        if (Distribution::find($this->distributionId)->citizens()->where('citizens.id', $citizenId)->exists()) {
            session()->flash('error', 'Citizen is already in this distribution.');
            return;
        }

        if (!in_array($citizenId, array_column($this->selectedCitizens, 'id'))) {
            $this->selectedCitizens[] = [
                'id' => $citizen->id,
                'firstname' => $citizen->firstname,
                'done' => false
            ];
        }
    }

    public function removeCitizen($index)
    {
        unset($this->selectedCitizens[$index]);
        $this->selectedCitizens = array_values($this->selectedCitizens);
    }

    public function toggleDone($index)
    {
        $this->selectedCitizens[$index]['done'] = !$this->selectedCitizens[$index]['done'];
    }

    public function submit()
    {
        $distribution = Distribution::find($this->distributionId);

        foreach ($this->selectedCitizens as $citizen) {
            $distribution->citizens()->attach($citizen['id'], ['done' => $citizen['done']]);
        }

        session()->flash('success', 'Citizens added to the distribution.');
        $this->reset(['searchTerm', 'selectedCitizens', 'searchResults']);
    }

    public function render()
    {
        return view('livewire.add-citizens-to-distribution');
    }
}