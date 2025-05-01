@extends('dashboard')
@section('title', 'المناطق')

@section('content')
<div class="container mx-auto py-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">المناطق</h1>
        <a href="{{ route('regions.create') }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center">
            <i class="fas fa-plus ml-2"></i>
            إضافة منطقة
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <form action="{{ route('regions.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="البحث في المناطق..."
                       class="w-full px-4 py-2 border rounded-md">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
            
            <select name="big_region_id" class="px-4 py-2 border rounded-md">
                <option value="">جميع المناطق الكبيرة</option>
                @foreach($bigRegions as $bigRegion)
                    <option value="{{ $bigRegion->id }}" {{ request('big_region_id') == $bigRegion->id ? 'selected' : '' }}>
                        {{ $bigRegion->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                <i class="fas fa-filter ml-2"></i>
                تطبيق الفلتر
            </button>
        </form>
    </div>

    {{-- Regions Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($regions as $region)
            <x-region-card :region="$region" />
        @empty
            <div class="col-span-full">
                <div class="text-center py-12 bg-white rounded-lg shadow">
                    <i class="fas fa-folder-open text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900">لا توجد مناطق</h3>
                    <p class="mt-2 text-gray-500">قم بإضافة منطقة جديدة للبدء</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $regions->links() }}
    </div>
</div>
@endsection
