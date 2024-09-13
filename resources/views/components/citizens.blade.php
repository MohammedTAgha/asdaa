@props(['citizens', 'distributionId' => null, 'distributions' => [], 'regions' => [], 'regionId' => null])
<style>
    .dataTables_filter {
        display: none;
    }
</style>

@push('custom_styles')
    <style>
        td {
            /* background-color: #f4f9fd !important; */
            align-items: center;

        }
    </style>
@endpush
<!-- Modal -->
<div class="modal fade" id="distributionModal" tabindex="-1" aria-labelledby="distributionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="distributionModalLabel">اختر التوزيع </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select id="selectedDistributionId" class="form-control">
                    <!-- Populate with distribution options from your database -->
                    @foreach ($distributions as $distribution)
                        <option value="{{ $distribution->id }}">{{ $distribution->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلق</button>
                <button type="button" id="select-distribution-btn" class="btn btn-primary">تاكيد</button>
            </div>
        </div>
    </div>
</div>

<div class="row align-items-center">
    <!-- Elements aligned at the start -->
    <div class="col d-flex align-items-center">
        <div class="d-flex me-3">
            <div class="input-group">
                <input type="text" id="searchctz" name="search" class="form-control" placeholder="بحث عام...">
                <button type="submit" id="searchbtn" class="btn btn-primary ">
                    بحث
                    <span class="ti-xs ti ti-user-search ms-1"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Elements aligned at the end -->
    <div class="col-auto d-flex align-items-center position-relative">
        <a href="{{ route('citizens.create') }}" class="btn btn-primary mx-1 text-white">
            اضافة جديد
            <span class="ti-xs ti ti-user-plus ms-1"></span>
        </a>
        {{-- <form method="GET" class="mx-1"> --}}
        <button id="export-btn" class="btn btn-success">
            تصدير
            <span class="ti-xs ti ti-table-export ms-1"></span>
        </button>
        {{-- </form> --}}

        <!-- Filter Button with Dropdown Menu -->
        <div class="me-2 d-flex position-relative">
            <button id="filterButton" type="button" class="btn btn-light-primary">
                فلترة
                <span class="ti-xs ti ti-filter-off ms-1"></span>
            </button>

            <!-- Filter Popup Menu -->
            <div id="filterMenu"
                class="absolute left-0  z-10 hidden w-80 p-2 pt-1 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg">
                <!-- Header -->
                <div class="pb-1 mb-1 border-b border-gray-200">
                    <div class="text-lg font-semibold text-gray-700">خيارات التصنيف</div>
                </div>
                <!-- Filter Form -->
                <form action="{{ route('citizens.index') }}" method="GET">
                    <!-- Prepositives -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium text-gray-700">اختر المناديب:</label>
                        <select id="regions" name="regions[]"
                            class="select2-multiple p-2  border border-gray-300 rounded-lg" style="width: 260px;"
                            multiple>
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

                    <div class="mb-3">
                        <label for="ageRange" class="form-label">افراد الاسرة</label>
                        <div class="input-group">
                            <input type="number" id="minMembers" class="form-control" placeholder="من">
                            <span class="input-group-text">-</span>
                            <input type="number" id="maxMembers" class="form-control" placeholder="الى">
                        </div>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="ageRange" class="form-label">العمر</label>
                        <div class="input-group">
                            <input type="number" id="minAge" class="form-control" placeholder="Min">
                            <span class="input-group-text">-</span>
                            <input type="number" id="maxAge" class="form-control" placeholder="Max">
                        </div>
                    </div> --}}
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
                    <div class="form-group mb-4">
                        <label for="citizen_status">Citizen Status:</label>
                        <select id="citizen_status" class="form-control">
                            <option value="current">Current Citizens</option>
                            <option value="deleted">Deleted Citizens</option>
                            <option value="archived">Archived Citizens</option>
                            <option value="all">All Citizens</option>
                        </select>
                    </div>
                    <!-- Actions -->
                    <div class="flex justify-end">
                        <button id="close" type="button"
                            class="px-4 py-2 mr-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            اغلاق</button>
                        <button id="applyFilters" type="button"
                            class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">تطبيق</button>
                    </div>
                </form>
            </div>
        </div>
        <div x-data="{ open: false }" class="relative mb-3 z-50">
            <button @click="open = !open" class="btn btn-light-primary waves-effect">
                اجراءات التحديد
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <ul x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 bg-white text-black mt-2 py-2 w-48 shadow-md rounded-md z-50">

                <li><button id="copy-selected-ids" class="block px-4 py-2 hover:bg-gray-200">
                        نسخ التحديد
                    </button>
                </li>

                <li><button id="restore-selected" class="block px-4 py-2 hover:bg-gray-200">
                        استعادة التحديد
                    </button>
                </li>
                <li><button id="change-region" class="block px-4 py-2 hover:bg-gray-200">
                        تغيير المنطقة
                    </button>
                </li>
                <li><button id="remove-selected" class="block px-4 py-2 hover:bg-gray-200">
                        حذف التحديد
                    </button>
                </li>

                <!-- Add more actions if needed -->
            </ul>
        </div>

    </div>
</div>

<form id="add-citizens-form" action="{{ route('distributions.addCitizens') }}" method="POST">
    @csrf
    <input type="hidden" id="distributionId" name="distributionId" value="{{ $distributionId ?? '' }}">
    <input type="hidden" name="citizens" value="{{ implode(',', $citizenIds ?? []) }}">

    <button type="button" id="add-citizens-btn" class="btn btn-primary">اضافة مستفيدين</button>
</form>
@include('modals.confermation')
<div class="table-responsive">
    <table id="citizens-table"
        class="table table-bordered table-hover table-condensed table-row-bordered gy-2 table-striped">
        <thead class="table-light">
            <tr>
                <th class="w-8px p-0">
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" id="select-all" value="1" />
                    </div>
                </th>
                <th class="py-3 px-2 min-w-90px">الهوية</th>
                <th class="py-3 px-2 min-w-280px">الاسم</th>
                {{-- <th class="py-3 px-2 min-w-90px">تاريخ الميلاد</th>
                <th class="py-3 px-2 min-w-40px">الجنس</th> --}}
                <th class="py-3 px-2 min-w-100px">اسم الزوجة</th>
                <th class="py-3 px-2 min-w-50px"> الافراد</th>
                <th class="py-3 px-2 min-w-50px">المنطقة</th>
                <th class="py-3 px-2 min-w-50px">ملاحظة</th>
                <th class="py-3 px-2 min-w-50px"> - </th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            <!-- Data will be populated by DataTables -->
        </tbody>
    </table>
</div>
{{-- ctz data
{{$region}} --}}
id
{{ $regionId }}
{{-- @dd($region) --}}
@push('scripts')
    <script>
        $(document).ready(function() {
            console.log('load')
            @if ($regionId !== null)
                var regionids = [{{ $regionId }}]
                console.log('true ', regionids)
            @else
                var regionids = $('#regions').val();
                console.log('false ', regionids)
            @endif

            console.log('new id ', regionids)
            $('#export-btn').on('click', function() {
                var filters = {
                    search: $('#searchctz').val(),
                    regions: regionids,
                    minMembers: $('#minMembers').val(),
                    maxMembers: $('#maxMembers').val(),
                    living_status: $('#living_status').val(),
                    social_status: $('#social_status').val(),
                    gender: $('#gender').val(),
                    original_address: $('#original_address').val()
                };

                // Redirect to export route with filters
                window.location.href = "{{ route('citizens.export') }}?" + $.param(filters);
            });
            var table = $('#citizens-table').DataTable({
                processing: true,
                serverSide: true,
                lengthMenu: [25, 50, 100, 500, 1200, 3000, 6000, 1000, 12000],
                ajax: {
                    url: "{{ route('citizens.data') }}",
                    data: function(d) {
                        d.search = $('#searchctz').val();
                        d.regions = regionids;
                        d.minMembers = $('#minMembers').val();
                        d.maxMembers = $('#maxMembers').val();
                        d.living_status = $('#living_status').val();
                        d.social_status = $('#social_status').val();
                        d.gender = $('#gender').val();
                        d.oreginal_adress = $('#oreginal_adress').val();
                        d.citizen_status = $('#citizen_status').val();
                    }
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        /*
                        @fix seach bar 
                        */
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    // {
                    //     data: 'date_of_birth',
                    //     name: 'DOB'
                    // },
                    // {
                    //     data: 'gender',
                    //     name: 'gender'
                    // },
                    {
                        data: 'wife_name',
                        name: 'wife_name'
                    },
                    {
                        data: 'family_members',
                        name: 'family_members'
                    },
                    {
                        data: 'region',
                        name: 'region'
                    },
                    {
                        data: 'note',
                        name: 'note'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ],
                language: {
                    "sProcessing": "جاري المعالجة...",
                    "sLengthMenu": "عرض _MENU_ سجل",
                    "sZeroRecords": "لم يتم العثور على أي سجلات",
                    "sInfo": "عرض من _START_ إلى _END_ من إجمالي _TOTAL_ سجل",
                    "sInfoEmpty": "عرض 0 إلى 0 من 0 سجل",
                    "sInfoFiltered": "(تم تصفية من _MAX_ سجل)",
                    "sSearch": "بحث:",
                    "oPaginate": {
                        "sFirst": "الأول",
                        "sPrevious": "السابق",
                        "sNext": "التالي",
                        "sLast": "الأخير"
                    },
                    "oAria": {
                        "sSortAscending": ": تفعيل لترتيب العمود تصاعديًا",
                        "sSortDescending": ": تفعيل لترتيب العمود تنازليًا"
                    }
                }
            });
            $('#regions').on('change', function() {
                console.log('change');
                console.log($('#regions').val());
                regionids = $('#regions').val()
            });

            $('#filterButton').on('click', function() {
                console.log('filter');

                $('#filterMenu').toggle();
            });

            $('#applyFilters').on('click', function(e) {
                console.log('new id ', regionids)

                table.draw();
                $('#filterMenu').hide();
            });

            $('#searchbtn').on('click', function(e) {

                table.draw();

            });
            $('#close').on('click', function() {
                $('#filterMenu').hide();
            });

            let selectedCitizens = [];

            // Helper function to standardize ID format
            function standardizeId(id) {
                return id.toString();
            }

            // Handle select-all checkbox
            $('#select-all').on('click', function() {
                var rows = table.rows({
                    'search': 'applied'
                }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);

                // Add or remove all citizens from selectedCitizens array
                if (this.checked) {
                    table.rows({
                        'search': 'applied'
                    }).data().each(function(row) {
                        const id = standardizeId(row.id);
                        if (!selectedCitizens.includes(id)) {
                            selectedCitizens.push(id);
                        }
                    });
                } else {
                    table.rows({
                        'search': 'applied'
                    }).data().each(function(row) {
                        const id = standardizeId(row.id);
                        selectedCitizens = selectedCitizens.filter(selectedId => selectedId !== id);
                    });
                }
                console.log('all', selectedCitizens);
            });

            // Handle individual row checkbox selection
            $('#citizens-table tbody').on('change', 'input[type="checkbox"]', function() {
                const citizenId = standardizeId($(this).val());
                if (this.checked) {
                    if (!selectedCitizens.includes(citizenId)) {
                        selectedCitizens.push(citizenId);
                    }
                } else {
                    selectedCitizens = selectedCitizens.filter(id => id !== citizenId);
                }
                console.log(citizenId);
                console.log(selectedCitizens);
            });

            // When the page changes, keep checkboxes selected for already selected rows
            table.on('draw', function() {
                table.rows().nodes().each(function(row) {
                    const checkbox = $(row).find('input[type="checkbox"]');
                    const citizenId = standardizeId(checkbox.val());
                    if (selectedCitizens.includes(citizenId)) {
                        checkbox.prop('checked', true);
                    } else {
                        checkbox.prop('checked', false);
                    }
                });

                // Update select-all checkbox
                updateSelectAllCheckbox();
            });

            // Function to update select-all checkbox state
            function updateSelectAllCheckbox() {
                var allChecked = table.rows({
                        'search': 'applied'
                    }).nodes().length ===
                    table.rows({
                        'search': 'applied'
                    }).nodes().filter(function() {
                        return $(this).find('input[type="checkbox"]').prop('checked');
                    }).length;
                $('#select-all').prop('checked', allChecked);
            }

            // Update select-all checkbox when individual checkboxes change
            $('#citizens-table tbody').on('change', 'input[type="checkbox"]', function() {
                updateSelectAllCheckbox();
            });
            // Function to handle restoration
            function restoreCitizens(ids) {
                var url = Array.isArray(ids) ? '{{ route('citizens.restore-multiple') }}' : '/citizens/' + ids +
                    '/restore';
                var data = {
                    _token: '{{ csrf_token() }}',
                    ids: Array.isArray(ids) ? ids : null
                };
                console.log('ids', ids);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        alert(response.message);
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        alert('خطا في الاستعادة');
                    }
                });
            }

            // Single citizen restore
            $('#citizens-table').on('click', '.restore-btn', function() {
                var citizenId = $(this).data('id');
                if (confirm('Are you sure you want to restore this citizen?')) {
                    restoreCitizens(citizenId);
                }
            });

            // Multiple citizens restore
            $('#restore-selected').click(function() {
                // var selectedIds = $('.citizen-checkbox:checked').map(function() {
                //     return $(this).val();
                // }).get();

                if (selectedCitizens.length === 0) {
                    alert('Please select citizens to restore');
                    return;
                }

                if (confirm('Are you sure you want to restore these citizens? ' + selectedCitizens
                    .length)) {
                    restoreCitizens(selectedCitizens);
                }
            });


            // When the user selects a distribution from the modal
            $('#select-distribution-btn').click(function() {
                var distributionId = $('#selectedDistributionId').val();
                $('#distributionId').val(distributionId);
                $('#add-citizens-form').submit();
            });

            $('codeConfermationModal').click(function() {
                $('#confirmationModal').modal('hide');
            })
            // Remove selected citizens
            $('#remove-selected').click(function() {
                if (selectedCitizens.length === 0) {
                    alert("No citizens selected.");
                    return;
                }
                $('#confirmationMessage').text("Are you sure you want to remove the selected citizens?");
                $('#confirmationModal').modal('show');

                $('#confirmAction').off('click').on('click', function() {
                    // Send AJAX request to remove citizens
                    $.ajax({
                        url: '/citizens/remove',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            citizenIds: selectedCitizens
                        },
                        success: function(response) {
                            table.ajax.reload();

                            $('#confirmationModal').modal('hide');
                            console.log(response);

                            console.log(selectedCitizens.length + " citizens deleted");

                            alert('deleted');
                        },
                        erorr: function(xhr, status, error) {
                            console.log(status);
                            console.error(xhr.responseText);
                            alert(xhr.responseText);
                        }
                    });
                });
            });

            $('#copy-selected-ids').click(function() {
                if (selectedCitizens.length === 0) {
                    alert("No citizens selected.");
                    return;
                }
                const ids = selectedCitizens.join('\n'); // Join IDs with newline for text file
                console.log(ids);

                // Create a Blob with the IDs
                const blob = new Blob([ids], {
                    type: 'text/plain'
                });
                const url = URL.createObjectURL(blob);

                // Create a temporary link element
                const a = document.createElement('a');
                a.href = url;
                a.download = 'تحديد ارقا هوايا.txt'; // Set the file name

                // Append to the body, click and remove
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);

                // Release the object URL
                URL.revokeObjectURL(url);

                alert("تم التحميل كملف نص");
            });

            // Change region for selected citizens
            $('#change-region').click(function() {
                if (selectedCitizens.length === 0) {
                    alert("No citizens selected.");
                    return;
                }
                $('#confirmationMessage').text("Select a new region for the selected citizens.");
                $('#confirmationModal').modal('show');

                $('#confirmAction').off('click').on('click', function() {
                    // Handle region change
                    const newRegionId = $('#regionSelect').val();
                    $.ajax({
                        url: '/citizens/change-region',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            citizenIds: selectedCitizens,
                            regionId: newRegionId
                        },
                        success: function(response) {
                            table.ajax.reload();
                            selectedCitizens = [];
                            $('#confirmationModal').modal('hide');
                            alert(response.message);
                        }
                    });
                });
            });

            $('#add-citizens-btn').click(function(e) {
                e.preventDefault();

                var selectedCitizens = $('input[name="citizens[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                console.log(selectedCitizens)
                if (selectedCitizens.length === 0) {
                    alert('Please select at least one citizen.');
                    return;
                }
                $('input[name="citizens"]').val(selectedCitizens.join(','));
                // Check if the distributionId is provided
                if ($('#distributionId').val()) {
                    $('#add-citizens-form').submit();
                } else {
                    $('#distributionModal').modal('show');
                }
            });
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            oTable = $('#citizens-table').DataTable({
                responsive: true,
                "scrollY": "4000px", 
                "scrollCollapse": true,
                "paging": false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search citizens..."
                }
            });
            $('#searchbar').keyup(function() {

                oTable.search($(this).val()).draw();
        });

            $('#select-all').on('change', function() {
                var checkboxes = $('input[name="citizens[]"]');
                checkboxes.prop('checked', $(this).prop('checked'));
            });

            $('#open-modal').on('click', function() {
                var selectedIds = $('input[name="citizens[]"]:checked').map(function() {
                    return this.value;
                }).get().join(',');

                if (!selectedIds) {
                    alert('Please select at least one citizen.');
                    return;
                }

                $('#citizen-ids').val(selectedIds);
                $('#distribution-modal').removeClass('hidden');
            });

            $('#close-modal').on('click', function() {
                $('#distribution-modal').addClass('hidden');
            });
        });
    </script> --}}
@endpush
