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

<div class="container mx-auto p-4">
    <div class="row align-items-center">
        <!-- Search Input -->
        <div class="col d-flex align-items-center">
            <div class="input-group me-3">
                <input type="text" id="searchctz" name="search" class="form-control" placeholder="بحث عام...">
                <button type="submit" id="searchbtn" class="btn btn-primary">
                    بحث
                    <span class="ti-xs ti ti-user-search ms-1"></span>
                </button>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="col-auto d-flex align-items-center">
            
            <a href="{{ route('citizens.create') }}" class="btn btn-primary mx-1 text-white">
                اضافة جديد
                <span class="ti-xs ti ti-user-plus ms-1"></span>
            </a>
            
            <button id="export-btn" class="btn btn-success mx-1">
                تصدير
                <span class="ti-xs ti ti-table-export ms-1"></span>
            </button>

            <button id="refresh-table" class="btn btn-info mx-1 text-white">
                <i class="fas fa-sync-alt me-1"></i>
                تحديث
            </button>

            <!-- Filter Button with Dropdown Menu -->
            <div class="position-relative">
                <button id="filterButton" type="button" class="btn btn-light-primary">
                    فلترة
                    <span class="ti-xs ti ti-filter-off ms-1"></span>
                </button>
                <div id="filterMenu"
                    class="absolute left-0 z-10 hidden w-80 p-2 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg">
                    <div class="pb-1 mb-1 border-b border-gray-200">
                        <div class="text-lg font-semibold text-gray-700">خيارات التصنيف</div>
                    </div>
                    <form action="{{ route('citizens.index') }}" method="GET">
                        <div class="mb-4">
                            <label class="block mb-1 font-medium text-gray-700">اختر المنطقة الكبيرة:</label>
                            <select id="big_regions" name="big_regions[]" style="width: 100%;"
                                class="select2-multiple p-2 border border-gray-300 rounded-lg" multiple>
                                @foreach (\App\Models\BigRegion::with('representative')->get() as $bigRegion)
                                    <option value="{{ $bigRegion->id }}"
                                        {{ in_array($bigRegion->id, request('big_regions', [])) ? 'selected' : '' }}>
                                        {{ $bigRegion->name }}
                                        @if ($bigRegion->representative)
                                            : {{ $bigRegion->representative->name }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1 font-medium text-gray-700">اختر المناديب:</label>
                            <select id="regions" name="regions[]" style="width: 100%;"
                                class="select2-multiple p-2 border border-gray-300 rounded-lg" multiple>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}"
                                        {{ in_array($region, request('regions', [])) ? 'selected' : '' }}>
                                        @if ($region->representatives->isNotEmpty())
                                            {{ $region->name }} : {{ $region->representatives->first()->name }}
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

                        <div class="mb-4">
                            <label class="block mb-1 font-medium text-gray-700">الجنس:</label>
                            <select id="gender" name="gender"
                                class="w-full p-2 border border-gray-300 rounded-lg">
                                <option value="">غير محدد</option>
                                <option value="0">ذكر</option>
                                <option value="1">انثى</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="citizen_status">Citizen Status:</label>
                            <select id="citizen_status" class="form-control">
                                <option value="current">Current Citizens</option>
                                <option value="deleted">Deleted Citizens</option>
                                <option value="archived">Archived Citizens</option>
                                <option value="all">All Citizens</option>
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <button id="close" type="button"
                                class="px-4 py-2 mr-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200">اغلاق</button>
                            <button id="applyFilters" type="button"
                                class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">تطبيق</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Dropdown for Actions -->
            <div x-data="{ open: false }" class="relative  z-50">
                <button @click="open = !open" class="btn btn-light-primary">
                    اجراءات التحديد
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 bg-white text-black mt-2 py-2 w-48 shadow-md rounded-md">
                    <li>
                        <button type="button" id="add-citizens-btn" class="block px-4 py-2 hover:bg-gray-200">اضافة مستفيدين</button>
                    </li>
                    <li><button id="copy-selected-ids" class="block px-4 py-2 hover:bg-gray-200">نسخ التحديد</button>
                    </li>
                    <li><button id="restore-selected" class="block px-4 py-2 hover:bg-gray-200">استعادة
                            التحديد</button></li>
                    <li><button id="change-region" class="block px-4 py-2 hover:bg-gray-200">تغيير المنطقة</button>
                    </li>
                    <li>
                        <button id="unselect-all-action" class="block px-4 py-2 hover:bg-gray-200">الغاء
                            المحددة</button>
                    </li>
                    <li>
                        <button id="select-all-citizens-action" class="block px-4 py-2 hover:bg-gray-200">تحديد
                            الكل</button>
                    </li>
                    <li><button id="remove-selected" class="block px-4 py-2 hover:bg-gray-200">حذف التحديد</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<form id="add-citizens-form" action="{{ route('distributions.addCitizens') }}" method="POST">
    @csrf
    <input type="hidden" id="distributionId" name="distributionId" value="{{ $distributionId ?? '' }}">
    <input type="hidden" name="citizens" value="{{ implode(',', $citizenIds ?? []) }}">

    {{-- <button type="button" id="add-citizens-btn" class="btn btn-primary">اضافة مستفيدين</button> --}}
</form>
@include('modals.confermation')

<div class="table-responsive">
    <table id="citizens-table" class="table table-bordered table-hover table-striped align-middle">
        <div id="selection-indicator" class="alert alert-info mb-3">
            تم تحديد <span id="selected-count" class="badge bg-primary">0</span> عنصر
        </div>
        <thead class="table-light">
            <tr>
                <th class="w-8px p-0">
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" id="select-all" value="1" />
                    </div>
                </th>
                <th class="py-3 px-2 min-w-90px">
                    <i class="fas fa-id-card me-1"></i>الهوية
                </th>
                <th class="py-3 px-2 min-w-280px">
                    <i class="fas fa-user me-1"></i>الاسم
                </th>
                <th class="py-3 px-2 min-w-120px">
                    <i class="fas fa-phone me-1"></i>رقم الهاتف
                </th>
                <th class="py-3 px-2 min-w-100px">
                    <i class="fas fa-user-circle me-1"></i>هوية الزوجة
                </th>
                <th class="py-3 px-2 min-w-100px">
                    <i class="fas fa-user-friends me-1"></i>اسم الزوجة
                </th>
                <th class="py-3 px-2 min-w-50px">
                    <i class="fas fa-users me-1"></i>الافراد
                </th>
                <th class="py-3 px-2 min-w-100px">
                    <i class="fas fa-map-marker-alt me-1"></i>المنطقة
                </th>
                <th class="py-3 px-2 min-w-100px">
                    <i class="fas fa-sticky-note me-1"></i>ملاحظة
                </th>
                <th class="py-3 px-2 min-w-50px">
                    <i class="fas fa-cog me-1"></i>الاجراءات
                </th>
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
                        d.big_regions = $('#big_regions').val();
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
                        orderable: true,
                        searchable: false,
                        render: function(data, type, row) {
                            if (type === 'sort') {
                                return selectedCitizens.includes(row.id.toString()) ? '0' : '1';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'id',
                        name: 'id',
                        render: function(data) {
                            return `<span class="badge bg-primary">${data}</span>`;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: function(data) {
                            return `<span class="fw-bold">${data}</span>`;
                        }
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        render: function(data) {
                            return data ? `<a href="tel:${data}" class="text-primary"><i class="fas fa-phone me-1"></i>${data}</a>` : '-';
                        }
                    },
                    {
                        data: 'wife_id',
                        name: 'wife_id',
                        render: function(data) {
                            return data || '-';
                        }
                    },
                    {
                        data: 'wife_name',
                        name: 'wife_name',
                        render: function(data) {
                            return data || '-';
                        }
                    },
                    {
                        data: 'family_members',
                        name: 'family_members',
                        render: function(data) {
                            return `<span class="badge bg-info">${data}</span>`;
                        }
                    },
                    {
                        data: 'region',
                        name: 'region',
                        render: function(data) {
                            return `<span class="badge bg-secondary">${data}</span>`;
                        }
                    },
                   
                    {
                        data: 'note',
                        name: 'note',
                        render: function(data) {
                            return data ? `<span class="text-muted">${data}</span>` : '-';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                columnDefs: [{
                    targets: 0,
                    type: 'string'
                }],
                order: [
                    [0, 'asc'],
                    [1, 'asc']
                ], // Sort by checkbox (selected first) then by ID
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
            let totalCitizens = 0;

            // Helper function to standardize ID format
            function standardizeId(id) {
                return id.toString();
            }

            // Function to update the selection indicator
            function updateSelectionIndicator() {
                const selectedCount = selectedCitizens.length;
                $('#selected-count').text(selectedCount);
                
                // Show/hide selection indicator
                if (selectedCount > 0) {
                    $('#selection-indicator').removeClass('d-none').addClass('d-flex');
                } else {
                    $('#selection-indicator').addClass('d-none').removeClass('d-flex');
                }

                // Update action buttons state
                const hasSelection = selectedCount > 0;
                $('#copy-selected-ids, #restore-selected, #change-region, #remove-selected').prop('disabled', !hasSelection);
            }

            // Function to update select-all checkbox state
            function updateSelectAllCheckbox() {
                const visibleRows = table.rows({ 'search': 'applied' }).nodes().length;
                const checkedRows = table.rows({ 'search': 'applied' }).nodes().filter(function() {
                    return $(this).find('input[type="checkbox"]').prop('checked');
                }).length;
                
                $('#select-all').prop('checked', visibleRows > 0 && visibleRows === checkedRows);
            }

            // Function to update selectedCitizens array
            function updateSelectedCitizens(selectAll) {
                if (selectAll) {
                    // Add all visible rows to selection
                    table.rows({ 'search': 'applied' }).data().each(function(row) {
                        const id = standardizeId(row.id);
                        if (!selectedCitizens.includes(id)) {
                            selectedCitizens.push(id);
                        }
                    });
                } else {
                    // Remove all visible rows from selection
                    table.rows({ 'search': 'applied' }).data().each(function(row) {
                        const id = standardizeId(row.id);
                        selectedCitizens = selectedCitizens.filter(selectedId => selectedId !== id);
                    });
                }
                updateSelectionIndicator();
            }

            // Handle select-all checkbox
            $('#select-all').on('change', function() {
                const isChecked = $(this).prop('checked');
                
                // Update all visible checkboxes
                table.rows({ 'search': 'applied' }).nodes().each(function(row) {
                    $(row).find('input[type="checkbox"]').prop('checked', isChecked);
                });
                
                updateSelectedCitizens(isChecked);
                updateSelectionIndicator();
            });

            // Handle individual row checkbox selection
            $('#citizens-table tbody').on('change', 'input[type="checkbox"]', function() {
                const citizenId = standardizeId($(this).val());
                const isChecked = $(this).prop('checked');
                
                if (isChecked) {
                    if (!selectedCitizens.includes(citizenId)) {
                        selectedCitizens.push(citizenId);
                    }
                } else {
                    selectedCitizens = selectedCitizens.filter(id => id !== citizenId);
                }
                
                updateSelectAllCheckbox();
                updateSelectionIndicator();
            });

            // When the page changes, maintain checkbox states
            table.on('draw', function() {
                table.rows().nodes().each(function(row) {
                    const checkbox = $(row).find('input[type="checkbox"]');
                    const citizenId = standardizeId(checkbox.val());
                    checkbox.prop('checked', selectedCitizens.includes(citizenId));
                });
                updateSelectAllCheckbox();
                updateSelectionIndicator();
            });

            // Unselect All action
            $('#unselect-all-action').on('click', function() {
                selectedCitizens = [];
                table.rows().nodes().each(function(row) {
                    $(row).find('input[type="checkbox"]').prop('checked', false);
                });
                $('#select-all').prop('checked', false);
                updateSelectionIndicator();
            });

            // Select All Citizens action
            $('#select-all-citizens-action').on('click', function() {
                selectedCitizens = [];
                table.rows().data().each(function(row) {
                    const id = standardizeId(row.id);
                    selectedCitizens.push(id);
                });
                table.rows().nodes().each(function(row) {
                    $(row).find('input[type="checkbox"]').prop('checked', true);
                });
                $('#select-all').prop('checked', true);
                updateSelectionIndicator();
            });

            // Copy selected IDs
            $('#copy-selected-ids').on('click', function() {
                if (selectedCitizens.length === 0) {
                    alert("No citizens selected.");
                    return;
                }
                const ids = selectedCitizens.join('\n');
                const blob = new Blob([ids], { type: 'text/plain' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'selected_citizens.txt';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            });

            // Remove selected citizens
            $('#remove-selected').on('click', function() {
                if (selectedCitizens.length === 0) {
                    alert("No citizens selected.");
                    return;
                }
                if (confirm(`Are you sure you want to remove ${selectedCitizens.length} selected citizens?`)) {
                    $.ajax({
                        url: '/citizens/remove',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            citizenIds: selectedCitizens
                        },
                        success: function(response) {
                            table.ajax.reload();
                            selectedCitizens = [];
                            updateSelectionIndicator();
                            alert('Selected citizens have been removed.');
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            alert('Error removing citizens.');
                        }
                    });
                }
            });

            // Change region for selected citizens
            $('#change-region').on('click', function() {
                if (selectedCitizens.length === 0) {
                    alert("No citizens selected.");
                    return;
                }
                // Show region selection modal or dropdown
                // Implementation depends on your UI requirements
            });

            // Restore selected citizens
            $('#restore-selected').on('click', function() {
                if (selectedCitizens.length === 0) {
                    alert("No citizens selected.");
                    return;
                }
                if (confirm(`Are you sure you want to restore ${selectedCitizens.length} selected citizens?`)) {
                    $.ajax({
                        url: '{{ route('citizens.restore-multiple') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: selectedCitizens
                        },
                        success: function(response) {
                            table.ajax.reload();
                            selectedCitizens = [];
                            updateSelectionIndicator();
                            alert('Selected citizens have been restored.');
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            alert('Error restoring citizens.');
                        }
                    });
                }
            });

            // Initialize total count when the table is first loaded
            table.on('init', function() {
                totalCitizens = table.rows().count();
                updateSelectionIndicator();
            });

            // Initialize select2 for big regions
            $('#big_regions').select2({
                placeholder: "اختر المنطقة الكبيرة",
                allowClear: true
            });

            // Update regions when big region changes
            $('#big_regions').on('change', function() {
                var selectedBigRegions = $(this).val();
                if (selectedBigRegions && selectedBigRegions.length > 0) {
                    // Filter regions based on selected big regions
                    $('#regions option').each(function() {
                        var regionBigRegionId = $(this).data('big-region-id');
                        if (selectedBigRegions.includes(regionBigRegionId)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                            $(this).prop('selected', false);
                        }
                    });
                } else {
                    // Show all regions if no big region is selected
                    $('#regions option').show();
                }
                $('#regions').trigger('change');
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
