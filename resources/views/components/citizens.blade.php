@props(['citizens'])

<form id="citizens-form" method="POST" action="{{ route('distributions.addCitizens') }}">
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
                                <input class="form-check-input" type="checkbox" value="1" />
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
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md">Add to Distribution</button>
    </div>
</form>

@push('scripts')
<script>
$(document).ready(function() {
    $('#citizens-table').DataTable({
        responsive: true,
        pagingType: 'simple_numbers',
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search citizens..."
        }
    });

    $('#select-all').on('change', function() {
        const checkboxes = $('input[name="citizens[]"]');
        checkboxes.prop('checked', $(this).prop('checked'));
    });
});
</script>
@endpush