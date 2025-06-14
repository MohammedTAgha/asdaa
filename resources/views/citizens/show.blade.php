@extends('dashboard')
@php
    $title = 'المستفيد'. " " .$citizen->firstname . " " .  $citizen->secondname .  ' ' .$citizen->lastname 
@endphp
@section('title', $title)

@section('content')
    <div class="container mx-auto px-1">
   
        <!-- Modal -->
       {{-- @dump( $validationResults) --}}
        <div id="addCitizenModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
            <div class="bg-white p-6 rounded-md shadow-md w-1/3">
                <h2 class="text-lg font-semibold mb-4">اختر الكشف</h2>
              
                    <input type="hidden" name="citizens" id="citizen-ids">

                    <select id="distributionSelect" class="form-select mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <!-- Options will be populated dynamically -->
                    </select>   
                       
                    <div class="flex justify-end mt-4">
                    <!-- <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="addCitizenToDistribution()">
                            تأكيد
                        </button>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" onclick="hideModal()">
                            إلغاء
                        </button> -->
                        <button type="button" class="px-4 py-2 bg-gray-600 text-white rounded-md mr-2" id="close-modal" onclick="hideModal()">Cancel</button>
                        <button  type="button" class="px-4 py-2 bg-green-600 text-white rounded-md" onclick="addCitizenToDistribution()">Confirm</button>
                    </div>
                
            </div>
        </div>
        
        <div id="childModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full md:w-1/2">
                    <h2 class="text-2xl font-bold mb-4">{{ $citizen->name }}اضافة  طفل جديد ل </h2>
                    <form id="addChildForm">
                        @csrf
                        <input type="hidden" name="citizen_id" value="{{ $citizen->id }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">الاسم:</label>
                                <input type="text" name="name" id="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">تاريخ الميلاد:</label>
                                <input type="date" name="date_of_birth" id="date_of_birth"  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700">الجنس:</label>
                                <select name="gender" id="gender" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="0">Male</option>
                                    <option value="1">Female</option>
                                </select>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="orphan" id="orphan" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <label for="orphan" class="ml-2 block text-sm text-gray-900">يتيم</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="infant" id="infant" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <label for="infant" class="ml-2 block text-sm text-gray-900">رضيع</label>
                            </div>
                            <div>
                                <label for="bambers_size" class="block text-sm font-medium text-gray-700">حجم الحفاظات:</label>
                                <input type="text" name="bambers_size" id="bambers_size" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="disease" id="disease" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <label for="disease" class="ml-2 block text-sm text-gray-900">المرض</label>
                            </div>
                            <div>
                                <label for="disease_description" class="block text-sm font-medium text-gray-700">وصف المرض :</label>
                                <input type="text" name="disease_description" id="disease_description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="obstruction" id="obstruction" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <label for="obstruction" class="ml-2 block text-sm text-gray-900">يوجد اعاقة</label>
                            </div>
                            <div>
                                <label for="obstruction_description" class="block text-sm font-medium text-gray-700">وصف الاعاقة:</label>
                                <input type="text" name="obstruction_description" id="obstruction_description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label for="note" class="block text-sm font-medium text-gray-700">ملاحظات:</label>
                                <textarea name="note" id="note" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">اضافة طفل</button>
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-md" onclick="hideChildModal()">الغاء</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Validation Status Modal -->
        <div id="validationModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 md:w-3/4 lg:w-1/2 max-h-[80vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded-full mr-2 {{ $validationResults['is_valid'] ? 'bg-green-500' : 'bg-red-500' }}"></div>
                        <h2 class="text-xl font-bold">{{ $validationResults['is_valid'] ? 'حالة البيانات صحيحة' : 'يوجد أخطاء في البيانات' }}</h2>
                    </div>
                    <button onclick="hideValidationModal()" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                @if(!$validationResults['is_valid'])
                    <div class="space-y-4">
                        @foreach($validationResults['details'] as $detail)
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 hover:bg-red-100 transition-colors">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <h3 class="text-sm font-medium text-red-800">{{ $detail['message'] }}</h3>
                                        @if(isset($detail['id']))
                                            <p class="mt-1 text-sm text-red-700">
                                                <span class="font-semibold">رقم الهوية:</span> {{ $detail['id'] }}
                                            </p>
                                        @endif
                                        @if(isset($detail['expected']) && isset($detail['actual']))
                                            <p class="mt-1 text-sm text-red-700">
                                                <span class="font-semibold">العدد المتوقع:</span> {{ $detail['expected'] }} | 
                                                <span class="font-semibold">العدد الفعلي:</span> {{ $detail['actual'] }}
                                            </p>
                                        @endif
                                        @if(isset($detail['details']))
                                            <p class="mt-1 text-sm text-red-700">
                                                {{ $detail['details']['message'] ?? '' }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-check-circle text-green-500 text-5xl mb-4"></i>
                        <p class="text-lg text-gray-700">جميع البيانات صحيحة ومتوافقة</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Main Content -->
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
    {{-- <div class="bg-white p-4 rounded-lg shadow mt-4">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-lg font-semibold mb-2">{{ __('مقدم الرعاية') }}</h3>
                @if($citizen->careProvider)
                    <div class="mb-2">
                        <p class="text-gray-800">{{ $citizen->careProvider->firstname }} {{ $citizen->careProvider->secondname }} {{ $citizen->careProvider->lastname }}</p>
                        <p class="text-sm text-gray-600">{{ __($citizen->careProvider->relationship) }}</p>
                        <p class="text-sm text-gray-600">{{ __('رقم الهوية: ') }}{{ $citizen->careProvider->national_id }}</p>
                    </div>
                @else
                    <p class="text-gray-600">{{ __('لم يتم تعيين مقدم رعاية بعد') }}</p>
                @endif
            </div>
            <a href="{{ route('citizens.care-provider', $citizen) }}" class="btn-primary">
                {{ __('تعديل مقدم الرعاية') }}
            </a>
        </div>
    </div>  --}}
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
            <div class="flex space-x-2">
                <button onclick="showCategoryModal()" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                    <i class="fas fa-tags ml-1"></i>
                    إضافة فئة
                </button>
                <a href="{{ route('citizens.family-members.create', $citizen) }}" class="px-4 py-2 bg-green-600 text-white rounded-md">اضافة فرد جديد</a>
            </div>
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
                                    {{-- <a href="{{ route('citizens.family-members.edit', [$citizen, $parent]) }}" class="text-blue-600 hover:text-blue-800"> --}}
                                        <a href="{{ route('family-members.show', $parent) }}" class="text-blue-600">
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
                                        {{-- <a href="{{ route('citizens.family-members.edit', [$citizen, $child]) }}" class="text-blue-600 hover:text-blue-800 ml-2"> --}}
                                            <a href="{{ route('family-members.show', $parent) }}" class="text-blue-600">
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


    @component('components.box',['title'=>'فئات العائلة','styles'=>'mt-2'])
        @slot('side')
            <button onclick="showCategoryModal()" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                <i class="fas fa-tags ml-1"></i>
                إضافة فئة
            </button>
        @endslot

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-right">اسم العضو</th>
                        <th class="py-2 px-4 text-right">رقم الهوية</th>
                        <th class="py-2 px-4 text-right">الفئة</th>
                        <th class="py-2 px-4 text-right">الحجم</th>
                        <th class="py-2 px-4 text-right">المبلغ</th>
                        <th class="py-2 px-4 text-right">الوصف</th>
                        <th class="py-2 px-4 text-right">التاريخ</th>
                        <th class="py-2 px-4 text-right">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citizen->familyMembers as $member)
                        @foreach($member->categories as $category)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4">{{ $member->full_name }}</td>
                                <td class="py-2 px-4">{{ $member->national_id }}</td>
                                <td class="py-2 px-4">{{ $category->name }}</td>
                                <td class="py-2 px-4">{{ $category->pivot->size }}</td>
                                <td class="py-2 px-4">{{ $category->pivot->amount }}</td>
                                <td class="py-2 px-4">{{ $category->pivot->description }}</td>
                                <td class="py-2 px-4">{{ $category->pivot->date }}</td>
                                <td class="py-2 px-4">
                                    <button onclick="editCategoryMember({{ $member->id }}, {{ $category->id }})" class="text-blue-600 hover:text-blue-800 ml-2">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="removeCategoryMember({{ $member->id }}, {{ $category->id }})" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
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

<!-- Add Category Modal -->
<div id="categoryModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 md:w-3/4 lg:w-1/2 max-h-[80vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 class="text-xl font-bold">إضافة فئة لعضو العائلة</h2>
            <button onclick="hideCategoryModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="addCategoryForm" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">اختر العضو</label>
                <select id="familyMemberSelect" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">اختر العضو</option>
                    @foreach($citizen->familyMembers as $member)
                        <option value="{{ $member->national_id }}" data-name="{{ $member->firstname }} {{ $member->secondname }} {{ $member->thirdname }} {{ $member->lastname }}">
                            {{ $member->firstname }} {{ $member->secondname }} {{ $member->thirdname }} {{ $member->lastname }} ({{ $member->national_id }}) =>{{ $member->relationship ??"غير محدد العلاقة"  }} ,{{ $member->age }},{{ $member->gender }} 
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">اختر الفئة</label>
                <select id="categorySelect" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">اختر الفئة</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الحجم</label>
                    <input type="text" name="size" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">المبلغ</label>
                    <input type="number" step="0.01" name="amount" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">الوصف</label>
                <textarea name="description" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">خاصية 1</label>
                    <input type="text" name="property1" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">خاصية 2</label>
                    <input type="text" name="property2" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">خاصية 3</label>
                    <input type="text" name="property3" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">خاصية 4</label>
                    <input type="text" name="property4" class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" onclick="hideCategoryModal()" class="px-4 py-2 bg-gray-600 text-white rounded-md">
                    إلغاء
                </button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md">
                    إضافة
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showCategoryModal() {
    document.getElementById('categoryModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function hideCategoryModal() {
    document.getElementById('categoryModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    formData.append('member_id', document.getElementById('familyMemberSelect').value);
    formData.append('category_id', document.getElementById('categorySelect').value);

    fetch('{{ route("categories.addMember") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('تم إضافة الفئة بنجاح');
            hideCategoryModal();
            location.reload(); // Refresh to show new category
        } else {
            alert(data.message || 'حدث خطأ أثناء إضافة الفئة');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء إضافة الفئة');
    });
});
</script>
@endsection