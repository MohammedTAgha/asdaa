@extends('dashboard')
@section('title', 'المناطق')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">المناطق</h1>
        <a href="{{ route('regions.create') }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            إضافة منطقة
        </a>
    </div>

    {{-- Search and Filter Section --}}
    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <form action="{{ route('regions.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">بحث</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="البحث في المناطق..."
                       class="w-full px-4 py-2 border rounded-md">
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
                    <option value="position" {{ request('sort') == 'position' ? 'selected' : '' }}>الموقع</option>
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
            <div class="md:col-span-4 flex justify-end">
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    تطبيق
                </button>
            </div>
        </form>
    </div>

    {{-- Regions List --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        الاسم
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        الموقع
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        المنطقة الكبيرة
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        عدد المندوبين
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        الإجراءات
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($regions as $region)
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $region->name }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500">
                            {{ $region->position }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500">
                            @if($region->bigRegion)
                                {{ $region->bigRegion->name }}
                                @if($region->bigRegion->representative)
                                    <span class="text-xs text-gray-400">
                                        ({{ $region->bigRegion->representative->name }})
                                    </span>
                                @endif
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500">
                            {{ $region->representatives->where('is_big_region_representative', false)->count() }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right text-sm font-medium">
                        <a href="{{ route('regions.edit', $region) }}" 
                           class="text-blue-600 hover:text-blue-900 ml-3">تعديل</a>
                        <a href="{{ route('regions.show', $region) }}" 
                           class="text-green-600 hover:text-green-900 ml-3">عرض</a>
                        @if($region->citizens->count() === 0)
                            <form action="{{ route('regions.destroy', $region) }}" 
                                  method="POST" 
                                  class="inline-block"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذه المنطقة؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">حذف</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        لا توجد مناطق
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $regions->links() }}
    </div>
</div>
@endsection
