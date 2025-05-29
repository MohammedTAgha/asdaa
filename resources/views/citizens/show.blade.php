@extends('dashboard')
@php
    $title = 'المستفيد'. " " .$citizen->firstname . " " .  $citizen->secondname .  ' ' .$citizen->lastname 
@endphp
@section('title', $title)

@section('content')
<div class="container mx-auto px-4 py-6">


    <!-- Status Bar -->
    <div class="bg-white rounded-lg shadow-lg p-4 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center space-x-4">
                <div class="flex items-center bg-gray-50 px-4 py-2 rounded-lg">
                    <div class="w-4 h-4 rounded-full mr-2 {{ $validationResults['is_valid'] ? 'bg-green-500' : 'bg-red-500' }}"></div>
                    <span class="font-semibold {{ $validationResults['is_valid'] ? 'text-green-700' : 'text-red-700' }}">
                        {{ $validationResults['is_valid'] ? 'حالة البيانات: صحيحة' : 'حالة البيانات: تحتاج مراجعة' }}
                    </span>
                </div>
                <button onclick="showValidationModal()" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    عرض التفاصيل
                </button>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('citizens.index') }}" 
                   class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors flex items-center">
                    <i class="fas fa-arrow-right ml-2"></i>
                    رجوع
                </a>
                <a href="{{ route('citizens.edit', $citizen->id) }}" 
                   class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors flex items-center">
                    <i class="fas fa-edit ml-2"></i>
                    تعديل
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Information Card -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">المعلومات الأساسية</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">رقم الهوية</label>
                    <p class="mt-1 text-gray-900 font-semibold">{{ $citizen->id }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">الاسم الكامل</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->firstname . " " .  $citizen->secondname . ' ' .$citizen->thirdname. ' ' .$citizen->lastname }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">تاريخ الميلاد</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->date_of_birth }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">الجنس</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->gender == '0' ? 'ذكر' : 'انثى' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">المنطقة</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->region->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">المندوب</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->region->representatives->first()->name ?? 'غير محدد' }}</p>
                </div>
            </div>
        </div>

        <!-- Family Information Card -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">معلومات العائلة</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">اسم الزوجة</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->wife_name ?? 'غير متوفر' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">رقم الزوجة</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->wife_id ?? 'غير متوفر' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">الحالة الاجتماعية</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->social_status }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">الحالة المعيشية</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->living_status }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">عدد كبار السن</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->elderly_count }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">أرمل</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->widowed ? 'نعم' : 'لا' }}</p>
                </div>
            </div>
        </div>

        <!-- Contact & Location Card -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">معلومات الاتصال والموقع</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">رقم الهاتف</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->phone ?? 'غير متوفر' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">رقم هاتف إضافي</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->phone2 ?? 'غير متوفر' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">العنوان الأصلي</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->original_address ?? 'غير متوفر' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">المحافظة الأصلية</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->originalGovernorate->name ?? 'غير متوفر' }}</p>
                </div>
            </div>
        </div>

        <!-- Health & Special Conditions Card -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">الحالة الصحية والظروف الخاصة</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">إعاقة</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->obstruction ? 'نعم' : 'لا' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">وصف الإعاقة</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->obstruction_description ?? 'غير متوفر' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">مرض</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->disease ? 'نعم' : 'لا' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">وصف المرض</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->disease_description ?? 'غير متوفر' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information Card -->
    <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">معلومات إضافية</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-600">المهنة</label>
                <p class="mt-1 text-gray-900">{{ $citizen->job ?? 'غير متوفر' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">الحالة</label>
                <p class="mt-1 text-gray-900">{{ $citizen->is_archived ? 'مؤرشف' : 'نشط' }}</p>
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-600">ملاحظات</label>
                <p class="mt-1 text-gray-900">{{ $citizen->note ?? 'لا توجد ملاحظات' }}</p>
            </div>
        </div>
    </div>

    <!-- Care Provider Section -->
    {{-- <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-xl font-bold mb-4 text-gray-800">مقدم الرعاية</h2>
                @if($citizen->careProvider)
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">الاسم</label>
                            <p class="mt-1 text-gray-900">{{ $citizen->careProvider->firstname }} {{ $citizen->careProvider->secondname }} {{ $citizen->careProvider->lastname }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">العلاقة</label>
                            <p class="mt-1 text-gray-900">{{ __($citizen->careProvider->relationship) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">رقم الهوية</label>
                            <p class="mt-1 text-gray-900">{{ $citizen->careProvider->national_id }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-gray-600">{{ __('لم يتم تعيين مقدم رعاية بعد') }}</p>
                @endif
            </div>
            <a href="{{ route('citizens.care-provider', $citizen) }}" class="btn-primary">
                {{ __('تعديل مقدم الرعاية') }}
            </a>
        </div>
    </div> --}}
        <!-- Excel Data Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mt-4 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">بيانات المستفيد للتنسيق</h2>
                <button onclick="copyToClipboard()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <i class="fas fa-copy ml-2"></i>
                    نسخ للتصدير
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
                            <th class="py-2 px-4 text-right text-gray-600">عدد الافراد ذوي الامراض المزمنة</th>
                            <th class="py-2 px-4 text-right text-gray-600">عدد الافراد ذوي الاحتياجات الخاصة</th>
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
                            <td class="py-2 px-4">{{ $citizen->firstname . " " .  $citizen->secondname . ' ' .$citizen->thirdname. ' ' .$citizen->lastname }}</td>
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
                            <td class="py-2 px-4">{{ $citizen->region->representatives->first()->name ?? 'غير محدد' }}</td>
                            <td class="py-2 px-4">{{ $citizen->region->name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <!-- Family Members Section -->
    <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">أفراد العائلة</h2>
            <a href="{{ route('citizens.family-members.create', $citizen) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                إضافة فرد جديد
            </a>
        </div>

        <!-- Parents -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-3 text-gray-700">الوالدين</h3>
            @if($citizen->familyMembers()->whereIn('relationship', ['father', 'mother'])->exists())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($citizen->familyMembers()->whereIn('relationship', ['father', 'mother'])->get() as $parent)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $parent->relationship == 'father' ? 'الأب' : 'الأم' }}</h4>
                                    <p class="text-gray-600">{{ $parent->firstname }} {{ $parent->secondname }} {{ $parent->thirdname }} {{ $parent->lastname }}</p>
                                    <p class="text-sm text-gray-500">رقم الهوية: {{ $parent->national_id }}</p>
                                    <p class="text-sm text-gray-500">تاريخ الميلاد: {{ $parent->date_of_birth }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('citizens.family-members.edit', [$citizen, $parent]) }}" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('citizens.family-members.destroy', [$citizen, $parent]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('هل أنت متأكد؟')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">لا يوجد معلومات عن الوالدين</p>
            @endif
        </div>

        <!-- Children -->
        <div>
            <h3 class="text-lg font-semibold mb-3 text-gray-700">الأبناء</h3>
            @if($citizen->familyMembers()->whereIn('relationship', ['son', 'daughter'])->exists())
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-2 px-4 text-right text-gray-600">الاسم</th>
                                <th class="py-2 px-4 text-right text-gray-600">الجنس</th>
                                <th class="py-2 px-4 text-right text-gray-600">تاريخ الميلاد</th>
                                <th class="py-2 px-4 text-right text-gray-600">رقم الهوية</th>
                                <th class="py-2 px-4 text-right text-gray-600">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($citizen->familyMembers()->whereIn('relationship', ['son', 'daughter'])->orderBy('date_of_birth')->get() as $child)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4">{{ $child->firstname }} {{ $child->secondname }} {{ $child->thirdname }} {{ $child->lastname }}</td>
                                    <td class="py-2 px-4">{{ $child->gender == 'male' ? 'ذكر' : 'أنثى' }}</td>
                                    <td class="py-2 px-4">{{ $child->date_of_birth }}</td>
                                    <td class="py-2 px-4">{{ $child->national_id }}</td>
                                    <td class="py-2 px-4">
                                        <a href="{{ route('citizens.family-members.edit', [$citizen, $child]) }}" class="text-blue-600 hover:text-blue-800 ml-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('citizens.family-members.destroy', [$citizen, $child]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('هل أنت متأكد؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">لا يوجد أبناء مسجلين</p>
            @endif
        </div>
    </div>
</div>

<!-- Keep existing modals and scripts -->
@component('components.box',['title'=>'الكشوفات','styles'=>'mt-2'])
@slot('side')
        <button class="px-4 py-2 btn btn-primary waves-effect waves-light" onclick="showModal()">اضافة</button>
@endslot
@php
$distributions = $citizen->distributions
@endphp
@if (!$distributions->isEmpty())
<div class="table-responsive">
<table class=" table table-hover min-w-full bg-white">

        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="w-40px  text-white py-3 px-1 uppercase font-semibold text-sm">رقم</th>
                <th class="w-140px text-white  py-3 px-1 uppercase font-semibold text-sm">الوصف</th>
                <th class="w-90px  text-white py-3 px-1 uppercase font-semibold text-sm">المزود</th>
                <th class="w-40px  text-white py-3 px-1 uppercase font-semibold text-sm">الكمية المستلمة</th>
                <th class="w-50px  text-white py-3 px-1 uppercase font-semibold text-sm">استلم</th>
                <th class="w-100px text-white  py-3 px-1 uppercase font-semibold text-sm">اسم المستلم</th>
                <th class="w-120px text-white  py-3 px-1 uppercase font-semibold text-sm">تاريخ الاستلام</th>
                <th class="w-150px text-white  py-3 px-1 uppercase font-semibold text-sm">ملاحظة </th>
                <th class="w-100px text-white  py-3 px-1 uppercase font-semibold text-sm"> - </th>

            </tr>
        </thead>
        <tbody class="text-gray-700">  
        @foreach($distributions as $distribution)
            <tr>
                <td class=" py-3 px-1">
                    <a href="{{ route('distributions.show', $distribution->id) }}" class="text-blue-600 hover:underline">
                    {{ $distribution->pivot->id }}
                    </a> 
                </td> 
             
                <td class=" py-3 px-1">
                <a href="{{ route('distributions.show', $distribution->id) }}" class="text-blue-600 hover:underline">
                {{ $distribution->name }}
                </a>
            </td>
             
                <td class=" py-3 px-1">{{ $distribution->source }}</td>
                <td class=" py-3 px-1">
                    <input class="form-control  " id="html5-number-input"  type="number" name="quantity" value="{{ $distribution->pivot->quantity }}" id="quantity" style="width: 80px;">
                </td>
                <td class="w-90px py-3 px-1">
                <input type="checkbox" name="done" class="form-check-input" value="{{ $distribution->pivot->done }}" {{ $distribution->pivot->done ? 'checked' : '' }}>
                </td>
                <td class=" py-3 px-1">
                <input class="form-control "  name="recipient" value="{{ $distribution->pivot->recipient }}" id="recipient" style="width: 160px;">
                </td>
                <td class=" py-3 px-1">
                    <input class="form-control " type="date" name="date" value="{{ $distribution->pivot->date }} " style="width: 160px;">
                </td>
                <td class=" py-3 px-1"> 
                    <input class="form-control "  name="note" id="note" value="{{ $distribution->pivot->note }}" style="width: 190px;">

                </td>
                <td class="flex-1  py-3 px-1" >
                    <button class="update-button" data-id="{{ $distribution->pivot->id }}" style="color: blue;">
                    <i class="fas fa-upload" style="color: green;"></i>
                    </button>

                    <a href="#" onclick="removeCitizenFromDistribution({{ $distribution->pivot->id }})" class="text-red-600 hover:text-red-900">
                        <i class="fas fa-trash-alt" style="color: red;"></i>
                    </a>                    
                 </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <h2>لم يستلم يعد</h2>
    @endif
</div>

    @endcomponent

</div>
  



</body>
<script>

    function showModal() {
    document.getElementById('addCitizenModal').classList.remove('hidden');
    // Optionally, populate the distribution select options here
}

function hideModal() {
    document.getElementById('addCitizenModal').classList.add('hidden');
}
function showChildModal() {
        document.getElementById('childModal').classList.toggle('hidden');
}
function hideChildModal() {
        document.getElementById('childModal').classList.toggle('hidden');
}

// addin cild frome ere
document.getElementById('addChildForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let formData = new FormData(this);
    fetch('{{ route('children.store') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log(`data`,data);
            let child = data.child;
            let childrenList = document.getElementById('childrenList');
            let newChild = document.createElement('tr');
            newChild.innerHTML = `
                <tr data-id="${child.id}">
                        <td>${child.name}</td>
                        <td>${child.date_of_birth}</td>
                        <td>${child.gender}</td>
                        <td>
                            
                            <button class="delete-button bg-red-500 text-white px-3 py-1 rounded-md" data-id="${child.id}">Delete</button>
                        </td>
                </tr>

            `;
            childrenList.appendChild(newChild);

            // Clear the form
            document.getElementById('addChildForm').reset();
            hideChildModal();
        } else {
            alert('An error occurred while adding the child.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    fetch('{{ route('getDistributions') }}') // Ensure you have this route
        .then(response => response.json())
        .then(data => {
            const distributionSelect = document.getElementById('distributionSelect');
            data.distributions.forEach(distribution => {
                const option = document.createElement('option');
                option.value = distribution.id;
                option.textContent = distribution.name;
                distributionSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
});
function addCitizenToDistribution() {
    const citizenId = {{ $citizen->id }}; // Assuming you have the citizen ID in the Blade template
    const distributionId = document.getElementById('distributionSelect').value;
    console.log(citizenId)
    console.log(distributionId)

    fetch('{{ route('distributions.addCitizens') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            citizens: [citizenId].join(','),
            distributionId: distributionId
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('data')
        console.log(data)
        
        if (data.success) {
            alert('تمت الاضفاة');
        } else if (data.existing_citizens) {
            alert('موجود مسبقا ');
        } else {
            alert('خطا');
        }
        hideModal();
    })
    .catch(error => {

        hideModal();
    });
}

function removeCitizenFromDistribution(id) {
    fetch(`/distributions/pivot/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Citizen removed successfully!');
            // Optionally, you can update the UI to reflect the deletion
        } else {
            alert('An error occurred while removing the citizen.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
    });
}

document.querySelector('#childrenTable').addEventListener('click', function(event) {
    if (event.target.classList.contains('edit-button')) {
        let childId = event.target.dataset.id;
        let row = event.target.closest('tr');
        let name = row.querySelector('td:nth-child(1)').textContent;
        let dateOfBirth = row.querySelector('td:nth-child(2)').textContent;
        let gender = row.querySelector('td:nth-child(3)').textContent;

        document.querySelector('#addChildForm [name="name"]').value = name;
        document.querySelector('#addChildForm [name="date_of_birth"]').value = dateOfBirth;
        document.querySelector('#addChildForm [name="gender"]').value = gender === 'Male' ? 'male' : 'female';
        document.getElementById('addChildForm').dataset.editingId = childId;
        document.querySelector('#addChildForm button[type="submit"]').textContent = 'Update Child';
    }

    if (event.target.classList.contains('delete-button')) {
        let childId = event.target.dataset.id;
        fetch(`/children/${childId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                event.target.closest('tr').remove();
            } else {
                alert('An error occurred while deleting the child.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    }
});

function showValidationModal() {
    document.getElementById('validationModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function hideValidationModal() {
    document.getElementById('validationModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('validationModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideValidationModal();
    }
});

// Close modal with escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideValidationModal();
    }
});

</script>
<script src="{{ asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
    // Initialize Select2
    $('#prepositives').select2({
        placeholder: "Select Prepositives",
        allowClear: true
    });

    // Handle Apply button click
    $('#applyFilters').on('click', function() {
        let filters = {
            prepositives: $('#prepositives').val(),
            living_status: $('#living_status').val(),
            social_status: $('#social_status').val(),
            gender: $('#gender').val()
        };

        // Make an AJAX request to apply the filters (adjust the URL and method as needed)
        $.ajax({
            url: '/path/to/filter/endpoint', // Replace with your endpoint
            method: 'GET', // or 'POST' if needed
            data: filters,
            success: function(response) {
                // Handle the response to update the citizens list
                console.log(response);
                // Update the citizens list on the page using the response data
            },
            error: function(xhr) {
                console.error('Error applying filters:', xhr);
            }
        });
    });
});
    $(document).ready(function() {
        // Set CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.update-button').click(function() {
            var pivotId = $(this).data('id');
            var selectedDate = $(this).closest('tr').find('input[name="date"]').val();
            var quantity = $(this).closest('tr').find('input[name="quantity"]').val();
            var recipient = $(this).closest('tr').find('input[name="recipient"]').val();
            var note = $(this).closest('tr').find('input[name="note"]').val();

            var isChecked = $(this).closest('tr').find('input[name="done"]').prop('checked');
            var data = isChecked ? 1 : 0;
            console.log('click')
            $.ajax({
                url: '/update-pivot',
                method: 'POST',
                data: {
                    pivotId: pivotId,
                    isChecked: data,
                    selectedDate: selectedDate,
                    quantity: quantity,
                    recipient:recipient,
                    note:note,
                },
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    alert('تم تحديث');
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText);
                    alert('Failed to update pivot');
                }
            });
        });
    });
</script>
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
@endsection