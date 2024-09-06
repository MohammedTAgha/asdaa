@extends('dashboard')
@section('title', 'مشروع' . ' ' . $distribution->name)

@section('content')


    <div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-{{ session('status')['type'] }}">
                {{ session('status')['message'] }}
            </div>
        @endif
        <div class=" bg-white shadow-md rounded-lg p-4 card accordion-item">
            <h2 class="accordion-header d-flex align-items-center">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                    data-bs-target="#accordionWithIcon-1" aria-expanded="false">
                    <i class="ti ti-list-details ti-xs me-2"></i>
                    <h1 class="text-2xl font-bold mb-2">
                        تفاصيل المشروع
                    </h1>
                </button>
            </h2>

            <div id="accordionWithIcon-1" class="accordion-collapse collapse" style="">
                <div class="accordion-body px-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">رقم</label>
                            <p class="mt-1 text-gray-900">{{ $distribution->id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">الوصف</label>
                            <p class="mt-1 text-gray-900">{{ $distribution->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">تاريخ الوصول</label>
                            <p class="mt-1 text-gray-900">{{ $distribution->arrive_date }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">الكمية</label>
                            <p class="mt-1 text-gray-900">{{ $distribution->quantity }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">الفئة المستهدفة</label>
                            <p class="mt-1 text-gray-900">{{ $distribution->target }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">المصدر</label>
                            <p class="mt-1 text-gray-900">{{ $distribution->source }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">اكتمل</label>
                            <p class="mt-1 text-gray-900">{{ $distribution->done ? 'مكتمل' : 'غير مكتمل' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">عدد المستفيدين</label>
                            <p class="mt-1 text-gray-900">{{ $distribution->target_count }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">المتوقعين</label>
                            <p class="mt-1 text-gray-900">{{ $distribution->expectation }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">عدد الافراد</label>
                            <p class="mt-1 text-gray-900">من : {{ $distribution->min_count }}
                                {{ $distribution->max_count }}
                                الى:</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">ملاحظة</label>
                            <p class="mt-1 text-gray-900">{{ $distribution->note }}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- @component('components.box', ['title' => 'بيانات التوزيع'])

        @endcomponent --}}

        @component('components.box', ['title' => 'المستفيدين', 'styles' => 'mt-3'])
            @slot('side')
                <!-- Advanced Filter Modal 2 -->
                <div class="modal fade" id="advancedFilterModal" aria-labelledby="advancedFilterModalLabel">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="advancedFilterModalLabel">فلترةالاسماء المراد اضافتها</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="advancedFilterForm" action="{{ route('distributions.addCitizensFilter') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <!-- regions  -->
                                    <div class="mb-4" style="z-index: 99999">
                                        <label class="block mb-1 font-medium text-gray-700">اختر المناطق:</label>
                                        <select id="regions" name="regions[]"
                                            class="select2-multiple  p-2  border border-gray-300 rounded-lg"
                                            style="width: 100%; z-index: 99999" multiple>
                                            @foreach ($regions as $region)
                                                <option class=" w-120px" value="{{ $region->id }}" style="width: 260px;"
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
                                    <!-- distribution  -->
                                    <div class="mb-4" style="z-index: 99999">
                                        <label class="block mb-1 font-medium text-gray-700">اختر المشروع:</label>
                                        <select id="regions" name="distributionId"
                                            class="select2  p-2  border border-gray-300 rounded-lg"
                                            style="width: 100%; z-index: 99999">
                                            @foreach ($distributions as $row_distribution)
                                                <option value="{{ $distribution->id }}"
                                                    {{ $distribution->id == $row_distribution->id ? 'selected' : '' }}>
                                                    {{ $row_distribution->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="mb-3">
                                        <label for="gender" class="form-label">الحالة الاجتماعية</label>
                                        <select id="gender" class="form-select">
                                            <option value="">All</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div> --}}
                                    <div class="mb-3">
                                        <label for="ageRange" class="form-label">افراد الاسرة</label>
                                        <div class="input-group">
                                            <input type="number" id="min_row_distribution" name="min_row_distribution"
                                                class="form-control" placeholder="من">
                                            <span class="input-group-text">-</span>
                                            <input type="number" id="max_row_distribution" name="max_row_distribution"
                                                class="form-control" placeholder="الى">
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلق</button>
                                    <button type="submit" class="btn btn-primary">اضافة الفرز الى مشروع
                                        {{ $distribution->name }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">اضافة مستفيدين ل {{ $distribution->name }} </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-lg-4 p-4">
                                        <small class="text-light fw-semibold"> اضافة حسب </small>


                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="d-flex">
                    <livewire:add-citizens-to-distribution :distribution-id="$distribution->id" />
                    {{-- go to main ctz list  --}}
                    <a href="{{ route('citizens.index') }}?distributionId={{ $distribution->id }}" type="button"
                        class="btn btn-light-primary waves-effect">
                        <i class="tf-icons ti ti-list-details ti-xs me-1"></i> اضافة من الكشف
                    </a>
                    {{-- show filter for citizents and spasific roules  --}}
                    <button type="button" class="btn btn-light-primary waves-effect" data-bs-toggle="modal"
                        data-bs-target="#advancedFilterModal">
                        <i class="icon-xl fas fa-filter"></i>اضافة حسب فلتر
                    </button>
                    {{-- <button type="button" class="btn btn-label-primary waves-effect" data-bs-toggle="modal" data-bs-target="#regionsSelectModal">
                        <i class="tf-icons ti ti-map ti-xs me-1"></i> اضافة مناطق
                    </button> --}}
                    <a href="{{ route('upload.citizens') }}" type="button" class="btn btn-light-primary waves-effect">
                        <i class="tf-icons ti ti-file-upload ti-xs me-1"></i> تحميل ملف
                    </a>
                    <div x-data="{ open: false }" class="relative mb-3 z-50">
                        <button @click="open = !open" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            اجراءات التحديد
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <ul x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 bg-white text-black mt-2 py-2 w-48 shadow-md rounded-md z-50">
                            <li><button @click="markDone" class="block px-4 py-2 hover:bg-gray-200">تسليم الاسماء
                                    المحددة</button></li>
                            <li><button @click="markUndone" class="block px-4 py-2 hover:bg-gray-200">الغاء تسليم
                                    المحدد</button></li>
                            <li><button @click="deleteFromDistribution" class="block px-4 py-2 hover:bg-gray-200">حذف
                                    من االمشروع</button></li>
                            <!-- Add more actions if needed -->
                        </ul>
                    </div>

                </div>
                {{--            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" --}}
                {{--                    data-bs-target="#modalCenter"> --}}
                {{--                اضافة مستفيدين --}}
                {{--            </button> --}}
            @endslot
            <div class="">

                <div class="table-responsive">
                    @php
                        $citizens = $distribution->citizens;
                    @endphp

                    <input type="text" id="searchbar" class="form-control" placeholder='بحث فوري ...'>

                    <table id="ctzlist" class="table table table-row-bordered gy-2">
                        <thead class="table-light">
                            <tr>
                                <th class=" py-3 px-2 font-semibold ">
                                    <input type="checkbox" id="select-all" />
                                </th>
                                <th class=" py-3 px-2 font-semibold ">الهوية</th>
                                <th class=" py-3 px-2 font-semibold ">الاسم</th>
                                <th class=" py-3 px-2 font-semibold ">المنطقة</th>
                                <th class=" py-3 px-2 font-semibold ">افراد</th>
                                {{-- <th class=" py-3 px-2 font-semibold ">الحالة الاجتماعية</th> --}}
                                <th class=" py-3 px-2 font-semibold ">الكمية <br>المستلمة</th>
                                <th class=" py-3 px-2 font-semibold ">استلم</th>
                                <th class=" py-3 px-2 font-semibold ">تاريخ الاستلام</th>
                                <th class=" py-3 px-2 font-semibold ">اسم المستلم</th>
                                <th class=" py-3 px-2 font-semibold ">ملاحظة</th>
                                <th class=" py-3 px-2 font-semibold "></th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <!-- DataTables will populate this area -->
                        </tbody>
                    </table>


                </div>
            @endcomponent

        </div>
    </div>


    @if (session('truncated_citizens'))
        <div id="snackbar" class="fixed bottom-4 left-4 bg-red-600 text-white px-4 py-2 rounded-md shadow-md">
            Warning: Data truncated for the following citizen
            IDs: {{ implode(', ', session('truncated_citizens')) }}
        </div>
    @endif

    @push('scripts')
        <script>
            $(document).ready(function() {
                if ($('#snackbar').length) {
                    setTimeout(function() {
                        $('#snackbar').fadeOut('slow');
                    }, 5000);
                }
            });
        </script>
        <script>
            const openModalButton = document.getElementById('openModalButton');
            const closeModalButton = document.getElementById('closeModalButton');
            const modal = document.getElementById('myModal');

            openModalButton.addEventListener('click', function() {
                modal.classList.remove('hidden');
            });

            closeModalButton.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            // Refresh DataTable when a new citizen is added
            window.addEventListener('citizenAdded', () => {
                console.log('addddd');

                oTable.ajax.reload();
            });
            // pivits selection action code
            document.getElementById('select-all').addEventListener('click', function() {
                let checkboxes = document.querySelectorAll('.select-citizen');
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            });

            $(document).ready(function() {
                let selectedRows = [];
                // Set CSRF token for AJAX requests     // Set CSRF token for AJAX requests
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var oTable = $('#ctzlist').DataTable({
                    processing: true,
                    serverSide: true,
                    lengthMenu: [25, 50, 100, 500, 1200, 3000, 6000, 1000, 12000],
                    ajax: '{{ route('distributions.citizens', $distribution->id) }}',
                    columns: [{
                            data: 'checkbox',
                            name: 'checkbox',
                            render: function(data, type, row) {
                                let checked = selectedRows.includes(row.pivot_id) ? 'checked' : '';
                    return `<div class="form-check px form-check-sm form-check-custom form-check-solid">
                                <input type="checkbox" class="select-pivot" value="${row.pivot_id}" data-id="${row.pivot_id}" ${checked} />
                            </div>`;                            },
                            orderable: false,
                            searchable: false,
                        },

                        {
                            data: 'id',
                            name: 'id',
                            render: function(data, type, row) {
                                return `<a href="{{ route('citizens.show', '') }}/${data}">${data}</a>`;
                            }
                        },
                        {
                            data: 'fullname',
                            name: 'fullname',
                            render: function(data, type, row) {
                                return `<a href="{{ route('citizens.show', '') }}/${row.citizen_id}">${data}</a>`;
                            }
                        },
                        {
                            data: 'region',
                            name: 'region',
                            render: function(data, type, row) {
                                return `<a href="{{ route('regions.show', '') }}/${row.region_id}">
                            <input type="hidden" name="name" value="${row.fullname}">
                            ${data}
                        </a>`;
                            }
                        },
                        {
                            data: 'family_members',
                            name: 'family_members'
                        },
                        {
                            data: 'quantity',
                            name: 'quantity',
                            render: function(data, type, row) {
                                return `<input class="form-control" type="number" name="quantity" value="${data ? data : ''}" id="quantity" style="width: 65px">`;
                            }
                        },
                        {
                            data: 'done',
                            name: 'done',
                            render: function(data, type, row) {
                                let checked = data ? 'checked' : '';
                                return `<input class="form-check-input" type="checkbox" id="done" name="done" value="${data}" data-id="${row.pivot_id}" ${checked}>`;
                            }
                        },
                        {
                            data: 'date',
                            name: 'date',
                            searchable: false,
                            render: function(data, type, row) {
                                return `<input class="form-control" type="date" name="date" value="${data ? data : ''}" style="width: 160px">`;
                            }
                        },
                        {
                            data: 'recipient',
                            name: 'recipient',
                            searchable: false,
                            render: function(data, type, row) {
                                return `<input class="form-control" name="recipient" value="${data ? data : ''}" id="recipient" style="width: 155px">`;
                            }
                        },
                        {
                            data: 'note',
                            name: 'note',
                            searchable: false,

                            render: function(data, type, row) {
                                return `<input class="form-control" name="note" id="note" value="${data ? data : ''}" style="width: 90px">`;
                            }
                        },
                        {
                            data: 'pivot_id',
                            name: 'pivot_id',
                            render: function(data, type, row) {
                                return `<button id='update-button' class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-1 rounded" data-id="${data}">تحديث</button>`;
                            },
                            orderable: false,
                            searchable: false,
                        }
                    ]
                });
                
    // Handle 'select-all' functionality
    $('#select-all').on('change', function() {
        let isChecked = $(this).is(':checked');
        
        // Select or deselect all visible rows
        $('.select-pivot').each(function() {
            let pivotId = $(this).data('id');
            
            if (isChecked) {
                if (!selectedRows.includes(pivotId)) {
                    selectedRows.push(pivotId); // Add to selected if not already selected
                }
                $(this).prop('checked', true);
            } else {
                selectedRows = selectedRows.filter(id => id !== pivotId); // Remove from selected
                $(this).prop('checked', false);
            }
        });
    });
                // Handle row selection
                $('#ctzlist').on('change', '.select-pivot', function() {
                    let pivotId = $(this).data('id');
                    if ($(this).is(':checked')) {
                        selectedRows.push(pivotId); // Add to selected
                        console.log('select one ', selectedRows);

                    } else {
                        selectedRows = selectedRows.filter(id => id !== pivotId); // Remove from selected
                        console.log('removed one ', selectedRows);

                    }
                });

                // Persist selected rows when changing pages
                $('#ctzlist').on('page.dt', function() {
                    console.log('changing', selectedRows)
                    setTimeout(function() {
                        // Rerender checkboxes based on selectedRows
                        selectedRows.forEach(function(id) {
                            $(`input[data-id="${id}"]`).prop('checked', true);
                        });
                    }, 0);
                });
                // js for actions 
                // Action: Make them done
                $('#make-done').click(function() {
                    updateSelectedCitizens('done', 1);
                });

                // Action: Make them undone
                $('#make-undone').click(function() {
                    updateSelectedCitizens('done', 0);
                });

                // Action: Delete from distribution
                $('#delete-from-distribution').click(function() {
                    deleteSelectedCitizens();
                });

                // Function to update citizens
                function updateSelectedCitizens(field, value) {
                    if (selectedRows.length === 0) {
                        alert("No rows selected!");
                        return;
                    }

                    $.ajax({
                        url: '{{ route('distributions.updateCitizens', $distribution->id) }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            citizens: selectedRows,
                            field: field,
                            value: value,
                        },
                        success: function(response) {
                            oTable.ajax.reload(); // Reload the table
                        },
                        error: function(err) {
                            console.error("Error updating citizens:", err);
                        }
                    });
                }

                // Function to delete citizens from distribution
                function deleteSelectedCitizens() {
                    if (selectedRows.length === 0) {
                        alert("No rows selected!");
                        return;
                    }

                    $.ajax({
                        url: '{{ route('distributions.deleteCitizens', $distribution->id) }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            citizens: selectedRows
                        },
                        success: function(response) {
                            oTable.ajax.reload(); // Reload the table
                            selectedRows = []; // Clear the selection
                        },
                        error: function(err) {
                            console.error("Error deleting citizens:", err);
                        }
                    });
                }
                // oTable = $("#ctzlist").DataTable({
                //     "scrollX": true,
                //     responsive: true,
                //     lengthMenu: [ 25, 50, 100,300,600,1200,3000,6000,1000,12000],
                // });

                $('#searchbar').keyup(function() {
                    oTable.search($(this).val()).draw();
                });


                $(document).on('click', '#update-button', function() {
                    console.log('cl');

                    var pivotId = $(this).data('id');
                    var selectedDate = $(this).closest('tr').find('input[name="date"]').val();
                    var quantity = $(this).closest('tr').find('input[name="quantity"]').val();
                    var recipient = $(this).closest('tr').find('input[name="recipient"]').val();
                    var note = $(this).closest('tr').find('input[name="note"]').val();
                    var ctzName = $(this).closest('tr').find('input[name="name"]').val();
                    var isChecked = $(this).closest('tr').find('input[name="done"]').prop('checked');
                    var status = isChecked ? 1 : 0;
                    console.log();

                    console.log($(this).closest('tr').find('a[id="name"]'))
                    $.ajax({
                        url: '/update-pivot',
                        method: 'POST',
                        data: {
                            pivotId: pivotId,
                            isChecked: status,
                            selectedDate: selectedDate,
                            quantity: quantity,
                            recipient: recipient,
                            note: note,
                        },
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                            alert(' تم تحديث  ' + ctzName);

                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            console.error(xhr.responseText);
                            alert('Failed to update pivot');
                        }
                    });
                });
                $('#ctzlist tbody').on('change', 'input[id="done"]', function() {
                    var pivotId = $(this).data('id');
                    var selectedDate = $(this).closest('tr').find('input[name="date"]').val();
                    var quantity = $(this).closest('tr').find('input[name="quantity"]').val();
                    var recipient = $(this).closest('tr').find('input[name="recipient"]').val();
                    var note = $(this).closest('tr').find('input[name="note"]').val();
                    var ctzName = $(this).closest('tr').find('input[name="name"]').val();
                    var isChecked = $(this).closest('tr').find('input[name="done"]').prop('checked');
                    var status = isChecked ? 1 : 0;
                    console.log();
                    console.log('clicked')
                    console.log(pivotId)
                    console.log('clicked')
                    console.log(ctzName)
                    $.ajax({
                        url: '/update-pivot',
                        method: 'POST',
                        data: {
                            pivotId: pivotId,
                            isChecked: status,
                            selectedDate: selectedDate,
                            quantity: quantity,
                            recipient: recipient,
                            note: note,
                        },
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                            if (status) {
                                alert(' تم تسليم  ' + ctzName + ' {{ $distribution->name }} ');
                            } else {
                                alert(' تم الغاء تسليم  ' + ctzName +
                                    ' {{ $distribution->name }} ');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            console.error(xhr.responseText);
                            alert('Failed to update pivot');
                        }
                    });
                });

            });
        </script>
        <script src="{{ asset('assets/js/ui-modals.js') }}"></script>
    @endpush
@endsection
