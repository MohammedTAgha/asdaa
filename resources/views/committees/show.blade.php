@extends('dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="mb-0">بيانات اللجنة </h1>
                        <div class="btn-group">
                            <a href="{{ route('committees.edit', $committee) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> تعديل
                            </a>
                            <form action="{{ route('committees.destroy', $committee) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> حذف
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="name">الاسم</label>
                        <p class="form-control-plaintext">{{ $committee->name }}</p>
                    </div>

                    <div class="form-group">
                        <label for="manager_id">المدير المسؤول</label>
                        <p class="form-control-plaintext">{{ $committee->manager->name ?? 'N/A' }}</p>
                    </div>

                    <div class="form-group">
                        <label for="description">الوصف</label>
                        <p class="form-control-plaintext">{{ $committee->description }}</p>
                    </div>

                    <div class="form-group">
                        <label for="note">ملاحظات</label>
                        <p class="form-control-plaintext">{{ $committee->note }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection