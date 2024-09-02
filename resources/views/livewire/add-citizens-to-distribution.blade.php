<div>
    <!-- Modal Trigger Button -->
    <button class="btn btn-light-primary" onclick="openModal()">
        Add Citizens to Distribution
    </button>

    <!-- Modal Background -->
    <div id="citizenModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="relative w-full max-w-2xl bg-white rounded-lg shadow-lg">
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-4 py-2 border-b">
                    <h3 class="text-lg font-semibold text-gray-700">Add Citizens to Distribution</h3>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="p-4">
                    <!-- Search Bar -->
                    <input type="text" class="form-input w-full mb-4 p-2 border rounded" placeholder="Search by ID or Name" wire:model="searchTerm">

                    <!-- Search Results -->
                    @if(!empty($searchResults))
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-600 mb-2">Search Results</h4>
                            <ul class="space-y-2">
                                @foreach($searchResults as $citizen)
                                    <li>
                                      
                                        <button wire:click="addCitizen({{ $citizen->id }})" class="w-full text-left bg-blue-100 hover:bg-blue-200 p-2 rounded">
                                            {{ $citizen->firstname }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Selected Citizens -->
                    @if($selectedCitizens)
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-600 mb-2">Selected Citizens</h4>
                            <ul class="space-y-2">
                                @foreach($selectedCitizens as $index => $citizen)
                                    <li class="flex items-center justify-between">
                                        <div>
                                            <input type="checkbox" wire:click="toggleDone({{ $index }})" {{ $citizen['done'] ? 'checked' : '' }} class="mr-2">
                                            {{ $citizen['firstname'] }}
                                        </div>
                                        <button wire:click="removeCitizen({{ $index }})" class="text-red-500 hover:text-red-700">Remove</button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Modal Footer -->
                <div class="px-4 py-2 border-t flex justify-end">
                    <button wire:click="submit" class="bg-green-500 text-white py-2 px-4 rounded">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Scripts -->
<script>
    function openModal() {
        document.getElementById('citizenModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('citizenModal').classList.add('hidden');
    }
</script>
