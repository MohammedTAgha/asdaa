@extends('dashboard')

@section('title', 'البحث عن مواطن')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('queries') }}" class="mb-4" id="searchForm">
                <!-- Search Actions -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0">بحث عن مواطن</h5>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-search me-1"></i>بحث
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="clearForm">
                            <i class="ti ti-eraser me-1"></i>مسح النموذج
                        </button>
                    </div>
                </div>

                <!-- General Search -->
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label">بحث عام</label>
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="ابحث بالهوية, الاسم, اسم الزوجة, او الملاحظات..."
                                   dir="rtl">
                            <span class="input-group-text bg-light">
                                <i class="ti ti-search"></i>
                            </span>
                        </div>
                        <small class="text-muted">
                            يمكنك البحث باستخدام رقم الهوية, الاسم الكامل او الجزئي, اسم الزوجة, او الملاحظات
                        </small>
                    </div>
                </div>

                <!-- Detailed Name Search -->
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card bg-light border">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="card-subtitle text-muted mb-0">بحث تفصيلي بالاسم</h6>
                                    <button type="button" class="btn btn-link btn-sm p-0" id="toggleDetailedSearch">
                                        <i class="ti ti-chevron-down"></i>
                                    </button>
                                </div>
                                <div id="detailedSearchFields">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">الاسم الأول</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="first_name" 
                                                   value="{{ request('first_name') }}"
                                                   placeholder="الاسم الأول">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">اسم الأب</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="second_name" 
                                                   value="{{ request('second_name') }}"
                                                   placeholder="اسم الأب">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">اسم الجد</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="third_name" 
                                                   value="{{ request('third_name') }}"
                                                   placeholder="اسم الجد">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">العائلة</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="last_name" 
                                                   value="{{ request('last_name') }}"
                                                   placeholder="العائلة">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Results Section -->
            <div class="mt-4" id="searchResults">
                @if(isset($citizens) && $citizens->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>رقم الهوية</th>
                                    <th>الاسم الكامل</th>
                                    <th>المنطقة</th>
                                    <th>عدد الأفراد</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($citizens as $citizen)
                                    <tr>
                                        <td>{{ $citizen->id }}</td>
                                        <td>{{ $citizen->firstname }} {{ $citizen->secondname }} {{ $citizen->thirdname }} {{ $citizen->lastname }}</td>
                                        <td>{{ optional($citizen->region)->name ?? 'غير محدد' }}</td>
                                        <td>{{ $citizen->family_members }}</td>
                                        <td>
                                            <a href="{{ route('citizens.show', $citizen->id) }}" class="btn btn-sm btn-primary">
                                                <i class="ti ti-eye me-1"></i>عرض
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $citizens->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                @elseif(request()->hasAny(['search', 'first_name', 'second_name', 'third_name', 'last_name']))
                    <div class="alert alert-info">
                        <i class="ti ti-info-circle me-1"></i>
                        لم يتم العثور على نتائج
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Clear form functionality
    document.getElementById('clearForm').addEventListener('click', function() {
        const form = document.getElementById('searchForm');
        const inputs = form.querySelectorAll('input[type="text"]');
        inputs.forEach(input => input.value = '');
    });

    // Toggle detailed search
    const toggleBtn = document.getElementById('toggleDetailedSearch');
    const detailedFields = document.getElementById('detailedSearchFields');
    let isCollapsed = false;

    toggleBtn.addEventListener('click', function() {
        isCollapsed = !isCollapsed;
        if (isCollapsed) {
            detailedFields.style.display = 'none';
            toggleBtn.querySelector('i').classList.replace('ti-chevron-down', 'ti-chevron-up');
        } else {
            detailedFields.style.display = 'block';
            toggleBtn.querySelector('i').classList.replace('ti-chevron-up', 'ti-chevron-down');
        }
    });

    // Add animation to search results
    const searchResults = document.getElementById('searchResults');
    if (searchResults) {
        searchResults.style.opacity = '0';
        searchResults.style.transition = 'opacity 0.3s ease-in-out';
        setTimeout(() => {
            searchResults.style.opacity = '1';
        }, 100);
    }
});
</script>
@endpush
@endsection
