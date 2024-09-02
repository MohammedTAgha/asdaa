<div>
    <div class="mb-4">
        <input type="text" class="form-input" placeholder="Search by ID or Name" wire:model.debounce.1000ms="searchTerm">
    </div>

    <div wire:loading class="mb-4">
        <p>Loading...</p>
    </div>

    @if(session()->has('error'))
        <div class="bg-red-100 text-red-700 p-2 mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div>
        <h3 class="text-lg font-semibold mb-2">Search Results</h3>
        <ul>
            @foreach($searchResults as $citizen)
                <li class="mb-2">
                    <button wire:click="addCitizen({{ $citizen->id }})" class="bg-blue-500 text-white p-2 rounded">
                        Add {{ $citizen->firstname }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="mt-4">
        <h3 class="text-lg font-semibold mb-2">Selected Citizens</h3>
        <ul>
            @foreach($selectedCitizens as $index => $citizen)
                <li class="mb-2">
                    <input type="checkbox" wire:click="toggleDone({{ $index }})" {{ $citizen['done'] ? 'checked' : '' }}>
                    {{ $citizen['firstname'] }}
                    <button wire:click="removeCitizen({{ $index }})" class="bg-red-500 text-white p-2 rounded">
                        Remove
                    </button>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="mt-4">
        <button wire:click="submit" class="bg-green-500 text-white p-2 rounded">Submit</button>
    </div>

    @if(session()->has('success'))
        <div class="bg-green-100 text-green-700 p-2 mt-4">
            {{ session('success') }}
        </div>
    @endif
</div>