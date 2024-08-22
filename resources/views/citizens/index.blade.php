@extends('dashboard')

@section('topbar')
    {{-- @component('components.toolbar', ['title' => 'المواطنين'])
        <div class="relative flex items-center justify-between p-2 px-6">
            <!-- Search Input -->
            <form method="GET" action="{{ route('citizens.index') }}">
                <div class="flex items-center w-full me-6">
                    <input type="text" name="search" placeholder=" بحث عام..."
                        class="w-full me-2 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="px-4 py-3 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">بحث</button>

                </div>
            </form>
            <!-- Filter Button -->
            <div class="ml-4 relative">
                <button id="filterButton"
                    class="px-4 py-3 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Filters</button>
                <!-- Filter Popup Menu -->
                <div id="filterMenu"
                    class="absolute right-0 z-10 hidden w-80 p-4 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg">
                    <!-- Header -->
                    <div class="pb-2 mb-2 border-b border-gray-200">
                        <div class="text-lg font-semibold text-gray-700">خيارات التصنيف</div>
                    </div>
                    <!-- Filter Form -->
                    <form action="{{ route('citizens.index') }}" method="GET">
                        <!-- Prepositives -->
                        <div class="mb-4">
                            <label class="block mb-1 font-medium text-gray-700">اختر المناديب:</label>
                            <select id="regions" name="regions[]"
                                class="select2-multiple p-2 border border-gray-300 rounded-lg" style="width: 260px;" multiple>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}"
                                        {{ in_array($region, request('regions', [])) ? 'selected' : '' }}>

                                        @if ($region->representatives->isNotEmpty())
                                            {{ $region->name }} </br> :
                                            {{ $region->representatives->first()->name }}
                                        @else
                                            {{ $region->name }}
                                        @endif

                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Living Status -->
                        <div class="mb-4">
                            <label class="block mb-1 font-medium text-gray-700">حالة السكن ل:</label>
                            <select id="living_status" name="living_status"
                                class="w-full p-2 border border-gray-300 rounded-lg">
                                <option value="">غير محدد</option>
                                <option value="1">سيئ</option>
                                <option value="2">جيد</option>
                                <option value="3">ممتاز</option>
                            </select>
                        </div>
                        <!-- Social Status -->
                        <div class="mb-4">
                            <label class="block mb-1 font-medium text-gray-700">الحالة الاجنماعية :</label>
                            <select id="social_status" name="social_status"
                                class="w-full p-2 border border-gray-300 rounded-lg">
                                <option value="">غير محدد</option>
                                <option value="0">اعزب</option>
                                <option value="1">متزوج</option>
                                <option value="2">ارمل</option>
                                <option value="3">متعدد</option>
                                <option value="4">مطلق</option>
                                <option value="5">زوجة 1</option>
                                <option value="6">زوجة 2</option>
                                <option value="7">زوجة 3</option>
                                <option value="8">زوجة 4</option>

                            </select>
                        </div>
                        <!-- Gender -->
                        <div class="mb-4">
                            <label class="block mb-1 font-medium text-gray-700">الجنس:</label>
                            <select id="gender" name= "gender" class="w-full p-2 border border-gray-300 rounded-lg">
                                <option value="">غير محدد</option>
                                <option value="0">ذكر</option>
                                <option value="1">انثى</option>
                            </select>
                        </div>
                        <!-- Actions -->
                        <div class="flex justify-end">
                            <button id="close" type="button"
                                class="px-4 py-2 mr-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                اغلاق</button>
                            <button id="applyFilters" type="submit"
                                class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">تطبيق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @slot('side')
        <button id="openModalButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            add excel
        </button>
            <a href="{{ route('citizens.create') }}" class="btn btn-sm btn-primary">اضافة جديد</a>
        @endslot
    @endcomponent --}}
@endsection

@section('styles')

@endsection
@section('content')
    <div>
        @if (session('import_result'))
            <!-- Modal -->
            <div class="modal fade" id="importResultModal" tabindex="-1" aria-labelledby="importResultModalLabel">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importResultModalLabel">نتائج استيراد الكشف</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <p><strong>{{ session('import_result.message') }}</strong></p>
                                <p>المضافة بنجاح: {{ session('import_result.addedCount') }} | فشل في:
                                    {{ session('import_result.failedCount') }}</p>
                            </div>

                            @if (session('import_result.failedCount') > 0)
                                <h6>الاسماء التي بها مشاكل:</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>الهوية</th>
                                            <th>الاسم</th>
                                            <th>errors</th>
                                            <th>الخلل</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach (session('import_result.failedRows') as $row)
                                            <tr>
                                                <td>{{ $row['id'] }}</td>
                                                <td>{{ $row['firstname'] }} {{ $row['lastname'] }}</td>
                                                <td>{{ $row['errors'] }}</td>
                                                <td>{{ $row['values'] }}</td>


                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if (session('import_result.failedExcelPath'))
                                    <a href="{{ session('import_result.failedExcelPath') }}" class="btn btn-secondary"
                                       download>تحميل الكشف</a>
                                @endif
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var myModal = new bootstrap.Modal(document.getElementById('importResultModal'));
                    myModal.show();
                });
            </script>
        @endif
        <div class="card px-4">

            @component('components.citizens', [
                'citizens' => null,
                'distributions' => $distributions,
                'distributionId' => $distributionId ? $distributionId : null,
                'regions'=>$regions,
            ])
            @endcomponent

        </div>
    </div>

    <!-- Advanced Filter Modal 2 -->
    <div class="modal fade" id="advancedFilterModal" tabindex="-1" aria-labelledby="advancedFilterModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="advancedFilterModalLabel">Advanced Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="advancedFilterForm">
                        <div class="mb-3">
                            <label for="regions" class="form-label">Regions</label>
                            <select id="regions" class="form-select" multiple="multiple">
                                <!-- Populate with region options -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select id="gender" class="form-select">
                                <option value="">All</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="ageRange" class="form-label">Age Range</label>
                            <div class="input-group">
                                <input type="number" id="minAge" class="form-control" placeholder="Min">
                                <span class="input-group-text">-</span>
                                <input type="number" id="maxAge" class="form-control" placeholder="Max">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="applyFilter">Apply Filter</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const openModalButton = document.getElementById('openModalButton');
        const closeModalButton = document.getElementById('closeModalButton');
        const modal = document.getElementById('myModal');

        openModalButton.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        closeModalButton.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    </script>
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            // Toggle filter menu
            // const filterButton = document.getElementById('filterButton');
            // const closeButton = document.getElementById('close');
            // const filterMenu = document.getElementById('filterMenu');

            // filterButton.addEventListener('click', function() {
            //     filterMenu.classList.toggle('hidden');
            // });

            // closeButton.addEventListener('click', function() {
            //     filterMenu.classList.toggle('hidden');
            // });

            // // Handle Apply button click
            // const applyFilters = document.getElementById('applyFilters');

            // applyFilters.addEventListener('click', function() {
            //     let filters = {
            //         prepositives: Array.from(document.getElementById('prepositives').selectedOptions)
            //             .map(option => option.value),
            //         living_status: document.getElementById('living_status').value,
            //         social_status: document.getElementById('social_status').value,
            //         gender: document.getElementById('gender').value
            //     };

            //     // Make an AJAX request to apply the filters (adjust the URL and method as needed)
            //     fetch('/path/to/filter/endpoint', {
            //             method: 'POST', // or 'GET' if needed
            //             headers: {
            //                 'Content-Type': 'application/json'
            //             },
            //             body: JSON.stringify(filters)
            //         })
            //         .then(response => response.json())
            //         .then(data => {
            //             // Handle the response to update the citizens list
            //             console.log(data);
            //             // Update the citizens list on the page using the response data
            //         })
            //         .catch(error => {
            //             console.error('Error applying filters:', error);
            //         });

            //     // Hide the filter menu after applying filters
            //     filterMenu.classList.add('hidden');
            // });
        });
    </script>
@endpush
