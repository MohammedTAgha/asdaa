@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">تفاصيل الفئة: {{ $category->name }}</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('categories.export', $category) }}" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> تصدير الأعضاء
                        </a>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> تعديل
                        </a>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> العودة للقائمة
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">معلومات الفئة</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th class="w-25">الاسم:</th>
                                            <td>{{ $category->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>الوصف:</th>
                                            <td>{{ $category->description }}</td>
                                        </tr>
                                        <tr>
                                            <th>الحالة:</th>
                                            <td>
                                                <span class="badge {{ $category->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $category->status === 'active' ? 'نشط' : 'غير نشط' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">إضافة أعضاء جدد</h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('categories.add-members', $category) }}" method="POST">
                                        @csrf
                                        <div class="row"> 
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="ids">أرقام الأعضاء (كل رقم في سطر جديد)</label>
                                                    <textarea name="ids" id="ids" class="form-control mb-3" rows="5" style="direction: ltr;">{{ session('search_ids') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="size">الحجم</label>
                                                    <input type="text" class="form-control" id="size" name="size">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="amount">المبلغ</label>
                                                    <input type="number" step="0.01" class="form-control" id="amount" name="amount">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="description">الوصف</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="date">التاريخ</label>
                                                    <input type="date" class="form-control" id="date" name="date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="property1">خاصية 1</label>
                                                    <input type="text" class="form-control" id="property1" name="property1">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="property2">خاصية 2</label>
                                                    <input type="text" class="form-control" id="property2" name="property2">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="property3">خاصية 3</label>
                                                    <input type="text" class="form-control" id="property3" name="property3">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="property4">خاصية 4</label>
                                                    <input type="text" class="form-control" id="property4" name="property4">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> إضافة الأعضاء
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">الأعضاء في هذه الفئة</h6>
                                    <span class="badge bg-primary">{{ $category->familyMembers->count() }} عضو</span>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>الاسم</th>
                                                    <th>رقم الهوية</th>
                                                    <th>الحجم</th>
                                                    <th>الوصف</th>
                                                    <th>المبلغ</th>
                                                    <th>التاريخ</th>
                                                    <th class="text-center">الإجراءات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($category->familyMembers()->paginate(10) as $member)
                                                    <tr>
                                                        <td>{{ $member->fullName }}</td>
                                                        <td>{{ $member->national_id }}</td>
                                                        <td>{{ $member->pivot->size }}</td>
                                                        <td>{{ $member->pivot->description }}</td>
                                                        <td>{{ $member->pivot->amount }}</td>
                                                        <td>{{ $member->pivot->date ? $member->pivot->date->format('Y-m-d') : 'N/A' }}</td>
                                                        <td>
                                                            <div class="d-flex justify-content-center gap-2">
                                                                <a href="{{ route('family-members.show', $member) }}" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-eye"></i> عرض
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">لا يوجد أعضاء في هذه الفئة</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $category->familyMembers()->paginate(10)->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 