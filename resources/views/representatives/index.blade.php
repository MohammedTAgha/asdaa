@extends('dashboard')
@section('title', 'المندوبين')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">المندوبين</h1>
        <a href="{{ route('representatives.create') }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            إضافة مندوب
        </a>
    </div>

    {{-- Search and Filter Section --}}
    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <form action="{{ route('representatives.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">بحث</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="البحث في المندوبين..."
                       class="w-full px-4 py-2 border rounded-md">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">نوع المندوب</label>
                <select name="type" class="w-full px-4 py-2 border rounded-md">
                    <option value="">الكل</option>
                    <option value="region" {{ request('type') == 'region' ? 'selected' : '' }}>
                        مندوب منطقة
                    </option>
                    <option value="big_region" {{ request('type') == 'big_region' ? 'selected' : '' }}>
                        مندوب منطقة كبيرة
                    </option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">المنطقة</label>
                <select name="region_id" class="w-full px-4 py-2 border rounded-md">
                    <option value="">الكل</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" 
                            {{ request('region_id') == $region->id ? 'selected' : '' }}>
                            {{ $region->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">المنطقة الكبيرة</label>
                <select name="big_region_id" class="w-full px-4 py-2 border rounded-md">
                    <option value="">الكل</option>
                    @foreach($bigRegions as $bigRegion)
                        <option value="{{ $bigRegion->id }}" 
                            {{ request('big_region_id') == $bigRegion->id ? 'selected' : '' }}>
                            {{ $bigRegion->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ترتيب حسب</label>
                <select name="sort" class="w-full px-4 py-2 border rounded-md">
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>الاسم</option>
                    <option value="id" {{ request('sort') == 'id' ? 'selected' : '' }}>الرقم التعريفي</option>
                    <option value="region" {{ request('sort') == 'region' ? 'selected' : '' }}>المنطقة</option>
                    <option value="big_region" {{ request('sort') == 'big_region' ? 'selected' : '' }}>المنطقة الكبيرة</option>
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>تاريخ الإنشاء</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">اتجاه الترتيب</label>
                <select name="direction" class="w-full px-4 py-2 border rounded-md">
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>تصاعدي</option>
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>تنازلي</option>
                </select>
            </div>
            <div class="md:col-span-3 lg:col-span-5 flex justify-end">
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    تطبيق
                </button>
            </div>
        </form>
    </div>

    {{-- Representatives List --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        الرقم التعريفي
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        الاسم
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        النوع
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        المنطقة
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        رقم الهاتف
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        الإجراءات
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($representatives as $representative)
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            {{ $representative->id }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $representative->name }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500">
                            @if($representative->is_big_region_representative)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    مندوب منطقة كبيرة
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    مندوب منطقة
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500">
                            @if($representative->is_big_region_representative)
                                @if($representative->managedBigRegion)
                                    {{ $representative->managedBigRegion->name }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            @else
                                @if($representative->region)
                                    {{ $representative->region->name }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500">
                            {{ $representative->phone ?? '-' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right text-sm font-medium">
                        <a href="{{ route('representatives.edit', $representative) }}" 
                           class="text-blue-600 hover:text-blue-900 ml-3">تعديل</a>
                        <a href="{{ route('representatives.show', $representative) }}" 
                           class="text-green-600 hover:text-green-900 ml-3">عرض</a>
                        <form action="{{ route('representatives.destroy', $representative) }}" 
                              method="POST" 
                              class="inline-block"
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا المندوب؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">حذف</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        لا يوجد مندوبين
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $representatives->links() }}
    </div>
</div>
@endsection
