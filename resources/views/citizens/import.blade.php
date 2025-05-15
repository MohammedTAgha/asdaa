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
                        <h4 class="alert-heading mb-2">نتائج التحميل</h4>
                        <div class="summary-stats mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>إجمالي السجلات:</strong> {{ session('import_result.summary.total_processed') }}
                                </div>
                                <div class="col-md-3">
                                    <strong>تمت الإضافة:</strong> {{ session('import_result.summary.new_added') }}
                                </div>
                                <div class="col-md-3">
                                    <strong>تم التحديث:</strong> {{ session('import_result.summary.updated') }}
                                </div>
                                <div class="col-md-3">
                                    <strong>فشل:</strong> {{ session('import_result.summary.failed') }}
                                </div>
                            </div>
                        </div>

                        @if(!empty(session('import_result.successful_imports')))
                            <div class="mb-3">
                                <h5>تمت إضافة المواطنين التالية:</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
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
                            <div class="mb-3">
                                <h5>تم تحديث المواطنين التالية:</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
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
                            <div class="mb-3">
                                <h5>فشل استيراد المواطنين التالية:</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
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
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">خيارات التحديث</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="shouldUpdateExisting" name="should_update_existing" value="1">
                                <label class="form-check-label" for="shouldUpdateExisting">
                                    تحديث بيانات المواطنين الموجودين
                                </label>
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
