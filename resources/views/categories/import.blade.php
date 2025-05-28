@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">استيراد أعضاء للفئة: {{ $category->name }}</h5>
                    <div>
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> العودة للفئة
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <h6 class="alert-heading">تعليمات الاستيراد:</h6>
                        <ol class="mb-0">
                            <li>قم بتحميل قالب الاستيراد أولاً</li>
                            <li>املأ البيانات في القالب حسب المطلوب</li>
                            <li>قم برفع الملف المملوء</li>
                        </ol>
                    </div>

                    <div class="text-center mb-4">
                        <a href="{{ route('categories.template') }}" class="btn btn-success">
                            <i class="fas fa-download"></i> تحميل قالب الاستيراد
                        </a>
                    </div>

                    <form action="{{ route('categories.import', $category) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">اختر ملف Excel</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept=".xlsx,.xls">
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> استيراد الأعضاء
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 