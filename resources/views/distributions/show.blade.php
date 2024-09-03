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
                        <i class="tf-icons ti ti-arrows-sort ti-xs me-1"></i>اضافة حسب فلتر
                    </button>
                    {{-- <button type="button" class="btn btn-label-primary waves-effect" data-bs-toggle="modal" data-bs-target="#regionsSelectModal">
                        <i class="tf-icons ti ti-map ti-xs me-1"></i> اضافة مناطق
                    </button> --}}
                    <a href="{{ route('upload.citizens') }}" type="button" class="btn btn-light-primary waves-effect">
                        <i class="tf-icons ti ti-file-upload ti-xs me-1"></i> تحميل ملف
                    </a>
                    
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
                    @if (!$citizens->isEmpty())
                        <input type="text" id="searchbar" class="form-control" placeholder='بحث فوري ...'>

                        <table id="ctzlist" class="table table table-row-bordered gy-2">
                            <thead class="table-light">
                                <tr>
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
                    @else
                        <h2> no citizns exist</h2>
                    @endif

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
            $(document).ready(function() {
                // Set CSRF token for AJAX requests     // Set CSRF token for AJAX requests
                var oTable = $('#ctzlist').DataTable({
                    processing: true,
                    serverSide: true,
                    lengthMenu: [25, 50, 100, 500, 1200, 3000, 6000, 1000, 12000],
                    ajax: '{{ route('distributions.citizens', $distribution->id) }}',
                    columns: [
                        // { data: 'citizens.id', name: 'id' , orderable: false,
                        // searchable: false },
                        {
                            data: 'citizen_id',
                            name: 'citizen_id'
                        },
                        {
                            data: 'fullname',
                            name: 'fullname'
                        },
                        {
                            data: 'region',
                            name: 'region'
                        },
                        {
                            data: 'family_members',
                            name: 'family_members'
                        },
                        {
                            data: 'quantity',
                            name: 'quantity'
                        },
                        {
                            data: 'done',
                            name: 'done'
                        },
                        {
                            data: 'date',
                            name: 'date'
                        },
                        {
                            data: 'recipient',
                            name: 'recipient'
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
                    ]
                });
                // Refresh DataTable when a new citizen is added
                window.addEventListener('citizenAdded', () => {
                    console.log('addddd');
                    
                    oTable.ajax.reload();
                });

                // oTable = $("#ctzlist").DataTable({
                //     "scrollX": true,
                //     responsive: true,
                //     lengthMenu: [ 25, 50, 100,300,600,1200,3000,6000,1000,12000],
                // });

                $('#searchbar').keyup(function() {
                    oTable.search($(this).val()).draw();
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#ctzlist tbody').on('change', 'input[type="checkbox"]', function() {
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
                $('#update-button').click(function() {
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
            });
        </script>
        <script src="{{ asset('assets/js/ui-modals.js') }}"></script>
    @endpush
@endsection
