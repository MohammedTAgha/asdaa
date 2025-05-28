@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">الفئات</h5>
                    <div>
                        <a href="{{ route('categories.create') }}" class="btn btn-primary">إضافة فئة جديدة</a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>الاسم</th>
                                    <th>الوصف</th>
                                    <th>عدد الأعضاء</th>
                                    <th>الحالة</th>
                                    <th class="text-center">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ Str::limit($category->description, 50) }}</td>
                                        <td>{{ $category->family_members_count }}</td>
                                        <td>
                                            <span class="badge {{ $category->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $category->status === 'active' ? 'نشط' : 'غير نشط' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> عرض
                                                </a>
                                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> تعديل
                                                </a>
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذه الفئة؟')">
                                                        <i class="fas fa-trash"></i> حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 