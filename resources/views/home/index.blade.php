@extends('dashboard')

@section('content')
    <div class="bg-gray-100 flex items-center justify-center mt-18">
        <div class="w-full max-w-lg py-6 px-8 bg-white rounded-lg shadow-md">
            <h1 class="mb-6 text-2xl font-bold text-center text-gray-700">استعلام عن البيانات</h1>
            <div>
                <!-- ID Field -->
                <div class="mb-4">
                    <label for="id" class="block mb-2 font-medium text-gray-700">الهوية</label>
                    <input type="text" id="id"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <!-- Name Fields Row -->
                <div class="flex flex-wrap -mx-2 mb-4">
                    <!-- First Name Field -->
                    <div class="w-full sm:w-1/2 lg:w-1/3 px-2 mb-4 sm:mb-0">
                        <label for="first_name" class="block mb-2 font-medium text-gray-700">First Name</label>
                        <input type="text" id="first_name"
                            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <!-- Second Name Field -->
                    <div class="w-full  sm:w-1/2 lg:w-1/3 px-2 mb-4 sm:mb-0">
                        <label for="second_name" class="block mb-2 font-medium text-gray-700">Second Name</label>
                        <input type="text" id="second_name"
                            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <!-- Third Name Field -->
                    <div class="w-full  sm:w-1/2 lg:w-1/3 mb-4 sm:mb-0">
                        <label for="third_name" class="block mb-2 font-medium text-gray-700">Third Name</label>
                        <input type="text" id="third_name"
                            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <!-- Last Name Field -->
                    <div class="w-full  sm:w-1/2 lg:w-1/3 px-2">
                        <label for="last_name" class="block mb-2 font-medium text-gray-700">Last Name</label>
                        <input type="text" id="last_name"
                            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="button" id="submitButton"
                        class="px-10 py-4 text-xl font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Submit</button>
                </div>
            </div>

            <!-- Modal -->
            <div id="modal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-75">
                <div class="w-full max-w-2xl p-6 bg-white rounded-lg shadow-lg">
                    <h2 class="mb-4 text-2xl font-bold text-center text-gray-700">Found Citizens</h2>
                    <div id="cardsContainer" class="space-y-4">
                        <!-- Cards will be appended here -->
                    </div>
                    <div class="flex justify-end mt-6">
                        <button id="closeModalButton"
                            class="px-4 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">Close</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @push('scripts')
        <script>
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
                            document.getElementById('modal').classList.remove('hidden');
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
    @endpush
@endsection
