@extends('dashboard')
@section('title','اجراءات')
@section('content')

@props(['distributionId' => null,'distribution'=>null])

<div class="w-90">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="AddCitizensIdListModalLabel">إجراءات على المواطنين</h5>
        </div>
        <div class="modal-body">
            <form id="check-citizens-form" method="POST" action="{{ route('citizens.check') }}">
                @csrf
                <div class="form-group">
                    <label for="citizen-ids">أدخل أرقام الهوية الوطنية للمواطنين (كل رقم في سطر)</label>
                    <textarea class="form-control" id="citizen-ids" name="citizen_ids" rows="6" placeholder="......&#10;.....&#10;..." required></textarea>
                    <small class="form-text text-muted">يجب أن تكون الهوية 9 أرقام وصالحة حسب معادلة التحقق</small>
                </div>

                <div class="modal-footer" style="direction: rtl">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> فحص المواطنين
                    </button>
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('citizen-ids').value = ''">
                        <i class="fas fa-eraser"></i> مسح
                    </button>
                </div>
            </form>

            @if(session('check_results'))
            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6>نتائج الفحص:</h6>
                    <form action="{{ route('citizens.export-selected') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="citizen_ids" value="{{ session('last_checked_ids') }}">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> تصدير النتائج
                        </button>
                    </form>
                </div>
                
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" id="idFilter" class="form-control" placeholder="فلترة برقم الهوية">
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="nameFilter" class="form-control" placeholder="فلترة بالاسم">
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="regionFilter" class="form-control" placeholder="فلترة بالمنطقة">
                    </div>
                    <div class="col-md-3">
                        <select id="statusFilter" class="form-control">
                            <option value="">الكل</option>
                            <option value="valid-exists">موجود وصالح</option>
                            <option value="valid-not-exists">غير موجود وصالح</option>
                            <option value="invalid-exists">موجود وغير صالح</option>
                            <option value="invalid-not-exists">غير موجود وغير صالح</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="resultsTable">
                        <thead class="bg-light">
                            <tr>
                                <th onclick="sortTable(0)" class="sortable">رقم الهوية</th>
                                <th onclick="sortTable(1)" class="sortable">الحالة</th>
                                <th onclick="sortTable(2)" class="sortable">الاسم</th>
                                <th onclick="sortTable(3)" class="sortable">المنطقة</th>
                                <th onclick="sortTable(4)" class="sortable">عدد أفراد العائلة</th>
                                <th onclick="sortTable(5)" class="sortable">عدد التوزيعات</th>
                                <th onclick="sortTable(6)" class="sortable">التوزيعات المكتملة</th>
                                <th>التفاصيل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(session('check_results') as $result)
                            <tr class="citizen-row {{ !$result['is_valid'] ? 'table-danger' : '' }}">
                                <td>{{ $result['id'] }}</td>
                                <td>
                                    @if($result['exists'] && $result['is_valid'])
                                        <span class="badge bg-success">موجود وصالح</span>
                                    @elseif($result['exists'] && !$result['is_valid'])
                                        <span class="badge bg-warning">موجود وغير صالح</span>
                                    @elseif(!$result['exists'] && $result['is_valid'])
                                        <span class="badge bg-info">غير موجود وصالح</span>
                                    @else
                                        <span class="badge bg-danger">غير موجود وغير صالح</span>
                                    @endif
                                </td>
                                <td>{{ $result['name'] }}</td>
                                <td>{{ $result['region'] }}</td>
                                <td>{{ $result['family_members'] }}</td>
                                <td>{{ $result['total_distributions'] }}</td>
                                <td>{{ $result['completed_distributions'] }}</td>
                                <td>
                                    @if($result['exists'])
                                        <a href="{{ route('citizens.show', $result['id']) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> عرض
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .sortable {
        cursor: pointer;
    }
    .sortable:hover {
        background-color: #f5f5f5;
    }
    .badge {
        font-size: 0.9em;
        padding: 0.5em 1em;
    }
    .table th {
        white-space: nowrap;
    }
    .table-danger {
        background-color: #ffe6e6 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // ID validation on input
    document.getElementById('check-citizens-form').addEventListener('submit', function(e) {
        const textarea = document.getElementById('citizen-ids');
        const ids = textarea.value.trim().split(/\r?\n/).filter(id => id.trim() !== '');
        
        if (ids.length === 0) {
            e.preventDefault();
            alert('الرجاء إدخال رقم هوية واحد على الأقل');
            return;
        }

        // Validate each ID
        // const invalidIds = ids.filter(id => !isValidPalestinianId(id));
        // if (invalidIds.length > 0) {
        //     e.preventDefault();
        //     alert('الأرقام التالية غير صالحة:\n' + invalidIds.join('\n'));
        //     return;
        // }
        
        textarea.value = ids.join('\n');
    });

    // Palestinian ID validation function
    function isValidPalestinianId(id) {
        if (!/^\d{9}$/.test(id)) return false;
        
        let sum = 0;
        for (let i = 0; i < 8; i++) {
            let digit = parseInt(id[i]);
            if (i % 2 === 0) {
                sum += digit;
            } else {
                let doubled = digit * 2;
                sum += doubled > 9 ? doubled - 9 : doubled;
            }
        }
        
        let checkDigit = (10 - (sum % 10)) % 10;
        return checkDigit === parseInt(id[8]);
    }

    // Table filtering
    function filterTable() {
        const idFilter = document.getElementById('idFilter').value.toLowerCase();
        const nameFilter = document.getElementById('nameFilter').value.toLowerCase();
        const regionFilter = document.getElementById('regionFilter').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;

        document.querySelectorAll('.citizen-row').forEach(row => {
            const id = row.cells[0].textContent.toLowerCase();
            const status = row.cells[1].textContent.toLowerCase();
            const name = row.cells[2].textContent.toLowerCase();
            const region = row.cells[3].textContent.toLowerCase();

            const matchesId = id.includes(idFilter);
            const matchesName = name.includes(nameFilter);
            const matchesRegion = region.includes(regionFilter);
            const matchesStatus = statusFilter === '' || 
                (statusFilter === 'valid-exists' && status.includes('موجود وصالح')) ||
                (statusFilter === 'valid-not-exists' && status.includes('غير موجود وصالح')) ||
                (statusFilter === 'invalid-exists' && status.includes('موجود وغير صالح')) ||
                (statusFilter === 'invalid-not-exists' && status.includes('غير موجود وغير صالح'));

            row.style.display = matchesId && matchesName && matchesRegion && matchesStatus ? '' : 'none';
        });
    }

    // Sort table
    function sortTable(columnIndex) {
        const table = document.getElementById('resultsTable');
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        const isNumeric = columnIndex === 0 || columnIndex === 4 || columnIndex === 5 || columnIndex === 6;

        rows.sort((a, b) => {
            let aValue = a.cells[columnIndex].textContent.trim();
            let bValue = b.cells[columnIndex].textContent.trim();

            if (isNumeric) {
                aValue = aValue === '-' ? -1 : parseInt(aValue);
                bValue = bValue === '-' ? -1 : parseInt(bValue);
                return aValue - bValue;
            }
            return aValue.localeCompare(bValue, 'ar');
        });

        const tbody = table.querySelector('tbody');
        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));
    }

    // Add event listeners for filters
    document.getElementById('idFilter').addEventListener('input', filterTable);
    document.getElementById('nameFilter').addEventListener('input', filterTable);
    document.getElementById('regionFilter').addEventListener('input', filterTable);
    document.getElementById('statusFilter').addEventListener('change', filterTable);
</script>
@endpush

@endsection