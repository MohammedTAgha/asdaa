<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Citizen;
use App\Models\Distribution;

use Illuminate\Support\Facades\Log;

class AddCitizensToDistribution extends Component
{
    public $distributionId;
    public $searchTerm = '';
    public $selectedCitizens = [];
    public $searchResults = [];
    public $showModal = false;

    
    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

  // Handle search input updates
  public function updatedSearchTerm()
  {
      $this->searchCitizens();
  }

    public function searchCitizens()
    {
        $this->searchResults = Citizen::where('firstname', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('id', 'like', '%' . $this->searchTerm . '%')
            ->get()
            ->toArray();
    }

    public function addCitizen($citizenId)
    {
        $citizen = Citizen::find($citizenId);

        if ($citizen && !$this->isCitizenInDistribution($citizenId)) {
            $this->selectedCitizens[] = [
                'id' => $citizen->id,
                'firstname' => $citizen->firstname,
                'done' => false,
            ];
        } else {
            $this->dispatchBrowserEvent('citizen-already-in-distribution');
        }
    }

    public function render()
    {
        return view('livewire.add-citizens-to-distribution');
    }
}
