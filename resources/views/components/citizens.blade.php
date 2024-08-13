@props(['citizens', 'distributionId' => null, 'distributions' => []])
<style>
    .dataTables_filter {
        display: none;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="distributionModal" tabindex="-1" aria-labelledby="distributionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="distributionModalLabel">Select Distribution</h5>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="select-distribution-btn" class="btn btn-primary">Select</button>
            </div>
        </div>
    </div>
</div>

<div class="card-header d-flex justify-content-between">
    <div>

        <div class="ml-4 relative d-flex">
            <form method="GET" class="me-4">
                <div class="flex items-center w-full mx-2 me-6">
                    <div class="col-md-6">
                        <input type="text" id="searchctz" name="search" class="form-control"
                            placeholder="بحث عام...">
                    </div>
                    <button type="button" id="searchbtn" class="ms-3 btn btn-primary waves-effect waves-light">
                        بحث
                        <span class="ti-xs ti ti-user-search ms-1"></span>
                    </button>

                </div>
            </form>
        </div>
    </div>
    <div class="me-2 relative flex">
        <button id="filterButton" type="button" class=" mx-1 btn btn-outline-primary waves-effect">
            فلترة
            <span class="ti-xs ti ti-filter-off ms-1"></span>
        </button>
        {{-- form  --}}
        <form method="GET">
            <!-- Add hidden inputs for each filter parameter -->
            <input type="hidden" name="id" value="{{ request('id') }}">
            <input type="hidden" name="first_name" value="{{ request('first_name') }}">
            <input type="hidden" name="second_name" value="{{ request('second_name') }}">
            <input type="hidden" name="third_name" value="{{ request('third_name') }}">
            <input type="hidden" name="last_name" value="{{ request('last_name') }}">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="gender" value="{{ request('gender') }}">
            @if (is_array(request('regions')))
                @foreach (request('regions') as $region)
                    <input type="hidden" name="regions[]" value="{{ $region }}">
                @endforeach
            @else
                <input type="hidden" name="regions" value="{{ request('regions') }}">
            @endif <button type="submit" class=" mx-1 btn btn-success waves-effect waves-light">
                تصدير
                <span class="ti-xs ti ti-table-export ms-1"></span>
            </button>
        </form>


        <a href="{{ route('citizens.create') }}" type="button"
            class="btn mx-1 btn-primary waves-effect waves-light text-white">
            اضافة جديد
            <span class="ti-xs ti ti-user-plus ms-1"></span>
        </a>
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
                        class="select2-multiple p-2  border border-gray-300 rounded-lg" style="width: 260px;" multiple>
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
                        <input type="number" id="minAge" class="form-control" placeholder="Min">
                        <span class="input-group-text">-</span>
                        <input type="number" id="maxAge" class="form-control" placeholder="Max">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="ageRange" class="form-label">العمر</label>
                    <div class="input-group">
                        <input type="number" id="minAge" class="form-control" placeholder="Min">
                        <span class="input-group-text">-</span>
                        <input type="number" id="maxAge" class="form-control" placeholder="Max">
                    </div>
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
                    <button id="applyFilters" type="button"
                        class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">تطبيق</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="add-citizens-form" action="{{ route('distributions.addCitizens') }}" method="POST">
    @csrf
    <input type="hidden" id="distributionId" name="distributionId" value="{{ $distributionId ?? '' }}">
    <input type="hidden" name="citizens" value="{{ implode(',', $citizenIds ?? []) }}">

    <button type="button" id="add-citizens-btn" class="btn btn-primary">Add Citizens</button>
</form>
<div class="table-responsive">
    <table id="citizens-table" class="table  table-bordered table-hover table-condensed table-striped">
        <thead class="bg-gray-50">
            <tr class="text-start ">
                <th class="w-8px p-0">
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" id="select-all" value="1" />
                    </div>
                </th>
                <th class="min-w-90px">الهوية</th>
                <th class="min-w-280px">الاسم</th>
                <th class="min-w-90px">تاريخ الميلاد</th>
                <th class="min-w-40px">الجنس</th>
                <th class="min-w-100px ">اسم الزوجة</th>
                <th class="min-w-50px ">الحالة الاجتماعية</th>
                <th class="min-w-50px ">المنطقة</th>
                <th class="min-w-50px ">ملاحظة</th>
                <th class="min-w-50px "> - </th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated by DataTables -->
        </tbody>
    </table>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            console.log('load')
            var table = $('#citizens-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('citizens.data') }}",
                    data: function(d) {
                        d.search = $('#searchctz').val();
                        d.regions = $('#regions').val();
                        d.minAge = $('#minAge').val();
                        d.maxAge = $('#maxAge').val();
                        d.living_status = $('#living_status').val();
                        d.social_status = $('#social_status').val();
                        d.gender = $('#gender').val();
                    }
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'date_of_birth',
                        name: 'date_of_birth'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'wife_name',
                        name: 'wife_name'
                    },
                    {
                        data: 'social_status',
                        name: 'social_status'
                    },
                    {
                        data: 'region',
                        name: 'region.name'
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
            });

            $('#filterButton').on('click', function() {
                $('#filterMenu').toggle();
            });

            $('#applyFilters').on('click', function(e) {

                table.draw();
                $('#filterMenu').hide();
            });

            $('#searchbtn').on('click', function(e) {

                table.draw();

            });
            $('#close').on('click', function() {
                $('#filterMenu').hide();
            });

            // Handle select-all checkbox
            $('#select-all').on('click', function() {
                var rows = table.rows({
                    'search': 'applied'
                }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            $('#citizens-table tbody').on('change', 'input[type="checkbox"]', function() {
                console.log('clicked')
                if (!this.checked) {
                    var el = $('#select-all').get(0);
                    if (el && el.checked && ('indeterminate' in el)) {
                        el.indeterminate = true;
                    }
                }
            });

            //


            // When the user selects a distribution from the modal
            $('#select-distribution-btn').click(function() {
                var distributionId = $('#selectedDistributionId').val();
                $('#distributionId').val(distributionId);
                $('#add-citizens-form').submit();
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
