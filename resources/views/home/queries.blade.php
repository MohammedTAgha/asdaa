@extends('dashboard')

@section('title', 'البحث عن مواطن')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('queries') }}" class="mb-4">
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
                            <button class="btn btn-primary" type="submit">
                                <i class="ti ti-search me-1"></i>بحث
                            </button>
                        </div>
                        <small class="text-muted">
                            يمكنك البحث باستخدام رقم الهوية, الاسم الكامل او الجزئي, اسم الزوجة, او الملاحظات
                        </small>
                    </div>
                </div>

                <!-- Detailed Name Search -->
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-3 text-muted">بحث تفصيلي بالاسم</h6>
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
@endsection
