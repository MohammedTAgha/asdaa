@extends('dashboard')

@section('title', 'إدارة أفراد العائلات')

@section('content')
<div class="container mx-auto px-4 py-6">
    @component('components.box', ['title' => 'فلترة أفراد العائلات'])
        <form action="{{ route('family-members.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">صلة القرابة</label>
                    <select name="relationship" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">الكل</option>
                        <option value="father" {{ request('relationship') === 'father' ? 'selected' : '' }}>الأب</option>
                        <option value="mother" {{ request('relationship') === 'mother' ? 'selected' : '' }}>الأم</option>
                        <option value="son" {{ request('relationship') === 'son' ? 'selected' : '' }}>ابن</option>
                        <option value="daughter" {{ request('relationship') === 'daughter' ? 'selected' : '' }}>ابنة</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">الجنس</label>
                    <select name="gender" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">الكل</option>
                        <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>أنثى</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">العمر من</label>
                    <input type="number" name="min_age" value="{{ request('min_age') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300" min="0" max="120">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">العمر إلى</label>
                    <input type="number" name="max_age" value="{{ request('max_age') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300" min="0" max="120">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">المنطقة</label>
                    <select name="region_id" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">الكل</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ request('region_id') == $region->id ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-between mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter ml-1"></i> تطبيق الفلتر
                </button>

                <button type="submit" name="export" value="1" class="btn btn-success">
                    <i class="fas fa-file-excel ml-1"></i> تصدير النتائج
                </button>
            </div>
        </form>
    @endcomponent

    @component('components.box', ['title' => 'نتائج البحث', 'styles' => 'mt-6'])
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            رقم الهوية
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الاسم الكامل
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            صلة القرابة
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الجنس
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            العمر
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            المنطقة
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($members as $member)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $member->national_id }}</td>
                            <td class="px-6 py-4">
                                {{ $member->firstname }} {{ $member->secondname }} {{ $member->lastname }}
                            </td>
                            <td class="px-6 py-4">
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
                            <td class="px-6 py-4">
                                {{ $member->gender === 'male' ? 'ذكر' : 'أنثى' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ Carbon\Carbon::parse($member->date_of_birth)->age }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $member->citizen->region->name ?? 'غير محدد' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                لا توجد نتائج للبحث
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $members->links() }}
        </div>
    @endcomponent
</div>
@endsection
