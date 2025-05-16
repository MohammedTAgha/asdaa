@extends('dashboard')
@section('title', 'اضافة فرد جديد للعائلة - ' . $citizen->firstname . ' ' . $citizen->lastname)

@section('content')
    <div class="container mx-auto px-4">
        @component('components.box', ['title' => 'اضافة فرد جديد للعائلة - ' . $citizen->firstname . ' ' . $citizen->lastname])
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
@endsection 