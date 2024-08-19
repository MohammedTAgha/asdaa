@extends('dashboard')

@section('content')


    <div class="container mx-auto" style="max-width: 100%; overflow-x: hidden;">

        <div class=" bg-white shadow-md rounded-lg p-6 card accordion-item">
            <h2 class="accordion-header d-flex align-items-center">
              <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionWithIcon-1" aria-expanded="false">
                <i class="ti ti-list-details ti-xs me-2"></i>
                <h1 class="text-2xl font-bold mb-6">
                    تفاصيل المشروع
                </h1>
              </button>
            </h2>

            <div id="accordionWithIcon-1" class="accordion-collapse collapse" style="">
              <div class="accordion-body">
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
                        <p class="mt-1 text-gray-900">من : {{ $distribution->min_count }} {{ $distribution->max_count }}
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
                <div class="demo-inline-spacing">
                    {{-- go to main ctz list  --}}
                    <a href="{{ route('citizens.index') }}?distributionId={{ $distribution->id }}" type="button" class="btn btn-label-primary waves-effect">
                        <i class="tf-icons ti ti-list-details ti-xs me-1"></i> اضافة من الكشف
                    </a>
                    {{-- show filter for citizents and spasific roules  --}}
                    <button type="button" class="btn btn-label-primary waves-effect" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="tf-icons ti ti-arrows-sort ti-xs me-1"></i>اضافة حسب فلتر
                    </button>
                    {{-- <button type="button" class="btn btn-label-primary waves-effect" data-bs-toggle="modal" data-bs-target="#regionsSelectModal">
                        <i class="tf-icons ti ti-map ti-xs me-1"></i> اضافة مناطق
                    </button> --}}
                    <a href="{{route('upload.citizens')}}" type="button" class="btn btn-label-primary waves-effect">
                        <i class="tf-icons ti ti-file-upload ti-xs me-1"></i> تحميل ملف
                    </a>

                </div>
                {{--            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" --}}
                {{--                    data-bs-target="#modalCenter"> --}}
                {{--                اضافة مستفيدين --}}
                {{--            </button> --}}
            @endslot
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="table-responsive">
                    @php
                        $citizens = $distribution->citizens;
                    @endphp
                    @if (!$citizens->isEmpty())
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class=" py-3  uppercase font-semibold text-sm">الهوية</th>
                                    <th class=" py-3  uppercase font-semibold text-sm">الاسم</th>
                                    <th class=" py-3  uppercase font-semibold text-sm">المنطقة</th>
                                    <th class=" py-3  uppercase font-semibold text-sm">افراد</th>
                                    {{-- <th class=" py-3  uppercase font-semibold text-sm">الحالة الاجتماعية</th> --}}
                                    <th class=" py-3  uppercase font-semibold text-sm">الكمية <br>المستلمة</th>
                                    <th class=" py-3  uppercase font-semibold text-sm">استلم</th>
                                    <th class=" py-3  uppercase font-semibold text-sm">تاريخ الاستلام</th>
                                    <th class=" py-3  uppercase font-semibold text-sm">اسم المستلم</th>
                                    <th class=" py-3  uppercase font-semibold text-sm">ملاحظة</th>
                                    <th class=" py-3  uppercase font-semibold text-sm"></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach ($citizens as $citizen)
                                    <tr>
                                        <td class=" py-3 ">
                                            <a href="{{ route('citizens.show', $citizen->id) }}"
                                                class="text-blue-600 hover:underline">
                                                {{ $citizen->id }}
                                            </a>
                                        </td>
                                        <td class=" py-3 ">
                                            <a href="{{ route('citizens.show', $citizen->id) }}"
                                                class="text-blue-600 hover:underline">
                                                {{ $citizen->firstname . ' ' . $citizen->secondname . ' ' . $citizen->thirdname . ' ' . $citizen->lastname }}
                                            </a>
                                        </td>
                                        <td class=" py-3 ">
                                            <a href="{{ route('regions.show', $citizen->region->id) }}"
                                                class="text-blue-600 hover:underline">
                                                {{ $citizen->region->name }}
                                            </a>
                                        </td>
                                        <td class=" py-3 ">
                                            {{ $citizen->family_members }}
                                        </td>
                                        {{-- <td class=" py-3 ">{{$citizen->social_status}} </td> --}}
                                        <td class=" py-3 ">
                                            <input class="form-control" type="number" name="quantity"
                                                value="{{ $citizen->pivot->quantity }}" id="quantity" style="width: 65px">
                                        </td>
                                        <td class=" py-3 ">
                                            <input class="form-check-input" type="checkbox" name="done"
                                                value="{{ $citizen->pivot->done }}"
                                                {{ $citizen->pivot->done ? 'checked' : '' }}>
                                        </td>

                                        <td class=" py-3 ">
                                            <input class="form-control" type="date" name="date"
                                                value="{{ $citizen->pivot->date }}" style="width: 160px">
                                        </td>
                                        <td class=" py-3 ">
                                            <input class="form-control" name="recipient"
                                                value="{{ $citizen->pivot->recipient }}" id="recipient"
                                                style="width: 155px">
                                        </td>
                                        <td class=" py-3 ">
                                            <input class="form-control" name="note" id="note"
                                                value="{{ $citizen->pivot->note }}" style="width: 90px">

                                        </td>
                                        <td class=" py-3 ">
                                            <button
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-1 rounded update-button"
                                                data-id="{{ $citizen->pivot->id }}">
                                                تحديث
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
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
                // Set CSRF token for AJAX requests
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('.update-button').click(function() {
                    var pivotId = $(this).data('id');
                    var selectedDate = $(this).closest('tr').find('input[name="date"]').val();
                    var quantity = $(this).closest('tr').find('input[name="quantity"]').val();
                    var recipient = $(this).closest('tr').find('input[name="recipient"]').val();
                    var note = $(this).closest('tr').find('input[name="note"]').val();

                    var isChecked = $(this).closest('tr').find('input[name="done"]').prop('checked');
                    var data = isChecked ? 1 : 0;
                    console.log(data)
                    $.ajax({
                        url: '/update-pivot',
                        method: 'POST',
                        data: {
                            pivotId: pivotId,
                            isChecked: data,
                            selectedDate: selectedDate,
                            quantity: quantity,
                            recipient: recipient,
                            note: note,
                        },
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                            alert('تم تحديث');
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
