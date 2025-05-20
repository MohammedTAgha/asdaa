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
                        <p style="color: red;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">التعيين التلقائي لأفراد العائلة</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> معلومات عن العملية</h5>
                        <p>سيقوم النظام بإجراء العمليات التالية:</p>
                        <ul>
                            <li>تعيين المواطن كأب تلقائياً إذا كان ذكراً</li>
                            <li>تعيين الزوجة كأم تلقائياً إذا كانت موجودة</li>
                        </ul>
                    </div>

                    <div class="text-center mt-4">
                        <form action="{{ route('family-members.process-automatic-assignment') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-magic"></i> بدء المعالجة التلقائية
                            </button>
                        </form>
                        
                        <a href="{{ route('family-members.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> العودة
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
       <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">التعيين التلقائي ل العائلة</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> معلومات عن العملية</h5>
                        <p>سيقوم النظام بإجراء العمليات التالية:</p>
                        <ul>
                            <li>تعيين المواطن كأب تلقائياً إذا كان ذكراً</li>
                            <li>تعيين الزوجة كأم تلقائياً إذا كانت موجودة</li>
                        </ul>
                    </div>

                    <div class="text-center mt-4">
                        <form action="{{ route('family-members.process-citizen') }}" method="POST" class="d-inline">
                            <input type="text" name="id">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-magic"></i> بدء المعالجة التلقائية
                            </button>
                        </form>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
