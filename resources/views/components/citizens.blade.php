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

<form id="add-citizens-form" action="{{ route('distributions.addCitizens') }}" method="POST">
    @csrf
    <input type="hidden" id="distributionId" name="distributionId" value="{{ $distributionId ?? '' }}">
    <input type="hidden" name="citizens" value="{{ implode(',', $citizenIds ?? []) }}">
    
    <button type="button" id="add-citizens-btn" class="btn btn-primary">Add Citizens</button>
</form>

<table id="citizens-table"   class="table table-bordered table-condensed table-striped">
    <thead class="bg-gray-50">
        <tr class="text-start ">
            <th class="w-8px p-0">
                <div class="form-check form-check-sm form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" id="select-all" value="1"/>
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


@push('scripts')
<script>
$(document).ready(function() {
    console.log('load')
    var table = $('#citizens-table').DataTable({
        processing: false,
        serverSide: true,
        ajax: "{{ route('citizens.data') }}",
        columns: [
            { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'date_of_birth', name: 'date_of_birth' },
            { data: 'gender', name: 'gender' },
            { data: 'wife_name', name: 'wife_name' },
            { data: 'social_status', name: 'social_status' },
            { data: 'region', name: 'region.name' },
            { data: 'note', name: 'note' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        'order': [[1, 'asc']],
    });

    // Handle select-all checkbox
    $('#select-all').on('click', function() {
        var rows = table.rows({ 'search': 'applied' }).nodes();
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


