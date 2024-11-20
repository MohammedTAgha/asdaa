
@extends('dashboard')

@section('content')
    {{-- <livewire:citizen-search />
    @push('scripts')
        <script>
            const modal = new bootstrap.Modal(document.getElementById('citizenModal'));
            console.log('ccc');
            $(document).ready(function() {
                $('#submitButton').click(function() {
                    console.log('ccc');
                    var id = $('#id').val();
                    var first_name = $('#first_name').val();
                    var second_name = $('#second_name').val();
                    var third_name = $('#third_name').val();
                    var last_name = $('#last_name').val();

                    $.ajax({
                        url: '/citizens', // Use the resource route for citizens
                        type: 'GET',
                        data: {
                            id: id,
                            first_name: first_name,
                            second_name: second_name,
                            third_name: third_name,
                            last_name: last_name,
                            returnjson: 1,
                        },
                        success: function(response) {
                            // Handle the response data here
                            //document.getElementById('modal').classList.remove('hidden');
                            modal.show();
                            console.log(response);
                            const cardsContainer = document.getElementById('cardsContainer');
                            cardsContainer.innerHTML = ''; // Clear previous content
                            response.forEach(citizen => {
                                const card = document.createElement('div');
                                card.className = 'p-4 bg-gray-100 rounded-lg shadow';
                                card.innerHTML = `
                                <div>
                                <a href="/citizens/${citizen.id}">
                                <p><strong>الهوية:</strong> ${citizen.id}</p>
                                <p><strong>الاسم:</strong> ${citizen.firstname} ${citizen.secondname} ${citizen.thirdname} ${citizen.lastname}</p>
                                <p><strong>تاريخ الميلاد:</strong> ${citizen.date_of_birth}</p>
                                <p><strong>الجنس:</strong> ${citizen.gender}</p>
                                <p><strong>الزوجة:</strong> ${citizen.wife_name}</p>
                                <p><strong>رقم المنقطة:</strong> ${citizen.region_id}</p>
                                <p><strong>العمل:</strong> ${citizen.job}</p>
                                <p><strong>الحالة الاجتماعية:</strong> ${citizen.living_status}</p>
                                <p><strong>Note:</strong> ${citizen.note}</p>
                                </div>
                                </a>
                            `;
                                cardsContainer.appendChild(card);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });
            });

            document.getElementById('closeModalButton').addEventListener('click', function() {
                document.getElementById('modal').classList.add('hidden');
            });
        </script>
    @endpush --}}

    <div class="container">
        <h1>Search Citizens</h1>
        
        <!-- Search Form -->
        <form action=" " method="GET">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- General Search Input -->
                <div>
                    <label for="general_search" class="block text-sm font-medium text-gray-700">General Search</label>
                    <input type="text" id="general_search" name="general_search" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Search for citizens...">
                </div>
    
                <!-- Person Custom Search -->
                <div>
                    <label for="person_id" class="block text-sm font-medium text-gray-700">Person ID</label>
                    <input type="text" id="person_id" name="person_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Person ID">
                </div>
                
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="First Name">
                </div>
                
                <div>
                    <label for="second_name" class="block text-sm font-medium text-gray-700">Second Name</label>
                    <input type="text" id="second_name" name="second_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Second Name">
                </div>
    
                <div>
                    <label for="third_name" class="block text-sm font-medium text-gray-700">Third Name</label>
                    <input type="text" id="third_name" name="third_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Third Name">
                </div>
    
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Last Name">
                </div>
    
                <!-- Wife ID -->
                <div>
                    <label for="wife_id" class="block text-sm font-medium text-gray-700">Wife ID</label>
                    <input type="text" id="wife_id" name="wife_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Wife ID">
                </div>
    
                <!-- Region Search -->
                <div>
                    <label for="region" class="block text-sm font-medium text-gray-700">Region</label>
                    <select id="region" name="region" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select a Region</option>
                        <!-- Assume you have a list of regions from the database -->
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
    
                <!-- Submit Button -->
                <div class="col-span-2">
                    <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700">Search</button>
                </div>
            </div>
        </form>
    </div>
    
@endsection
