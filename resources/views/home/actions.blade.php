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
            <!-- Main Form Section -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">إدخال أرقام الهوية</h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label for="citizen-ids" class="block text-sm font-medium text-gray-700 mb-1">أدخل أرقام الهوية الوطنية للمواطنين (كل رقم في سطر)</label>
                        <textarea class="w-full px-4 py-2 border rounded-md" id="citizen-ids" rows="6" placeholder="......&#10;.....&#10;..." required></textarea>
                        <small class="text-gray-500">يجب أن تكون الهوية 9 أرقام وصالحة حسب معادلة التحقق</small>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <!-- Check Citizens Form -->
                            <form id="check-citizens-form" method="POST" action="{{ route('citizens.check') }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="citizen_ids" id="check-ids-input">
                                <div class="flex space-x-2">
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="return copyIdsToForm('check-ids-input')">
                                        <i class="fas fa-search"></i> فحص المواطنين
                                    </button>
                                    
                                    <button type="button" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600" onclick="document.getElementById('citizen-ids').value = ''">
                                        <i class="fas fa-eraser"></i> مسح
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div>
                            <!-- Change Region Form -->
                            <form action="{{ route('citizens.change-region-checked') }}" method="POST" class="d-inline" id="changeRegionForm">
                                @csrf
                                <input type="hidden" name="citizen_ids" id="region-ids-input">
                                <div class="flex space-x-2">
                                    <select name="region_id" class="w-full px-4 py-2 border rounded-md" required>
                                        <option value="">اختر المنطقة</option>
                                        @foreach(\App\Models\Region::all() as $region)
                                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600" onclick="return copyIdsToForm('region-ids-input') && confirm('هل أنت متأكد من تغيير المنطقة للمواطنين المحددين؟')">
                                        <i class="fas fa-map-marker-alt"></i> تغيير المنطقة
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div>
                            <!-- Delete Citizens Form -->
                            <form action="{{ route('citizens.remove') }}" method="POST" class="d-inline" id="deleteCitizensForm">
                                @csrf
                                <input type="hidden" name="citizenIds" id="delete-ids-input">
                                <div class="flex space-x-2">
                                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" 
                                            onclick="return handleDelete(event)">
                                        <i class="fas fa-trash"></i> حذف المواطنين
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div>
                            <!-- Export with Distributions Form -->
                            <form action="{{ route('citizens.export-with-distributions') }}" method="POST" class="d-inline" id="exportDistributionsForm">
                                @csrf
                                <input type="hidden" name="citizen_ids" id="export-dist-ids-input">
                                <div class="flex flex-col space-y-2">
                                    <select name="distribution_ids[]" multiple class="w-full px-4 py-2 border rounded-md" id="distribution-select">
                                        <option value="">كل المساعدات</option>
                                        @foreach(\App\Models\Distribution::all() as $distribution)
                                            <option value="{{ $distribution->id }}">{{ $distribution->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600" onclick="return handleDistributionExport()">
                                        <i class="fas fa-file-excel"></i> تصدير مع المساعدات
                                    </button>
                                </div>
                                <small class="text-gray-500">اختر المساعدات المطلوب تصديرها (اترك فارغاً لتصدير الكل)</small>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $('#distribution-select').select2({
                        theme: "classic",
                        dir: "rtl",
                        width: '100%',
                        placeholder: "اختر المساعدات",
                        allowClear: true
                    });
                });
            </script>

            @if(session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('check_results'))
            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6>نتائج الفحص:</h6>
                    <form action="{{ route('citizens.export-selected') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="citizen_ids" id="export-ids-input">
                        <button type="submit" class="btn btn-success" onclick="return copyIdsToForm('export-ids-input')">
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
    .card {
        margin-bottom: 1.5rem;
        border: 1px solid rgba(0,0,0,.125);
        border-radius: 0.25rem;
    }
    .card-header {
        padding: 0.75rem 1.25rem;
        margin-bottom: 0;
        background-color: rgba(0,0,0,.03);
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    .card-body {
        padding: 1.25rem;
    }
    .input-group {
        display: inline-flex;
        width: auto;
        margin-bottom: 0.5rem;
    }
    .btn {
        margin-left: 0.5rem;
    }
    select[multiple] {
        height: auto;
        min-height: 38px;
    }
</style>
@endpush

@push('scripts')
<script>
    function copyIdsToForm(targetInputId) {
        const textarea = document.getElementById('citizen-ids');
        const targetInput = document.getElementById(targetInputId);
        if (textarea.value.trim() === '') {
            alert('الرجاء إدخال رقم هوية واحد على الأقل');
            return false;
        }
        targetInput.value = textarea.value;
        return true;
    }

    function handleDistributionExport() {
        if (!copyIdsToForm('export-dist-ids-input')) {
            return false;
        }
        
        const select = document.getElementById('distribution-select');
        // If "All Distributions" is selected, clear other selections
        if (Array.from(select.selectedOptions).some(option => option.value === '')) {
            select.value = '';
        }
        return true;
    }

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

    function handleDelete(event) {
        event.preventDefault();
        
        if (!copyIdsToForm('delete-ids-input')) {
            return false;
        }

        if (!confirm('هل أنت متأكد من حذف المواطنين المحددين؟ هذا الإجراء لا يمكن التراجع عنه.')) {
            return false;
        }

        const form = document.getElementById('deleteCitizensForm');
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                // Clear the textarea after successful deletion
                document.getElementById('citizen-ids').value = '';
                // If there's a results table, refresh it
                if (document.getElementById('resultsTable')) {
                    location.reload();
                }
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء حذف المواطنين');
        });

        return false;
    }
</script>
@endpush

@endsection