@extends('dashboard')
@section('title', 'تعديل فرد العائلة - ' . $member->firstname . ' ' . $member->lastname)

@section('content')
    <div class="container mx-auto px-4">
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @component('components.box', ['title' => 'تعديل بيانات فرد العائلة'])
            <form action="{{ route('citizens.family-members.update', [$citizen, $member]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="firstname" class="block text-sm font-medium text-gray-700">الاسم الأول</label>
                        <input type="text" name="firstname" id="firstname" value="{{ old('firstname', $member->firstname) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label for="secondname" class="block text-sm font-medium text-gray-700">الاسم الثاني</label>
                        <input type="text" name="secondname" id="secondname" value="{{ old('secondname', $member->secondname) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label for="thirdname" class="block text-sm font-medium text-gray-700">الاسم الثالث</label>
                        <input type="text" name="thirdname" id="thirdname" value="{{ old('thirdname', $member->thirdname) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="lastname" class="block text-sm font-medium text-gray-700">اسم العائلة</label>
                        <input type="text" name="lastname" id="lastname" value="{{ old('lastname', $member->lastname) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label for="national_id" class="block text-sm font-medium text-gray-700">رقم الهوية</label>
                        <input type="text" name="national_id" id="national_id" value="{{ old('national_id', $member->national_id) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">تاريخ الميلاد</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $member->date_of_birth ? $member->date_of_birth->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">الجنس</label>
                        <select name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>ذكر</option>
                            <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>أنثى</option>
                        </select>
                    </div>

                    <div>
                        <label for="relationship" class="block text-sm font-medium text-gray-700">صلة القرابة</label>
                        <select name="relationship" id="relationship" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="father" {{ old('relationship', $member->relationship) == 'father' ? 'selected' : '' }}>أب</option>
                            <option value="mother" {{ old('relationship', $member->relationship) == 'mother' ? 'selected' : '' }}>أم</option>
                            <option value="son" {{ old('relationship', $member->relationship) == 'son' ? 'selected' : '' }}>ابن</option>
                            <option value="daughter" {{ old('relationship', $member->relationship) == 'daughter' ? 'selected' : '' }}>ابنة</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700">ملاحظات</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $member->notes) }}</textarea>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-4">الفئات</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($categories as $category)
                            @php
                                $attachedCategory = $member->categories->find($category->id);
                                $isChecked = $attachedCategory ? true : false;
                                $pivotData = $isChecked ? $attachedCategory->pivot : null;
                            @endphp
                            <div class="bg-gray-100 p-4 rounded-md">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="categories[{{ $category->id }}][selected]" value="1" class="form-checkbox" {{ $isChecked ? 'checked' : '' }}>
                                    <span class="ml-2">{{ $category->name }}</span>
                                </label>
                                <div class="mt-2 space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">الحجم:</label>
                                    <input type="text" name="categories[{{ $category->id }}][size]" value="{{ old('categories.' . $category->id . '.size', $pivotData ? $pivotData->size : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">

                                    <label class="block text-sm font-medium text-gray-700">التاريخ:</label>
                                    <input type="date" name="categories[{{ $category->id }}][date]" value="{{ old('categories.' . $category->id . '.date', $pivotData ? ($pivotData->date ? \Carbon\Carbon::parse($pivotData->date)->format('Y-m-d') : '') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">

                                    <label class="block text-sm font-medium text-gray-700">خاصية 1:</label>
                                    <input type="text" name="categories[{{ $category->id }}][property1]" value="{{ old('categories.' . $category->id . '.property1', $pivotData ? $pivotData->property1 : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">

                                    <label class="block text-sm font-medium text-gray-700">خاصية 2:</label>
                                    <input type="text" name="categories[{{ $category->id }}][property2]" value="{{ old('categories.' . $category->id . '.property2', $pivotData ? $pivotData->property2 : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">

                                    <label class="block text-sm font-medium text-gray-700">خاصية 3:</label>
                                    <input type="text" name="categories[{{ $category->id }}][property3]" value="{{ old('categories.' . $category->id . '.property3', $pivotData ? $pivotData->property3 : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">

                                    <label class="block text-sm font-medium text-gray-700">اللون:</label>
                                    <input type="text" name="categories[{{ $category->id }}][color]" value="{{ old('categories.' . $category->id . '.color', $pivotData ? $pivotData->color : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">

                                    <label class="block text-sm font-medium text-gray-700">الكمية:</label>
                                    <input type="number" name="categories[{{ $category->id }}][amount]" value="{{ old('categories.' . $category->id . '.amount', $pivotData ? $pivotData->amount : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        تحديث
                    </button>
                    <a href="{{ route('citizens.show', $citizen) }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        إلغاء
                    </a>
                </div>
            </form>
        @endcomponent
    </div>
@endsection
