@extends('dashboard')
@section('title', 'أفراد العائلات')

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

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4">تصفية النتائج</h2>
        <form action="{{ route('family-members.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">نوع العلاقة</label>
                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">الكل</option>
                        <option value="father" @selected(request('type') === 'father')>أب</option>
                        <option value="mother" @selected(request('type') === 'mother')>أم</option>
                        <option value="son" @selected(request('type') === 'son')>ابن</option>
                        <option value="daughter" @selected(request('type') === 'daughter')>ابنة</option>
                    </select>
                </div>

                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">الجنس</label>
                    <select name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">الكل</option>
                        <option value="male" @selected(request('gender') === 'male')>ذكر</option>
                        <option value="female" @selected(request('gender') === 'female')>أنثى</option>
                    </select>
                </div>

                <div>
                    <label for="region" class="block text-sm font-medium text-gray-700">المنطقة</label>
                    <select name="region" id="region" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">الكل</option>
                        @foreach($regions as $region)
                            <option value="{{ $region }}" @selected(request('region') === $region)>{{ $region }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="min_age" class="block text-sm font-medium text-gray-700">الحد الأدنى للعمر</label>
                    <input type="number" name="min_age" id="min_age" value="{{ request('min_age') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="max_age" class="block text-sm font-medium text-gray-700">الحد الأقصى للعمر</label>
                    <input type="number" name="max_age" id="max_age" value="{{ request('max_age') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    تصفية
                </button>
                <a href="{{ route('family-members.index') }}" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    إعادة تعيين
                </a>
                <button type="submit" name="export" value="1" class="inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    تصدير CSV
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الاسم الكامل
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            رقم الهوية
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            العمر
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الجنس
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            صلة القرابة
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            المنطقة
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الإجراءات
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($members as $member)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $member->firstname }} {{ $member->secondname }} {{ $member->lastname }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $member->national_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $member->date_of_birth->age }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $member->gender === 'male' ? 'ذكر' : 'أنثى' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @switch($member->relationship)
                                    @case('father')
                                        أب
                                        @break
                                    @case('mother')
                                        أم
                                        @break
                                    @case('son')
                                        ابن
                                        @break
                                    @case('daughter')
                                        ابنة
                                        @break
                                    @default
                                        أخرى
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $member->citizen->region }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('citizens.show', $member->citizen) }}" class="text-indigo-600 hover:text-indigo-900">
                                    عرض التفاصيل
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                لا توجد نتائج
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $members->links() }}
        </div>
    </div>
</div>
@endsection 