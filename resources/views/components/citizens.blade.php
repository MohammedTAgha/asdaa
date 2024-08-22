@props(['citizens', 'distributionId' => null, 'distributions' => [], 'regions' => [], 'regionId' => null])
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

<div class="row align-items-center">
    <div class="col d-flex align-items-center">
        <!-- Elements aligned at the start -->
        <div class="d-flex">
            <form method="GET" class="d-flex me-3">
                <div class="input-group">
                    <input type="text" id="searchctz" name="search" class="form-control" placeholder="بحث عام...">
                    <button type="submit" id="searchbtn" class="btn btn-primary ms-2">
                        بحث
                        <span class="ti-xs ti ti-user-search ms-1"></span>
                    </button>
                </div>
            </form>
            <!-- Other elements at the start can go here -->
        </div>
    </div>
    <div class="col-auto d-flex align-items-center">
        <!-- Elements aligned at the end -->
        <a href="{{ route('citizens.create') }}" class="btn btn-primary mx-1 text-white">
            اضافة جديد
            <span class="ti-xs ti ti-user-plus ms-1"></span>
        </a>
        <form method="GET" class="mx-1">
            <button type="submit" class="btn btn-success">
                تصدير
                <span class="ti-xs ti ti-table-export ms-1"></span>
            </button>
        </form>
        <button id="filterButton" type="button" class="btn btn-light-primary mx-1">
            فلترة
            <span class="ti-xs ti ti-filter-off ms-1"></span>
        </button>
    </div>
</div>
<form id="add-citizens-form" action="{{ route('distributions.addCitizens') }}" method="POST">
    @csrf
    <input type="hidden" id="distributionId" name="distributionId" value="{{ $distributionId ?? '' }}">
    <input type="hidden" name="citizens" value="{{ implode(',', $citizenIds ?? []) }}">

    <button type="button" id="add-citizens-btn" class="btn btn-primary">اضافة مستفيدين</button>
</form>

<div class="table-responsive">
    <table id="citizens-table" class="table table-bordered table-hover table-condensed table-striped">
        <thead class="bg-light">
            <tr>
                <th class="w-8px p-0">
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" id="select-all" value="1" />
                    </div>
                </th>
                <th class="min-w-90px">الهوية</th>
                <th class="min-w-280px">الاسم</th>
                {{-- <th class="min-w-90px">تاريخ الميلاد</th>
                <th class="min-w-40px">الجنس</th> --}}
                <th class="min-w-100px">اسم الزوجة</th>
                <th class="min-w-50px">الحالة الاجتماعية</th>
                <th class="min-w-50px">المنطقة</th>
                <th class="min-w-50px">ملاحظة</th>
                <th class="min-w-50px"> - </th>
            </tr>
        </thead>
        <tbody>
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
            var table = $('#citizens-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('citizens.data') }}",
                    data: function(d) {
                        d.search = $('#searchctz').val();
                        d.regions = regionids;
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
            $('#regions').on('change', function() {
                console.log('change');
                console.log($('#regions').val());
                regionids = $('#regions').val()
            });

            $('#filterButton').on('click', function() {
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
