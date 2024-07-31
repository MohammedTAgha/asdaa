@extends('dashboard')

@section('content')
    <div class="container mx-auto px-4" style="max-width: 100%; overflow-x: hidden;">
        @component('components.box', ['title' => 'بيانات التوزيع'])
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
                    <p class="mt-1 text-gray-900">من : {{ $distribution->min_count }} {{ $distribution->max_count }}الى:</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">ملاحظة</label>
                    <p class="mt-1 text-gray-900">{{ $distribution->note }}</p>
                </div>

            </div>
            </ul>
        </div>
    @endcomponent

    @component('components.box', ['title' => 'المستفيدين'])
        <div class="container mx-auto px-4" style="max-width: 100%; overflow-x: hidden;">
            @php
                $citizens = $distribution->citizens;
            @endphp
            @if (!$citizens->isEmpty())
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">الهوية</th>
                            <th class="w-2/7 py-3 px-4 uppercase font-semibold text-sm">الاسم</th>
                            <th class="w-2/7 py-3 px-4 uppercase font-semibold text-sm">المنطقة</th>
                            <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">عدد افراد الاسرة </th>
                            <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">الحالة الاجتماعية</th>
                            <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">الكمية المستلمة</th>
                            <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">استلم</th>
                            <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">تاريخ الاستلام</th>
                            <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">اسم المستلم</th>
                            <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">ملاحظة </th>
                            <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm"> </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($citizens as $citizen)
                            <tr>
                                <td class="w-1/7 py-3 px-4">
                                    <a href="{{ route('citizens.show', $citizen->id) }}" class="text-blue-600 hover:underline">
                                        {{ $citizen->id }}
                                    </a>
                                </td>
                                <td class="w-2/7 py-3 px-4">
                                    <a href="{{ route('citizens.show', $citizen->id) }}" class="text-blue-600 hover:underline">
                                        {{ $citizen->firstname . ' ' . $citizen->secondname . ' ' . $citizen->thirdname . ' ' . $citizen->lastname }}
                                    </a>
                                </td>
                                <td class="w-2/7 py-3 px-4">
                                    <a href="{{ route('citizens.show', $citizen->id) }}" class="text-blue-600 hover:underline">
                                        {{ $citizen->region->name }}
                                    </a>
                                </td>
                                <td class="w-2/7 py-3 px-4">
                                    افراد
                                </td>
                                <td class="w-1/7 py-3 px-4">الحالة </td>
                                <td class="w-1/7 py-3 px-4">
                                    <input type="number" name="quantity" value="{{ $citizen->pivot->quantity }}"
                                        id="quantity">
                                </td>
                                <td class="w-1/7 py-3 px-4">
                                    <input type="checkbox" name="done" value="{{ $citizen->pivot->done }}"
                                        {{ $citizen->pivot->done ? 'checked' : '' }}>
                                </td>
                                <td class="w-1/7 py-3 px-4">
                                    <input name="recipient" value="{{ $citizen->pivot->recipient }}" id="recipient">
                                </td>
                                <td class="w-1/7 py-3 px-4">
                                    <input type="date" name="date" value="{{ $citizen->pivot->date }}">
                                </td>
                                <td class="w-1/7 py-3 px-4">
                                    <input name="note" id="note" value="{{ $citizen->pivot->note }}">

                                </td>
                                <td class="w-1/7 py-3 px-4">
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded update-button"
                                        data-id="{{ $citizen->pivot->id }}">
                                        Update
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
        @slot('side')
            <!-- Modal toggle -->
            <a href="{{route('citizens.index')}}?distributionId={{$distribution->id}}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                اضافة مستفيدين
            </a>
        @endslot
    @endcomponent
    </div>





  <!-- Main modal -->
  <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-2xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Static modal
                  </h3>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                      <span class="sr-only">Close modal</span>
                  </button>
              </div>
              <!-- Modal body -->
              <div class="p-4 md:p-5 space-y-4">
                  <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                      With less than a month to go before the European Union enacts new consumer privacy laws for its citizens, companies around the world are updating their terms of service agreements to comply.
                  </p>
                  <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                      The European Union’s General Data Protection Regulation (G.D.P.R.) goes into effect on May 25 and is meant to ensure a common set of data rights in the European Union. It requires organizations to notify users as soon as possible of high-risk data breaches that could personally affect them.
                  </p>
              </div>
              <!-- Modal footer -->
              <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                  <button data-modal-hide="static-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>
                  <button data-modal-hide="static-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
              </div>
          </div>
      </div>
  </div>


    @if (session('truncated_citizens'))
        <div id="snackbar" class="fixed bottom-4 left-4 bg-red-600 text-white px-4 py-2 rounded-md shadow-md">
            Warning: Data truncated for the following citizen IDs: {{ implode(', ', session('truncated_citizens')) }}
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
                            alert('Pivot updated successfully');
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
    @endpush
@endsection
