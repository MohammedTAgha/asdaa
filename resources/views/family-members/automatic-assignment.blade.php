@extends('layouts.app')

@section('title', 'التعيين التلقائي لأفراد العائلة')

@section('content')
<div class="container-fluid">
    @if ($errors->any())
        <div class="error-messages">
            @foreach ($errors->all() as $error)
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-error"></i> {{ $error }}</h5>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">التعيين التلقائي لأفراد العائلة</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('family-members.process-automatic-assignment-with-children') }}" method="POST">
                        @csrf
                        
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i> معلومات عن العملية</h5>
                            <p>سيقوم النظام بإجراء العمليات التالية:</p>
                            <ul>
                                <li>تعيين المواطن كأب تلقائياً إذا كان ذكراً</li>
                                <li>تعيين الزوجة كأم تلقائياً إذا كانت موجودة</li>
                                <li>إضافة الأبناء حسب الفلاتر المحددة</li>
                            </ul>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="region_id">المنطقة</label>
                                    <select name="region_id" id="region_id" class="form-control">
                                        <option value="">جميع المناطق</option>
                                        @foreach($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="min_age">الحد الأدنى للعمر</label>
                                    <input type="number" name="min_age" id="min_age" class="form-control" min="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="max_age">الحد الأقصى للعمر</label>
                                    <input type="number" name="max_age" id="max_age" class="form-control" min="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="social_status">الحالة الاجتماعية</label>
                                    <select name="social_status" id="social_status" class="form-control">
                                        <option value="">الكل</option>
                                        <option value="اعزب">اعزب</option>
                                        <option value="متزوج">متزوج</option>
                                        <option value="مطلق">مطلق</option>
                                        <option value="ارمل">ارمل</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="gender">الجنس</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="">الكل</option>
                                        <option value="male">ذكر</option>
                                        <option value="female">أنثى</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-magic"></i> بدء المعالجة التلقائية
                            </button>
                            
                            <a href="{{ route('family-members.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-arrow-left"></i> العودة
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
