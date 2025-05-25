@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">تفاصيل الفرد: {{ $member->firstname }} {{ $member->lastname }}</h5>
                    <div>
                        <a href="{{ route('family-members.index') }}" class="btn btn-secondary">العودة للقائمة</a>
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
                            <h6>معلومات الفرد</h6>
                            <table class="table">
                                <tr>
                                    <th>الاسم الكامل:</th>
                                    <td>{{ $member->firstname }} {{ $member->secondname }} {{ $member->thirdname }} {{ $member->lastname }}</td>
                                </tr>
                                <tr>
                                    <th>رقم الهوية:</th>
                                    <td>{{ $member->national_id }}</td>
                                </tr>
                                <tr>
                                    <th>صلة القرابة:</th>
                                    <td>
                                        @switch($member->relationship)
                                            @case('father')
                                                الأب
                                                @break
                                            @case('mother')
                                                الأم
                                                @break
                                            @case('son')
                                                ابن
                                                @break
                                            @case('daughter')
                                                ابنة
                                                @break
                                            @default
                                                {{ $member->relationship }}
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <th>الجنس:</th>
                                    <td>{{ $member->gender === 'male' ? 'ذكر' : 'أنثى' }}</td>
                                </tr>
                                <tr>
                                    <th>تاريخ الميلاد:</th>
                                    <td>{{ $member->date_of_birth ? $member->date_of_birth->format('Y-m-d') : 'غير محدد' }}</td>
                                </tr>
                                <tr>
                                    <th>العمر:</th>
                                    <td>{{ $member->date_of_birth ? $member->date_of_birth->age : 'غير محدد' }}</td>
                                </tr>
                                <tr>
                                    <th>المنطقة:</th>
                                    <td>{{ $member->citizen->region->name ?? 'غير محدد' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">إضافة إلى فئة</h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('categories.add-member') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="category_id">اختر الفئة</label>
                                                    <select name="category_id" id="category_id" class="form-control" required>
                                                        <option value="">اختر الفئة</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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
                                                    <label for="amount">الكمية</label>
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
                                        <input type="hidden" name="member_ids" value="{{ $member->id }}">
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary">إضافة إلى الفئة</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h6>الفئات التي ينتمي إليها</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>اسم الفئة</th>
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
                                        @foreach($member->categories as $category)
                                            <tr>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->pivot->size }}</td>
                                                <td>{{ $category->pivot->description }}</td>
                                                <td>{{ $category->pivot->amount }}</td>
                                                <td>{{ $category->pivot->property1 }}</td>
                                                <td>{{ $category->pivot->property2 }}</td>
                                                <td>{{ $category->pivot->property3 }}</td>
                                                <td>{{ $category->pivot->property4 }}</td>
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