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
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
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
                                        <td>{{ $member->firstname }} {{ $member->secondname }} {{ $member->thirdname }}
                                            {{ $member->lastname }}</td>
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
                                        <td>{{ $member->date_of_birth ? $member->date_of_birth->format('Y-m-d') : 'غير محدد' }}
                                        </td>
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
                        @if (isset( $member->citizen))
                        @php
                            $citizen =  $member->citizen

                        @endphp
                        <div class="bg-white rounded-lg shadow-lg p-6 mt-4 mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-bold text-gray-800">الاسرة التي ينتمي اليها </h2>
                                <button onclick="copyToClipboard()"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                                    <i class="fas fa-copy ml-2"></i>
                                    نسخ
                                </button>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="py-2 px-4 text-right text-gray-600">رقم الهوية</th>
                                            <th class="py-2 px-4 text-right text-gray-600">الاسم رباعي</th>
                                            <th class="py-2 px-4 text-right text-gray-600">الاسم الاول</th>
                                            <th class="py-2 px-4 text-right text-gray-600">اسم الاب</th>
                                            <th class="py-2 px-4 text-right text-gray-600">اسم الجد</th>
                                            <th class="py-2 px-4 text-right text-gray-600">اسم العائلة</th>
                                            <th class="py-2 px-4 text-right text-gray-600">رقم الجوال</th>
                                            <th class="py-2 px-4 text-right text-gray-600">رقم الجوال البديل</th>
                                            <th class="py-2 px-4 text-right text-gray-600">رقم هوية الزوجة</th>
                                            <th class="py-2 px-4 text-right text-gray-600">اسم الزوجة رباعي</th>
                                            <th class="py-2 px-4 text-right text-gray-600">عدد الافراد</th>
                                            <th class="py-2 px-4 text-right text-gray-600">عدد الذكور</th>
                                            <th class="py-2 px-4 text-right text-gray-600">عدد الاناث</th>
                                            <th class="py-2 px-4 text-right text-gray-600">الحالة الاجتماعية</th>
                                            <th class="py-2 px-4 text-right text-gray-600">مكان السكن الاصلي</th>
                                            <th class="py-2 px-4 text-right text-gray-600">وصف ذوي الامراض المزمنة</th>
                                            <th class="py-2 px-4 text-right text-gray-600">ملاحظات</th>
                                            <th class="py-2 px-4 text-right text-gray-600">عدد الافراد اقل من 3 سنوات</th>
                                            <th class="py-2 px-4 text-right text-gray-600">عدد الافراد ذوي الامراض المزمنة
                                            </th>
                                            <th class="py-2 px-4 text-right text-gray-600">عدد الافراد ذوي الاحتياجات الخاصة
                                            </th>
                                            <th class="py-2 px-4 text-right text-gray-600">معيل الاسرة</th>
                                            <th class="py-2 px-4 text-right text-gray-600">حالة السكن</th>
                                            <th class="py-2 px-4 text-right text-gray-600">وصف ذوي الاحتياجات الخاصة</th>
                                            <th class="py-2 px-4 text-right text-gray-600">مكان السكن الاصلي</th>
                                            <th class="py-2 px-4 text-right text-gray-600">عدد كبار السن</th>
                                            <th class="py-2 px-4 text-right text-gray-600">تاريخ الميلاد</th>
                                            <th class="py-2 px-4 text-right text-gray-600">الجنس</th>
                                            <th class="py-2 px-4 text-right text-gray-600">الحالة</th>
                                            <th class="py-2 px-4 text-right text-gray-600">المندوب</th>
                                            <th class="py-2 px-4 text-right text-gray-600">المنطقة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="excelData" class="hover:bg-gray-50">
                                            <td class="py-2 px-4">{{ $citizen->id }}</td>
                                            <td class="py-2 px-4">
                                                {{ $citizen->firstname . ' ' . $citizen->secondname . ' ' . $citizen->thirdname . ' ' . $citizen->lastname }}
                                            </td>
                                            <td class="py-2 px-4">{{ $citizen->firstname }}</td>
                                            <td class="py-2 px-4">{{ $citizen->secondname }}</td>
                                            <td class="py-2 px-4">{{ $citizen->thirdname }}</td>
                                            <td class="py-2 px-4">{{ $citizen->lastname }}</td>
                                            <td class="py-2 px-4">{{ $citizen->phone }}</td>
                                            <td class="py-2 px-4">{{ $citizen->phone2 }}</td>
                                            <td class="py-2 px-4">{{ $citizen->wife_id }}</td>
                                            <td class="py-2 px-4">{{ $citizen->wife_name }}</td>
                                            <td class="py-2 px-4">{{ $citizen->family_members }}</td>
                                            <td class="py-2 px-4">{{ $citizen->mails_count }}</td>
                                            <td class="py-2 px-4">{{ $citizen->femails_count }}</td>
                                            <td class="py-2 px-4">{{ $citizen->social_status }}</td>
                                            <td class="py-2 px-4">{{ $citizen->original_address }}</td>
                                            <td class="py-2 px-4">{{ $citizen->disease_description }}</td>
                                            <td class="py-2 px-4">{{ $citizen->note }}</td>
                                            <td class="py-2 px-4">{{ $citizen->leesthan3 }}</td>
                                            <td class="py-2 px-4">{{ $citizen->disease ? 1 : 0 }}</td>
                                            <td class="py-2 px-4">{{ $citizen->obstruction ? 1 : 0 }}</td>
                                            <td class="py-2 px-4">{{ $citizen->job }}</td>
                                            <td class="py-2 px-4">{{ $citizen->living_status }}</td>
                                            <td class="py-2 px-4">{{ $citizen->obstruction_description }}</td>
                                            <td class="py-2 px-4">{{ $citizen->original_address }}</td>
                                            <td class="py-2 px-4">{{ $citizen->elderly_count }}</td>
                                            <td class="py-2 px-4">{{ $citizen->date_of_birth }}</td>
                                            <td class="py-2 px-4">{{ $citizen->gender == '0' ? 'ذكر' : 'انثى' }}</td>
                                            <td class="py-2 px-4">{{ $citizen->is_archived ? 'مؤرشف' : 'نشط' }}</td>
                                            <td class="py-2 px-4">
                                                {{ $citizen->region->representatives->first()->name ?? 'غير محدد' }}</td>
                                            <td class="py-2 px-4">{{ $citizen->region->name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
        
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">إضافة إلى فئة</h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('categories.addMember') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="category_id">اختر الفئة</label>
                                                        <select name="category_id" id="category_id" class="form-control"
                                                            required>
                                                            <option value="">اختر الفئة</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}"
                                                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="size">الحجم</label>
                                                        <input type="text" class="form-control" id="size"
                                                            name="size">
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
                                                        <input type="number" step="0.01" class="form-control"
                                                            id="amount" name="amount">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="property1">خاصية 1</label>
                                                        <input type="text" class="form-control" id="property1"
                                                            name="property1">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="property2">خاصية 2</label>
                                                        <input type="text" class="form-control" id="property2"
                                                            name="property2">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="property3">خاصية 3</label>
                                                        <input type="text" class="form-control" id="property3"
                                                            name="property3">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="property4">خاصية 4</label>
                                                        <input type="text" class="form-control" id="property4"
                                                            name="property4">
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="member_id" value="{{ $member->national_id }}">
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
                                            @foreach ($member->categories as $category)
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

@push('scripts')
<script>
    function copyToClipboard() {
        // Get all cells from the row
        const cells = document.querySelectorAll('#excelData td');
        
        // Create an array to hold the cell values
        const values = Array.from(cells).map(cell => cell.textContent.trim());
        
        // Join the values with tabs for Excel compatibility
        const textToCopy = values.join('\t');
        
        // Copy to clipboard
        navigator.clipboard.writeText(textToCopy).then(() => {
            // Show success message
            alert('تم نسخ البيانات بنجاح! يمكنك الآن لصقها في Excel');
        }).catch(err => {
            console.error('Failed to copy text: ', err);
            alert('حدث خطأ أثناء نسخ البيانات');
        });
    }
    </script>
@endpush
