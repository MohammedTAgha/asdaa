<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Citizen;
use App\Models\Distribution;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
class AddCitizensToDistribution extends Component
{
    public $distributionId;
    public $searchTerm = '';
    public $selectedCitizens = [];
    public $searchResults = [];
    public $showModal = false;

    // Open the modal
    public function openModal()
    {
        $this->showModal = true;
        Log::info('opened');
    }

    // Close the modal
    public function closeModal()
    {
        $this->showModal = false;
    }
    
    // Handle search input updates
    public function updatedSearchTerm()
    {
        $this->searchCitizens();
        // $this->dispatchBrowserEvent('search', ['term' => $this->searchTerm]);
    }

    // Search for citizens based on the search term
    public function searchCitizens()
    {
        
        $cacheKey = 'citizens_search_' . md5($this->searchTerm);
        
        $this->searchResults = Cache::remember($cacheKey, 60, function () {
            return Citizen::query()
                ->where(function ($query) {
                    $search = $this->searchTerm;
                    $searchTerms = explode(' ', $search);
                    $query->where(function ($q) use ($searchTerms, $search) {
                        // Full name search across name columns
                        $q->where(function ($nameQ) use ($searchTerms) {
                            foreach ($searchTerms as $term) {
                                $nameQ->where(function ($termQ) use ($term) {
                                    $termQ->where('firstname', 'like', '%' . $term . '%')
                                        ->orWhere('secondname', 'like', '%' . $term . '%')
                                        ->orWhere('thirdname', 'like', '%' . $term . '%')
                                        ->orWhere('lastname', 'like', '%' . $term . '%');
                                });
                            }
                        });
                        // Original single-term searches for other columns
                        $q->orWhere('wife_name', 'like', '%' . $search . '%')
                            ->orWhere('id', 'like', '%' . $search . '%')
                            ->orWhere('note', 'like', '%' . $search . '%');
                    });
                    
                })
                ->limit(10)
                ->get()
                ->toArray();
        });
    }

    // Add a citizen to the selected list
    public function addCitizen($citizenId)
    {
        $citizen = Citizen::find($citizenId);

        // Check if the citizen is already in the current distribution
        if ($citizen && !$this->isCitizenInDistribution($citizenId)) {
            // Check if the citizen is already selected
            if (!in_array($citizenId, array_column($this->selectedCitizens, 'id'))) {
                $this->selectedCitizens[] = [
                    'id' => $citizen->id,
                    'firstname' => $citizen->firstname,
                    'secondname' => $citizen->secondname,
                    'lastname' => $citizen->lastname,
                    'done' => false,
                ];
            } else {
                $this->dispatchBrowserEvent('citizenAdded');
                
            }
        } else {
            $this->dispatchBrowserEvent('citizenAdded');

        }
    }

    // Check if a citizen is already in the distribution
    public function isCitizenInDistribution($citizenId)
    {
        return Distribution::find($this->distributionId)
            ->citizens()
            ->where('citizen_id', $citizenId)
            ->exists();
    }

    // Remove a citizen from the selected list
    public function removeCitizen($index)
    {
        unset($this->selectedCitizens[$index]);
        $this->selectedCitizens = array_values($this->selectedCitizens); // Reindex array
    }

    // Toggle the 'done' property of a selected citizen
    public function toggleDone($index)
    {
        $this->selectedCitizens[$index]['done'] = !$this->selectedCitizens[$index]['done'];
    }

    // Submit the selected citizens to the distribution
    public function submit()
    {
        $distribution = Distribution::find($this->distributionId);

        if ($distribution) {
            foreach ($this->selectedCitizens as $citizen) { // nd t chck ach 
                if ($citizen && !$this->isCitizenInDistribution($citizen['id'])) {
                $distribution->citizens()->attach($citizen['id'], ['done' => $citizen['done']]);
                }
            }
            $this->selectedCitizens=[];
            $this->closeModal();
            $this->dispatchBrowserEvent('citizenAdded');

            // $this->dispatchBrowserEvent('citizens-added-successfully');
        }
    }

    public function render()
    {
        return view('livewire.add-citizens-to-distribution');
    }
}
