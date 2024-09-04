<div>

    <!-- Modal Trigger Button -->
    <button class="btn btn-light-primary" wire:click="openModal">
        <i class="tf-icons ti ti-plus ti-xs me-1"></i>
        اضافة مستفيدين
    </button>

    <!-- Modal Background -->
    @if ($showModal)
        <div id="citizenModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="relative w-full max-w-2xl bg-white rounded-lg shadow-lg">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between px-4 py-2 border-b">
                        <h3 class="text-lg font-semibold text-gray-700">اضافة مستفيدين</h3>
                        <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-4">
                        <!-- Search Bar -->
                        <input type="text" class="form-input w-full mb-4 p-2 border rounded"
                            placeholder="Search by ID or Name" wire:model.debounce.1000ms="searchTerm">
                        <!-- Loading Indicator for Searching -->
                        <div wire:loading.delay class="text-blue-500">
                            يتم البحث...
                        </div>
                        <!-- Search Results -->
                        @if (!empty($searchResults))
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-600 mb-2">Search Results</h4>
                                <ul class="space-y-2">
                                    @foreach ($searchResults as $citizen)
                                        <li class="mb-2">
                                            {{ $citizen['firstname'] }} {{ $citizen['secondname'] }} {{ $citizen['lastname'] }} | {{$citizen['id']}} |
                                            <button wire:click="addCitizen({{ $citizen['id'] }})"
                                                class="bg-blue-500 text-white p-2 rounded">
                                                اضافة
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Selected Citizens -->
                        @if ($selectedCitizens)
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-600 mb-2">Selected Citizens</h4>
                                <ul class="space-y-2">
                                    @foreach ($selectedCitizens as $index => $citizen)
                                        <li class="flex items-center justify-between mb-">
                                            <div>
                                                <input type="checkbox" wire:click="toggleDone({{ $index }})"
                                                    {{ $citizen['done'] ? 'checked' : '' }} class="mr-2">
                                                    {{ $citizen['firstname'] }} {{ $citizen['secondname'] }} {{ $citizen['lastname'] }} | {{$citizen['id']}} |

                                            </div>
                                            <button wire:click="removeCitizen({{ $index }})"
                                                class="text-red-500 hover:text-red-700">حذف</button>
                                        </li>
                                        <div class="separator separator-dashed"></div>
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
    @endif
</div>
