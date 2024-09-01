<div>
    <!-- Modal -->
    <div class="fixed z-10 inset-0 overflow-y-auto" x-show="open" @keydown.window.escape="open = false">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            
            <!-- Modal content -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full p-4">
                <h2 class="text-lg font-bold mb-4">Add Citizens to Distribution</h2>

                <!-- Search Bar -->
                <input 
                    type="text" 
                    wire:model="search" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring" 
                    placeholder="Search by ID or Name" />

                <!-- Search Results -->
                @if($citizenResults)
                    <ul class="mt-2 border border-gray-200 rounded-lg">
                        @foreach($citizenResults as $citizen)
                            <li class="p-2 hover:bg-gray-100 flex justify-between">
                                <span>{{ $citizen->firstname }} {{ $citizen->lastname }} (ID: {{ $citizen->id }})</span>
                                <button wire:click="addCitizen({{ $citizen->id }})" class="text-blue-500">Select</button>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <!-- Selected Citizens -->
                @if($selectedCitizens)
                    <div class="mt-4">
                        <h3 class="font-bold">Selected Citizens:</h3>
                        <ul class="mt-2">
                            @foreach($citizens as $citizen)
                                <li class="p-2 border rounded-lg flex justify-between">
                                    <span>{{ $citizen->firstname }} {{ $citizen->lastname }} (ID: {{ $citizen->id }})</span>
                                    <button wire:click="removeCitizen({{ $citizen->id }})" class="text-red-500">Remove</button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Submit Button -->
                <button wire:click="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg">Add to Distribution</button>
            </div>
        </div>
    </div>
</div>
