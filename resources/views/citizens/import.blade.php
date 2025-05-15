@extends('dashboard')
@section('title',' رفع كشف الى قاعدة البيانات ')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h1 class="mb-4 text-2xl font-bold text-center text-gray-700">تحميل ملف اكسل</h1>
                
                @if (session('errors'))
                    <div class="alert alert-danger mb-4">
                        <strong>أخطاء:</strong>
                        <ul>
                            @foreach (session('errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('import_result'))
                    <div class="alert alert-info mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="alert-heading mb-0">نتائج التحميل</h4>
                            <a href="{{ route('citizens.export-import-report') }}" class="btn btn-primary btn-sm">
                                <i class="ti-xs ti ti-file-export me-1"></i>
                                تصدير التقرير
                            </a>
                        </div>

                        <div class="summary-stats mb-4">
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body p-2 text-center">
                                            <h6 class="mb-1">إجمالي السجلات</h6>
                                            <h4 class="mb-0">{{ session('import_result.summary.total_processed') }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="card bg-success text-white">
                                        <div class="card-body p-2 text-center">
                                            <h6 class="mb-1">تمت الإضافة</h6>
                                            <h4 class="mb-0">{{ session('import_result.summary.new_added') }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="card bg-info text-white">
                                        <div class="card-body p-2 text-center">
                                            <h6 class="mb-1">تم التحديث</h6>
                                            <h4 class="mb-0">{{ session('import_result.summary.updated') }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body p-2 text-center">
                                            <h6 class="mb-1">تم التخطي</h6>
                                            <h4 class="mb-0">{{ session('import_result.summary.skipped') }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="card bg-danger text-white">
                                        <div class="card-body p-2 text-center">
                                            <h6 class="mb-1">فشل</h6>
                                            <h4 class="mb-0">{{ session('import_result.summary.failed') }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="card bg-secondary text-white">
                                        <div class="card-body p-2 text-center">
                                            <h6 class="mb-1">المنطقة</h6>
                                            <h6 class="mb-0">{{ session('import_result.summary.target_region') }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(!empty(session('import_result.successful_imports')))
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0">تمت إضافة المواطنين التالية</h5>
                                    <span class="badge bg-success">{{ count(session('import_result.successful_imports')) }}</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>رقم الهوية</th>
                                                <th>الاسم</th>
                                                <th>المنطقة</th>
                                                <th>الحالة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(session('import_result.successful_imports') as $import)
                                                <tr>
                                                    <td>{{ $import['id'] }}</td>
                                                    <td>{{ $import['name'] }}</td>
                                                    <td>{{ $import['region'] }}</td>
                                                    <td><span class="badge bg-success">{{ $import['status'] }}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if(!empty(session('import_result.updated_citizens')))
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0">تم تحديث المواطنين التالية</h5>
                                    <span class="badge bg-info">{{ count(session('import_result.updated_citizens')) }}</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>رقم الهوية</th>
                                                <th>الاسم</th>
                                                <th>المنطقة السابقة</th>
                                                <th>المنطقة الجديدة</th>
                                                <th>الحالة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(session('import_result.updated_citizens') as $citizen)
                                                <tr>
                                                    <td>{{ $citizen['id'] }}</td>
                                                    <td>{{ $citizen['name'] }}</td>
                                                    <td>{{ $citizen['old_region'] }}</td>
                                                    <td>{{ $citizen['new_region'] }}</td>
                                                    <td><span class="badge bg-info">{{ $citizen['status'] }}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if(!empty(session('import_result.failed_imports')))
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0">فشل استيراد المواطنين التالية</h5>
                                    <span class="badge bg-danger">{{ count(session('import_result.failed_imports')) }}</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>الصف</th>
                                                <th>رقم الهوية</th>
                                                <th>الاسم</th>
                                                <th>السبب</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(session('import_result.failed_imports') as $failure)
                                                <tr>
                                                    <td>{{ $failure['row'] }}</td>
                                                    <td>{{ $failure['id'] }}</td>
                                                    <td>{{ $failure['name'] }}</td>
                                                    <td><span class="badge bg-danger">{{ $failure['error'] }}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if(!empty(session('import_result.skipped_existing')))
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title mb-0">تم تخطي المواطنين التالية (موجودين مسبقاً)</h5>
                                    <span class="badge bg-warning">{{ count(session('import_result.skipped_existing')) }}</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>رقم الهوية</th>
                                                <th>الاسم</th>
                                                <th>المنطقة الحالية</th>
                                                <th>الحالة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(session('import_result.skipped_existing') as $skipped)
                                                <tr>
                                                    <td>{{ $skipped['id'] }}</td>
                                                    <td>{{ $skipped['name'] }}</td>
                                                    <td>{{ $skipped['current_region'] }}</td>
                                                    <td><span class="badge bg-warning">تم التخطي - موجود مسبقاً</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="mb-4 text-center">
                    <a href="{{ route('citizens.template') }}" class="btn btn-outline-primary">
                        <i class="ti-xs ti ti-file-download me-1"></i>
                        تحميل الترويسة
                    </a>
                </div>

                <form action="{{ route('citizens.upload') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="excel_file" class="form-label">اختر ملف اكسل</label>
                            <input type="file" id="excel_file" name="excel_file" required
                                class="form-control">
                            <small class="text-muted">يجب أن يكون الملف بتنسيق Excel (.xlsx, .xls, .csv)</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="regionId" class="form-label">اختر المنطقة:</label>
                            <select id="regionId" name="regionId" class="form-select">
                                <option value="">تحديد من الملف (حسب رقم المنطقة)</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}" 
                                        {{ in_array($region, request('regions', [])) ? 'selected' : '' }}>
                                        @if ($region->representatives->isNotEmpty())
                                            {{ $region->name }} - {{ $region->representatives->first()->name }}
                                        @else
                                            {{ $region->name }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">إذا لم يتم اختيار منطقة، سيتم استخدام المنطقة المحددة في الملف</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">خيارات التحديث</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="shouldUpdateExisting" name="should_update_existing" value="1">
                                <label class="form-check-label" for="shouldUpdateExisting">
                                    تحديث بيانات المواطنين الموجودين
                                </label>
                                <small class="form-text text-muted d-block">
                                    عند تفعيل هذا الخيار، سيتم تحديث بيانات المواطنين الموجودين مسبقاً بالبيانات الجديدة من الملف
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti-xs ti ti-upload me-1"></i>
                            رفع الكشف
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
