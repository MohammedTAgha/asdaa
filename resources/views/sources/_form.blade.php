@extends('dashboard')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>{{ isset($source) ? 'تحرير' : 'جديد' }}</h2>
        </div>
        <div class="card-body">
            <form action="{{ isset($source) ? route('sources.update', $source->id) : route('sources.store') }}" method="POST">
                @csrf
                @if(isset($source))
                    @method('PUT')
                @endif

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">الاسم</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $source->name ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">الهاتف</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $source->phone ?? '') }}" >
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="email" class="form-label">الايميل</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $source->email ?? '') }}"  >
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('sources.index') }}" class="btn btn-secondary">رجوع</a>
                    <button type="submit" class="btn btn-primary">{{ isset($source) ? 'تحديث' : 'اضافة' }} مصدر</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
