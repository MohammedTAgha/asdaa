@extends('dashboard')
@section('title', 'المناطق الكبيرة')

@section('content')
<div class="container mx-auto py-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">المناطق الكبيرة</h1>
        <div class="flex gap-2">
            <a href="{{ route('big-regions.create') }}" 
               class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 flex items-center">
                <i class="fas fa-plus ml-2"></i>
                إضافة منطقة كبيرة
            </a>
            @if($bigRegions->isNotEmpty())
            <a href="{{ route('big-regions.export-citizens', $bigRegions->first()->id) }}" 
               class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 flex items-center">
                <i class="fas fa-file-export ml-2"></i>
                تصدير المواطنين
            </a>
            @endif
        </div>
    </div>

    {{-- Search and Filter --}}
    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <form action="{{ route('big-regions.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="البحث في المناطق الكبيرة..."
                       class="w-full px-4 py-2 border rounded-md">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" 
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 flex items-center">
                    <i class="fas fa-filter ml-2"></i>
                    تطبيق الفلتر
                </button>
            </div>
        </form>
    </div>

    {{-- Big Regions Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($bigRegions as $bigRegion)
            <x-big-region-card :bigRegion="$bigRegion" :detailed="false" />
        @empty
            <div class="col-span-full">
                <div class="text-center py-12 bg-white rounded-lg shadow">
                    <i class="fas fa-building text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900">لا توجد مناطق كبيرة</h3>
                    <p class="mt-2 text-gray-500">قم بإضافة منطقة كبيرة جديدة للبدء</p>
                    <div class="mt-6">
                        <a href="{{ route('big-regions.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent 
                                  rounded-md shadow-sm text-sm font-medium text-white 
                                  bg-purple-600 hover:bg-purple-700">
                            <i class="fas fa-plus ml-2"></i>
                            إضافة منطقة كبيرة
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($bigRegions->hasPages())
    <div class="mt-6">
        {{ $bigRegions->links() }}
    </div>
    @endif
</div>
@endsection
