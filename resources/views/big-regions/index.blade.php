@extends('dashboard')
@section('title', 'المناطق الكبيرة')

@section('content')
<div class="container mx-auto py-6">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">المناطق الكبيرة</h1>
            <a href="{{ route('big-regions.create') }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                إضافة منطقة كبيرة
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($bigRegions as $bigRegion)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                {{-- Header --}}
                <div class="p-6 border-b">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-xl font-bold">{{ $bigRegion->name }}</h2>
                            @if($bigRegion->representative)
                                <div class="mt-2 flex items-center text-gray-600">
                                    <i class="fas fa-user-tie mr-2"></i>
                                    <span>{{ $bigRegion->representative->name }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex space-x-2 rtl:space-x-reverse">
                            <a href="{{ route('big-regions.show', $bigRegion) }}" 
                               class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('big-regions.edit', $bigRegion) }}" 
                               class="text-gray-600 hover:text-gray-900">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Statistics Grid --}}
                <div class="grid grid-cols-3 divide-x rtl:divide-x-reverse">
                    <div class="p-4 text-center">
                        <div class="text-2xl font-bold text-blue-600">
                            {{ $bigRegion->regions->count() }}
                        </div>
                        <div class="text-sm text-gray-600">المناطق</div>
                    </div>
                    <div class="p-4 text-center">
                        <div class="text-2xl font-bold text-green-600">
                            {{ $bigRegion->regions->sum(function($region) {
                                return $region->citizens->count();
                            }) }}
                        </div>
                        <div class="text-sm text-gray-600">المواطنين</div>
                    </div>
                    <div class="p-4 text-center">
                        <div class="text-2xl font-bold text-purple-600">
                            {{ $bigRegion->regions->sum(function($region) {
                                return $region->representatives->count();
                            }) }}
                        </div>
                        <div class="text-sm text-gray-600">المندوبين</div>
                    </div>
                </div>

                {{-- Progress Bar --}}
                @php
                    $totalRegions = $bigRegion->regions->count();
                    $regionsWithReps = $bigRegion->regions->filter(function($region) {
                        return $region->representatives->count() > 0;
                    })->count();
                    $percentage = $totalRegions > 0 ? ($regionsWithReps / $totalRegions) * 100 : 0;
                @endphp
                <div class="px-6 py-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>تغطية المندوبين</span>
                        <span>{{ number_format($percentage, 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" 
                             style="width: {{ $percentage }}%">
                        </div>
                    </div>
                </div>

                {{-- Recent Regions --}}
                @if($bigRegion->regions->count() > 0)
                    <div class="px-6 py-4 bg-gray-50">
                        <div class="text-sm font-medium text-gray-600 mb-2">
                            آخر المناطق ({{ min(3, $bigRegion->regions->count()) }})
                        </div>
                        <div class="space-y-2">
                            @foreach($bigRegion->regions->take(3) as $region)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm">{{ $region->name }}</span>
                                    <span class="text-xs text-gray-500">
                                        {{ $region->citizens->count() }} مواطن
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12 bg-white rounded-lg shadow">
                    <i class="fas fa-folder-open text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900">لا توجد مناطق كبيرة</h3>
                    <p class="mt-2 text-gray-500">قم بإضافة منطقة كبيرة جديدة للبدء</p>
                    <div class="mt-6">
                        <a href="{{ route('big-regions.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent 
                                  rounded-md shadow-sm text-sm font-medium text-white 
                                  bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-plus mr-2"></i>
                            إضافة منطقة كبيرة
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
