@extends('dashboard')
@section('title', 'اضافة فرد جديد للعائلة - ' . $citizen->firstname . ' ' . $citizen->lastname)

@section('content')
    <div class="container mx-auto px-4">
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('errors') && is_array(session('errors')))
            <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">تنبيه!</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach(session('errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @component('components.box', ['title' => 'بيانات المواطن الرئيسي'])
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-700">الاسم الكامل</h4>
                    <p class="text-gray-900">{{ $citizen->firstname }} {{ $citizen->secondname }} {{ $citizen->thirdname }} {{ $citizen->lastname }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-700">رقم الهوية</h4>
                    <p class="text-gray-900">{{ $citizen->national_id }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-700">تاريخ الميلاد</h4>
                    <p class="text-gray-900">{{ $citizen->date_of_birth }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-700">الجنس</h4>
                    <p class="text-gray-900">{{ $citizen->gender == 'male' ? 'ذكر' : 'أنثى' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-700">رقم الهاتف</h4>
                    <p class="text-gray-900">{{ $citizen->phone ?? 'غير متوفر' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-700">العنوان</h4>
                    <p class="text-gray-900">{{ $citizen->address ?? 'غير متوفر' }}</p>
                </div>
            </div>
        @endcomponent

        @component('components.box', ['title' => 'البحث في السجل المدني'])
            <div class="mb-6">
                <form action="{{ route('citizens.family-members.search-records', $citizen) }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="search_id" class="block text-sm font-medium text-gray-700">البحث برقم الهوية</label>
                            <input type="text" name="search_id" id="search_id" value="{{ $citizen->id ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                                بحث في السجل المدني
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if(isset($records_relatives))
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-4">نتائج البحث في السجل المدني</h3>
                    <form action="{{ route('citizens.family-members.import-records', $citizen) }}" method="POST">
                        @csrf
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        
                                        <th class="py-2 px-4 text-right">اختيار</th>
                                        <th class="py-2 px-4 text-right">رقم الهوية</th>
                                        <th class="py-2 px-4 text-right">الاسم الكامل</th>
                                        <th class="py-2 px-4 text-right">العمر</th>
                                        <th class="py-2 px-4 text-right">الحالة الاجتماعية</th>
                                        <th class="py-2 px-4 text-right">صلة القرابة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($records_relatives as $relative)
                                        @php
                                            $isSingle = ($relative['relative']->CI_PERSONAL_CD === 'اعزب');
                                            $age = $relative['relative']->age;
                                            $isWife = false;
                                            $isFather = isset($relative['is_father']) && $relative['is_father'];
                                            $isExistingMember = in_array($relative['relative']->CI_ID_NUM, $citizen->familyMembers->pluck('national_id')->toArray());
                                            
                                            // Mark as wife if relation_type or relation_code indicates wife
                                            if (
                                                (isset($relative['relation_type']) && Str::contains($relative['relation_type'], 'زوجة')) ||
                                                (isset($relative['relation_code']) && in_array($relative['relation_code'], [4, '4']))
                                            ) {
                                                $isWife = true;
                                            }
                                            
                                            $rowStyle = '';
                                            if ($isFather) {
                                                $rowStyle = 'background-color: #dbeafe;'; // light blue
                                            } elseif ($isWife) {
                                                $rowStyle = 'background-color: #fbcfe8;'; // rose color
                                            } elseif ($isSingle && $age !== null && $age < 20) {
                                                $rowStyle = 'background-color: #d1fae5;'; // light green
                                            } elseif ($isSingle && $age !== null && $age >= 20) {
                                                $rowStyle = 'background-color: #fef9c3;'; // light yellow
                                            }
                                        @endphp
                                        <tr style="@if($rowStyle) {{ $rowStyle }} @endif @if($isExistingMember) border: 2px solid #4f46e5; position: relative; @endif">
                                            @if($isExistingMember)
                                            <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                            <i class="ti ti-check-circle text-green-500"></i>
                                            
                                            </span>
                                        @endif
                                            <td class="py-2 px-4">
                                             
                                                <input type="checkbox" name="selected_relatives[]" value="{{ $relative['relative']->CI_ID_NUM }}" 
                                                    data-relation="{{ $relative['relation_type'] }}"
                                                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                                    >
                                            </td>
                                            <td class="py-2 px-4">{{ $relative['relative']->CI_ID_NUM }}</td>
                                            <td class="py-2 px-4">
                                                {{ $relative['relative']->CI_FIRST_ARB }} 
                                                {{ $relative['relative']->CI_FATHER_ARB }} 
                                                {{ $relative['relative']->CI_GRAND_FATHER_ARB }} 
                                                {{ $relative['relative']->CI_FAMILY_ARB }}
                                                @if($isFather) <span class="text-blue-600 font-bold">(رب الاسرة)</span> @endif
                                            </td>
                                            <td class="py-2 px-4">
                                                {{ $relative['relative']->age !== null ? $relative['relative']->age : 'غير متوفر' }}
                                            </td>
                                            <td class="py-2 px-4">
                                                {{ $relative['relative']->CI_PERSONAL_CD }}
                                            </td>
                                            <td class="py-2 px-4">{{ $relative['relation_type'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700">
                                إضافة المحدد
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        @endcomponent

        @component('components.box', ['title' => 'اضافة فرد جديد للعائلة يدوياً', 'styles' => 'mt-6'])
            <form action="{{ route('citizens.family-members.store', $citizen) }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="firstname" class="block text-sm font-medium text-gray-700">الاسم الأول</label>
                        <input type="text" name="firstname" id="firstname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label for="secondname" class="block text-sm font-medium text-gray-700">الاسم الثاني</label>
                        <input type="text" name="secondname" id="secondname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label for="thirdname" class="block text-sm font-medium text-gray-700">الاسم الثالث</label>
                        <input type="text" name="thirdname" id="thirdname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="lastname" class="block text-sm font-medium text-gray-700">اسم العائلة</label>
                        <input type="text" name="lastname" id="lastname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label for="national_id" class="block text-sm font-medium text-gray-700">رقم الهوية</label>
                        <input type="text" name="national_id" id="national_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">تاريخ الميلاد</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">الجنس</label>
                        <select name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="male">ذكر</option>
                            <option value="female">أنثى</option>
                        </select>
                    </div>

                    <div>
                        <label for="relationship" class="block text-sm font-medium text-gray-700">صلة القرابة</label>
                        <select name="relationship" id="relationship" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="father">أب</option>
                            <option value="mother">أم</option>
                            <option value="son">ابن</option>
                            <option value="daughter">ابنة</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700">ملاحظات</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        حفظ
                    </button>
                    <a href="{{ route('citizens.show', $citizen) }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        إلغاء
                    </a>
                </div>
            </form>
        @endcomponent

        @if($parents->isNotEmpty() || $children->isNotEmpty())
            @component('components.box', ['title' => 'افراد العائلة الحاليين', 'styles' => 'mt-6'])
                @if($parents->isNotEmpty())
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">الوالدين</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($parents as $parent)
                                <div class="bg-white p-4 rounded-lg shadow">
                                    <h4 class="font-semibold">{{ $parent->relationship == 'father' ? 'الأب' : 'الأم' }}</h4>
                                    <p>{{ $parent->firstname }} {{ $parent->secondname }} {{ $parent->lastname }}</p>
                                    <p class="text-sm text-gray-600">رقم الهوية: {{ $parent->national_id }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($children->isNotEmpty())
                    <div>
                        <h3 class="text-lg font-semibold mb-3">الأبناء</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="py-2 px-4 text-right">الاسم</th>
                                        <th class="py-2 px-4 text-right">الجنس</th>
                                        <th class="py-2 px-4 text-right">تاريخ الميلاد</th>
                                        <th class="py-2 px-4 text-right">رقم الهوية</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($children as $child)
                                        <tr>
                                            <td class="py-2 px-4">{{ $child->firstname }} {{ $child->secondname }} {{ $child->lastname }}</td>
                                            <td class="py-2 px-4">{{ $child->gender == 'male' ? 'ذكر' : 'أنثى' }}</td>
                                            <td class="py-2 px-4">{{ $child->date_of_birth }}</td>
                                            <td class="py-2 px-4">{{ $child->national_id }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endcomponent
        @endif
    </div>

    <script>
        // Add this JavaScript to automatically map relationships
        document.addEventListener('DOMContentLoaded', function() {
            const relationshipMap = {
                'زوج': 'father',
                'زوج/ة': 'mother',
                'ابن': 'son',
                'ابنة': 'daughter',
                // Add more mappings as needed
            };

            const checkboxes = document.querySelectorAll('input[name="selected_relatives[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        const relation = this.getAttribute('data-relation');
                        const mappedRelation = relationshipMap[relation] || 'other';
                        
                        // Create a hidden input for the relationship
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = `relationships[${this.value}]`;
                        hiddenInput.value = mappedRelation;
                        this.parentNode.appendChild(hiddenInput);
                    } else {
                        // Remove the hidden input when unchecked
                        const hiddenInput = this.parentNode.querySelector(`input[name="relationships[${this.value}]"]`);
                        if (hiddenInput) {
                            hiddenInput.remove();
                        }
                    }
                });
            });
        });
    </script>
@endsection 