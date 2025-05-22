@extends('layouts.app')

@section('title', 'تقرير التعيين التلقائي لأفراد العائلة')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">نتائج التعيين التلقائي لأفراد العائلة</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">تمت معالجتهم</span>
                                    <span class="info-box-number">{{ $results['processed'] ?? '-'}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-male"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">الآباء المضافون</span>
                                    <span class="info-box-number">{{ $results['father_added'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-female"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">الأمهات المضافات</span>
                                    <span class="info-box-number">{{ $results['mother_added'] }}</span>
                                </div>
                            </div>
                        </div>

                          <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-female"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">الابناء المضافات</span>
                                    <span class="info-box-number">{{ $results['children_added'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-exclamation-triangle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">الأخطاء</span>
                                    <span class="info-box-number">{{ count($results['errors']) ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(count($results['errors']) > 0)
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">الأخطاء</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>رقم المواطن</th>
                                        <th>الخطأ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                                                        {{-- @foreach($results['errors'] as $errorEntry)
                                    @foreach($errorEntry['errors'] as $error)
                                    <tr>
                                        <td>{{ $errorEntry['citizen_id'] }}</td>
                                        <td>{{ $error }}</td>
                                    </tr>
                                    @endforeach
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    @if(count($results['skipped']) > 0)
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">السجلات المتخطاة</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>رقم المواطن</th>
                                        <th>السبب</th>
                                    </tr>
                                </thead>
                                <tbody>                                    @foreach($results['skipped'] as $skippedEntry)
                                    @foreach($skippedEntry['reasons'] as $reason)
                                    <tr>
                                        <td>{{ $skippedEntry['citizen_id'] }}</td>
                                        <td>{{ $reason }}</td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    @if(isset($results['failure_report_url']))
                    <div class="card card-danger mb-4">
                        <div class="card-header">
                            <h3 class="card-title">تقرير الإضافات الفاشلة</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered text-nowrap">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>رقم المواطن</th>
                                        <th>جنس المواطن</th>
                                        <th>رقم الزوج/ة</th>
                                        <th>جنس الزوج/ة</th>
                                        <th>نوع العلاقة</th>
                                        <th>نوع الإضافة</th>
                                        <th>الحالة</th>
                                        <th>سبب الفشل</th>
                                        <th>تاريخ المحاولة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($failures as $failure)
                                    <tr>
                                        <td class="text-primary">{{ $failure['citizen_id'] }}</td>
                                        <td class="{{ $failure['citizen_gender'] === 'ذكر' ? 'bg-info bg-opacity-10' : ($failure['citizen_gender'] === 'أنثى' ? 'bg-pink bg-opacity-10' : '') }}">
                                            {{ $failure['citizen_gender'] ?? '---' }}
                                        </td>
                                        <td class="text-danger">{{ $failure['person_id'] ?? '---' }}</td>
                                        <td class="{{ $failure['person_gender'] === 'ذكر' ? 'bg-info bg-opacity-10' : ($failure['person_gender'] === 'أنثى' ? 'bg-pink bg-opacity-10' : '') }}">
                                            {{ $failure['person_gender'] ?? '---' }}
                                        </td>
                                        <td>{{ $failure['relationship'] ?? '---' }}</td>
                                        <td>{{ $failure['relationship'] === 'father' ? 'إضافة كأب' : 'إضافة كأم' }}</td>
                                        <td class="text-danger bg-danger bg-opacity-10">فشل</td>
                                        <td>{{ $failure['reason'] }}</td>
                                        <td>{{ $failure['attempt_date'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <a href="{{ $results['failure_report_url'] }}" class="btn btn-warning btn-lg" target="_blank">
                            <i class="fas fa-download"></i> تحميل تقرير الإضافات الفاشلة
                        </a>
                    </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('family-members.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> العودة إلى قائمة أفراد العائلة
                        </a>
                        <button type="button" class="btn btn-success" onclick="window.print()">
                            <i class="fas fa-print"></i> طباعة التقرير
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
