@extends('dashboard')
@section('content')
    <div class="bg-gray-100 py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">اضافة مواطن جديد</h2>
            <form action="{{ route('citizens.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="id" class="block font-medium text-gray-700">الهوية</label>
                    <input type="text" id="id" name="id"
                        class="w-full border-gray-300 w-full px-4 py-2 border rounded-md"
                        required>
                </div>
                <div class="mb-4">
                    <label for="firstname" class="block text-gray-700">الاسم الاول:</label>
                    <input type="text" name="firstname" id="firstname" class="w-full px-4 py-2 border rounded-md" required>
                </div>
    
                <div class="mb-4">
                    <label for="secondname" class="block text-gray-700">الاب:</label>
                    <input type="text" name="secondname" id="secondname" 
                        class="w-full px-4 py-2 border rounded-md">
                </div>
    
                <div class="mb-4">
                    <label for="thirdname" class="block text-gray-700">الجد:</label>
                    <input type="text" name="thirdname" id="thirdname" 
                        class="w-full px-4 py-2 border rounded-md">
                </div>
    
                <div class="mb-4">
                    <label for="lastname" class="block text-gray-700">العائلة:</label>
                    <input type="text" name="lastname" id="lastname" 
                        class="w-full px-4 py-2 border rounded-md" required>
                </div>
                <div>
                    <label for="date_of_birth" class="block font-medium text-gray-700">تاريخ الميلاد</label>
                    <input type="date" id="date_of_birth" name="date_of_birth"
                        class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                </div>
                <div>
                    <label for="gender" class="block font-medium text-gray-700">الجنس</label>
                    <select id="gender" name="gender"
                        class="w-full border-gray-300 w-full px-4 py-2 border rounded-md"
                        required>
                        <option value="">Select Gender</option>
                        <option value="0">Male</option>
                        <option value="1">Female</option>
                    </select>
                </div>
                <div>
                    <label for="wife_name" class="block font-medium text-gray-700">اسم الزوجة</label>
                    <input type="text" id="wife_name" name="wife_name"
                        class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                </div>
                <div>
                    <label for="wife_id" class="block font-medium text-gray-700">هوية الزوجة</label>
                    <input type="text" id="wife_id" name="wife_id"
                        class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                </div>
                <div>
                    <label for="widowed" class="block font-medium text-gray-700">ارمل</label>
                    <select id="widowed" name="widowed"
                        class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                        <option value="0">اختر الحالة</option>
                        <option value="1">الزوج ارمل</option>
                        <option value="2">الزوجة ارملة</option>
                    </select>
                </div>
                <div>
                    <label for="social_status" class="block font-medium text-gray-700">الحالة الاجتماعية</label>
                    <input type="text" id="social_status" name="social_status"
                        class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                </div>
                <div>
                    <label for="living_status" class="block font-medium text-gray-700">الحالة المعيشية</label>
                    <input type="text" id="living_status" name="living_status"
                        class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                </div>
                <div>
                    <label for="job" class="block font-medium text-gray-700">المهنة</label>
                    <input type="text" id="job" name="job"
                        class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                </div>
                <div>
                    <label for="original_address" class="block font-medium text-gray-700">العننوان الاصلي</label>
                    <input type="text" id="original_address" name="original_address"
                        class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                </div>
                <div>
                    <label for="elderly_count" class="block font-medium text-gray-700">عدد المسنين</label>
                    <input type="text" id="elderly_count" name="elderly_count"
                        class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                </div>
                <div>
                    <label for="region_id" class="block font-medium text-gray-700">المنطقة</label>
                    <select id="region_id" name="region_id"
                        class="w-full border-gray-300 w-full px-4 py-2 border rounded-md"
                        required>
                        <option value="">اختر المنطقة</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="note" class="block font-medium text-gray-700">ملاحظة</label>
                    <textarea id="note" name="note" rows="3"
                        class="w-full border-gray-300 w-full px-4 py-2 border rounded-md"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        اضافة
                    </button>

                </div>
            </form>
        </div>
    </div>
@endsection
