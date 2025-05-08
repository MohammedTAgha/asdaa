@props([
    'bigRegion',
    'showActions' => true,
    'detailed' => false,
])

@php
    $bigRegionService = app(App\Services\BigRegionService::class);
  
    $stats = $bigRegionService->getBigRegionStatistics($bigRegion->id)->first();

@endphp

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    {{-- Header with Region Name and Actions --}}
    <div class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 border-b">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ $bigRegion->name }}</h3>
                @if($bigRegion->representative)
                <p class="text-sm text-gray-600 mt-1 flex items-center">
                    <i class="fas fa-user-tie ml-2"></i>
                    {{ $bigRegion->representative->name }}
                </p>
                @endif
            </div>
            @if($showActions)
            <div class="flex space-x-2 rtl:space-x-reverse">
                <a href="{{ route('big-regions.show', $bigRegion) }}" 
                   class="text-blue-600 hover:text-blue-800 p-1"
                   title="عرض">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('big-regions.edit', $bigRegion) }}" 
                   class="text-yellow-600 hover:text-yellow-800 p-1"
                   title="تعديل">
                    <i class="fas fa-edit"></i>
                </a>
                @if($bigRegion->regions->isEmpty())
                    <form action="{{ route('big-regions.destroy', $bigRegion) }}" 
                          method="POST" 
                          class="inline-block"
                          onsubmit="return confirm('هل أنت متأكد من حذف هذه المنطقة الكبيرة؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="text-red-600 hover:text-red-800 p-1"
                                title="حذف">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                @endif
            </div>
            @endif
        </div>
    </div>

    {{-- Quick Stats Grid --}}
    <div class="grid grid-cols-2 divide-x rtl:divide-x-reverse divide-y">
        <div class="p-4 text-center">
            <span class="text-sm text-gray-600">المناطق</span>
            <p class="text-2xl font-bold text-purple-600">{{ $stats['total_regions'] }}</p>
        </div>
        <div class="p-4 text-center">
            <span class="text-sm text-gray-600">المواطنين</span>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['total_citizens'] }}</p>
        </div>
        <div class="p-4 text-center">
            <span class="text-sm text-gray-600">المندوبين</span>
            <p class="text-2xl font-bold text-green-600">{{ $stats['total_representatives'] }}</p>
        </div>
        <div class="p-4 text-center">
            <span class="text-sm text-gray-600">المشاريع</span>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['distributions_stats']['total_distributions'] }}</p>
        </div>
    </div>

    {{-- Distribution Progress Overview --}}
    <div class="p-4 border-t bg-gray-50">
        <h4 class="text-sm font-medium text-gray-700 mb-3">تقدم التوزيع الكلي</h4>
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <i class="fas fa-check-circle ml-1"></i>
                    {{ $stats['distribution_progress']['total_distributed'] }}
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    <i class="fas fa-clock ml-1"></i>
                    {{ $stats['distribution_progress']['total_pending'] }}
                </span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    <i class="fas fa-times-circle ml-1"></i>
                    {{ $stats['distribution_progress']['total_cancelled'] }}
                </span>
            </div>
            <span class="text-sm text-gray-600">
                {{ $stats['distribution_progress']['distribution_rate'] }}%
            </span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-green-600 h-2.5 rounded-full" 
                 style="width: {{ $stats['distribution_progress']['distribution_rate'] }}%">
            </div>
        </div>
    </div>

    {{-- Distribution Details --}}
    @if($stats['distributions_stats']['total_distributions'] > 0)
    <div class="p-4 border-t">
        <h4 class="text-sm font-medium text-gray-700 mb-3">احصائيات المشاريع</h4>
        <div class="space-y-4">
            @foreach($stats['distributions_stats']['distributions'] as $dist)
            <div class="border-b pb-4 last:border-b-0 last:pb-0">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h5 class="font-medium text-gray-900">{{ $dist['name'] }}</h5>
                        <div class="flex items-center mt-1 space-x-2 rtl:space-x-reverse text-xs">
                            <span class="text-green-600">
                                <i class="fas fa-check-circle ml-1"></i>
                                {{ $dist['status_counts']['distributed'] }}
                            </span>
                            <span class="text-yellow-600">
                                <i class="fas fa-clock ml-1"></i>
                                {{ $dist['status_counts']['pending'] }}
                            </span>
                            <span class="text-red-600">
                                <i class="fas fa-times-circle ml-1"></i>
                                {{ $dist['status_counts']['cancelled'] }}
                            </span>
                        </div>
                    </div>
                    <span class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                        {{ $dist['beneficiaries_count'] }} مستفيد
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                    <div class="flex h-1.5">
                        <div class="bg-green-500 h-full" 
                             style="width: {{ ($dist['status_counts']['distributed'] / $dist['beneficiaries_count']) * 100 }}%">
                        </div>
                        <div class="bg-yellow-500 h-full" 
                             style="width: {{ ($dist['status_counts']['pending'] / $dist['beneficiaries_count']) * 100 }}%">
                        </div>
                        <div class="bg-red-500 h-full" 
                             style="width: {{ ($dist['status_counts']['cancelled'] / $dist['beneficiaries_count']) * 100 }}%">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Coverage Progress --}}
    <div class="px-4 py-3 border-t">
        <div class="flex justify-between text-sm text-gray-600 mb-1">
            <span>تغطية المندوبين</span>
            <span>{{ $stats['coverage_stats']['coverage_percentage'] }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-purple-600 h-2 rounded-full transition-all duration-300" 
                 style="width: {{ $stats['coverage_stats']['coverage_percentage'] }}%">
            </div>
        </div>
    </div>

    @if($detailed)
        {{-- Regions List --}}
        @if($bigRegion->regions->isNotEmpty())
        <div class="p-4 border-t">
            <h4 class="font-medium text-gray-700 mb-3 flex items-center">
                <i class="fas fa-map-marker-alt ml-2"></i>
                المناطق التابعة
            </h4>
            <div class="grid grid-cols-2 gap-2">
                @foreach($stats['regions_summary'] as $region)
                <div class="p-2 bg-gray-50 rounded text-sm">
                    <div class="font-medium">{{ $region['name'] }}</div>
                    <div class="text-gray-600 text-xs mt-1">
                        <span class="inline-block">{{ $region['citizens_count'] }} مواطن</span>
                        <span class="inline-block mr-2">{{ $region['representatives_count'] }} مندوب</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Notes --}}
        @if($bigRegion->note)
        <div class="p-4 border-t bg-yellow-50">
            <h4 class="font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-sticky-note text-yellow-600 ml-2"></i>
                ملاحظات
            </h4>
            <p class="text-sm text-gray-700">{{ $bigRegion->note }}</p>
        </div>
        @endif
    @endif
</div>