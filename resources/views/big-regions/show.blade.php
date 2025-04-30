@extends('dashboard')
@section('title', 'عرض المنطقة الكبيرة - ' . $bigRegion->name)

@section('content')
<div class="container mx-auto py-6">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <a href="{{ route('big-regions.index') }}" 
                   class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-right rtl:rotate-180"></i>
                    رجوع
                </a>
                <h1 class="text-3xl font-bold">{{ $bigRegion->name }}</h1>
            </div>
            <div class="flex space-x-2 rtl:space-x-reverse">
                <a href="{{ route('big-regions.edit', $bigRegion) }}" 
                   class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    تعديل
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Information Column --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Representative Card --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold mb-4">معلومات المندوب</h2>
                @if($bigRegion->representative)
                    <div class="flex items-start space-x-4 rtl:space-x-reverse">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-2xl text-blue-600"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold">{{ $bigRegion->representative->name }}</h3>
                            <div class="mt-2 space-y-1">
                                <p class="text-gray-600">
                                    <i class="fas fa-id-card mr-2"></i>
                                    {{ $bigRegion->representative->id }}
                                </p>
                                @if($bigRegion->representative->phone)
                                    <p class="text-gray-600">
                                        <i class="fas fa-phone mr-2"></i>
                                        {{ $bigRegion->representative->phone }}
                                    </p>
                                @endif
                                @if($bigRegion->representative->address)
                                    <p class="text-gray-600">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        {{ $bigRegion->representative->address }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-gray-500 text-center py-4">
                        لا يوجد مندوب معين لهذه المنطقة
                    </div>
                @endif
            </div>

            {{-- Regions List --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">المناطق التابعة</h2>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                        {{ $bigRegion->regions->count() }} منطقة
                    </span>
                </div>

                @if($bigRegion->regions->count() > 0)
                    <div class="space-y-4">
                        @foreach($bigRegion->regions as $region)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold">{{ $region->name }}</h3>
                                        <div class="mt-2 grid grid-cols-2 gap-4">
                                            <div class="text-sm text-gray-600">
                                                <span class="font-medium">المواطنين:</span>
                                                {{ $region->citizens->count() }}
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                <span class="font-medium">المندوبين:</span>
                                                {{ $region->representatives->count() }}
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('regions.show', $region) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                                @if($region->representatives->count() > 0)
                                    <div class="mt-3 pt-3 border-t">
                                        <div class="text-sm text-gray-500 mb-2">المندوبين:</div>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($region->representatives as $representative)
                                                <span class="inline-flex items-center px-2 py-1 bg-gray-100 rounded-full text-xs">
                                                    {{ $representative->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-gray-500 text-center py-4">
                        لا توجد مناطق تابعة
                    </div>
                @endif
            </div>
        </div>

        {{-- Statistics Column --}}
        <div class="space-y-6">
            {{-- Summary Statistics --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold mb-4">إحصائيات عامة</h2>
                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <div class="text-sm font-medium text-blue-800">إجمالي المواطنين</div>
                        <div class="mt-1 text-2xl font-bold text-blue-900">
                            {{ $bigRegion->regions->sum(function($region) {
                                return $region->citizens->count();
                            }) }}
                        </div>
                    </div>
                    
                    <div class="p-4 bg-green-50 rounded-lg">
                        <div class="text-sm font-medium text-green-800">عدد المناطق</div>
                        <div class="mt-1 text-2xl font-bold text-green-900">
                            {{ $bigRegion->regions->count() }}
                        </div>
                    </div>

                    <div class="p-4 bg-purple-50 rounded-lg">
                        <div class="text-sm font-medium text-purple-800">إجمالي المندوبين</div>
                        <div class="mt-1 text-2xl font-bold text-purple-900">
                            {{ $bigRegion->regions->sum(function($region) {
                                return $region->representatives->count();
                            }) }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Coverage Progress --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold mb-4">تغطية المندوبين</h2>
                @php
                    $totalRegions = $bigRegion->regions->count();
                    $regionsWithReps = $bigRegion->regions->filter(function($region) {
                        return $region->representatives->count() > 0;
                    })->count();
                    $percentage = $totalRegions > 0 ? ($regionsWithReps / $totalRegions) * 100 : 0;
                @endphp
                <div class="space-y-2">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>نسبة التغطية</span>
                        <span>{{ number_format($percentage, 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                    <p class="text-sm text-gray-500">
                        {{ $regionsWithReps }} من {{ $totalRegions }} مناطق لديها مندوبين
                    </p>
                </div>
            </div>

            {{-- Notes --}}
            @if($bigRegion->note)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-4">ملاحظات</h2>
                    <p class="text-gray-600">{{ $bigRegion->note }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .rtl\:rotate-180 {
        transform: rotate(180deg);
    }
</style>
@endpush

