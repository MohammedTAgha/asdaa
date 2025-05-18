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
                                    <span class="info-box-number">{{ $results['processed'] }}</span>
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
                                <span class="info-box-icon bg-warning"><i class="fas fa-exclamation-triangle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">الأخطاء</span>
                                    <span class="info-box-number">{{ count($results['errors']) }}</span>
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
                                <tbody>                                    @foreach($results['errors'] as $errorEntry)
                                    @foreach($errorEntry['errors'] as $error)
                                    <tr>
                                        <td>{{ $errorEntry['citizen_id'] }}</td>
                                        <td>{{ $error }}</td>
                                    </tr>
                                    @endforeach
                                    @endforeach
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
