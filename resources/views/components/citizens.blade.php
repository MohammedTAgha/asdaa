@props(['citizens', 'distributionId' => null, 'distributions' => []])

<form id="citizens-form" method="POST" action="{{ $distributionId ? route('distributions.addCitizens', $distributionId) : '#' }}>
    @csrf
    <div class="table-container overflow-x-auto mb-4">
        <table id="citizens-table" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <th class="w-15px">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" id="select-all" value="1" data-kt-check="true" data-kt-check-target="#kt_customers_table .form-check-input" />
                            </div>
                        </th>
                        <th class="min-w-90px">الهوية</th>
                        <th class="min-w-180px">الاسم</th>
                        <th class="min-w-90px">تاريخ الميلاد</th>
                        <th class="min-w-40px">الجنس</th>
                        <th class="min-w-100px ">اسم الزوجة</th>
                        <th class="min-w-50px ">الحالة الاجتماعية</th>
                        <th class="min-w-50px ">المنطقة</th>
                        <th class="min-w-50px ">ملاحظة</th>
                        <th class="min-w-50px "> -  </th>
                    </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($citizens as $citizen)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <!--begin::Checkbox-->
                        <td class="px-2 py-1">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox"  name="citizens[]" value="{{ $citizen->id }}"/>
                            </div>
                        </td>
                        <!--begin::Checkbox-->
                        <td class="px-2 py-1 bg-gray-50">
                        <a href="{{ route('citizens.show',$citizen->id) }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                            {{ $citizen->id }}
                            </a>
                        </td>
                        <td class="px-2 py-1">
                            <a href="{{ route('citizens.show',$citizen->id) }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                                {{ $citizen->name }}
                            </a>
                        </td>
                        <td class="px-2 py-1 bg-gray-50">{{ $citizen->date_of_birth }}</td>
                        <td class="px-2 py-1">{{ $citizen->gender }}</td>
                        <td class="px-2 py-1 bg-gray-50">{{ $citizen->wife_name }}</td>
                        <td class="px-2 py-1">{{ $citizen->social_status }}</td>
                        <td class="px-2 py-1 bg-gray-50">{{ $citizen->region->name ?? 'N/A' }}</td>
                        <td class="px-2 py-1">{{ $citizen->note }}</td>
                        <td class="px-2 py-1 bg-gray-50">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        @if($distributionId)
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md">Add to Distribution</button>
        @else
            <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-md" id="open-modal">Add to Distribution</button>
        @endif
    </div>
</form>

    @if(!$distributionId)
        <div id="distribution-modal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 hidden">
            <div class="bg-white p-6 rounded-md shadow-md w-1/3">
                <h2 class="text-lg font-semibold mb-4">Select Distribution</h2>
                <form id="modal-form" method="POST" action="{{ route('distributions.addCitizens') }}">
                    @csrf
                    <input type="hidden" name="citizen_ids" id="citizen-ids">
                    <select name="distribution_id" class="form-select mt-1 block w-full mb-4">
                        <option value="">Select Distribution</option>
                        @foreach($distributions as $distribution)
                            <option value="{{ $distribution->id }}">{{ $distribution->name }}</option>
                        @endforeach
                    </select>
                    <div class="flex justify-end">
                        <button type="button" class="px-4 py-2 bg-gray-600 text-white rounded-md mr-2" id="close-modal">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

@push('scripts')
<script>
$(document).ready(function() {
    $('#citizens-table').DataTable({
        responsive: true,
        "scrollY": "4000px",
        "scrollCollapse": true,
        "paging": false,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search citizens..."
        }
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
</script>
@endpush