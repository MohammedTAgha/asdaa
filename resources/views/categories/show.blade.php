@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">تفاصيل الفئة: {{ $category->name }}</h5>
                    <div>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">تعديل</a>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">العودة للقائمة</a>
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
                            <h6>معلومات الفئة</h6>
                            <table class="table">
                                <tr>
                                    <th>الاسم:</th>
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

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">إضافة أعضاء جدد</h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('categories.add-members', $category) }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="member_ids">أرقام الأعضاء (مفصولة بفواصل)</label>
                                                    <input type="text" class="form-control" id="member_ids" name="member_ids" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="size">الحجم</label>
                                                    <input type="text" class="form-control" id="size" name="size">
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
                                                    <label for="amount">المبلغ</label>
                                                    <input type="number" step="0.01" class="form-control" id="amount" name="amount">
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
                                            <button type="submit" class="btn btn-primary">إضافة الأعضاء</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h6>الأعضاء في هذه الفئة</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>الاسم</th>
                                            <th>رقم الهوية</th>
                                            <th>الحجم</th>
                                            <th>الوصف</th>
                                            <th>المبلغ</th>
                                            <th>خاصية 1</th>
                                            <th>خاصية 2</th>
                                            <th>خاصية 3</th>
                                            <th>خاصية 4</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($category->familyMembers as $member)
                                            <tr>
                                                <td>{{ $member->firstname }} {{ $member->lastname }}</td>
                                                <td>{{ $member->national_id }}</td>
                                                <td>{{ $member->pivot->size }}</td>
                                                <td>{{ $member->pivot->description }}</td>
                                                <td>{{ $member->pivot->amount }}</td>
                                                <td>{{ $member->pivot->property1 }}</td>
                                                <td>{{ $member->pivot->property2 }}</td>
                                                <td>{{ $member->pivot->property3 }}</td>
                                                <td>{{ $member->pivot->property4 }}</td>
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
    </div>
</div>
@endsection 