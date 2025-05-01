@props(['bigRegion' => null])

@php
    $bigRegionService = app(App\Services\BigRegionService::class);
    $stats = $bigRegionService->getBigRegionStatistics($bigRegion?->id)->first();
@endphp

<div class="space-y-6">
    {{-- Quick Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-blue-50 rounded-lg p-4 shadow">
            <h3 class="text-lg font-semibold text-blue-700">إجمالي المواطنين</h3>
            <p class="text-3xl font-bold text-blue-900">{{ $stats['total_citizens'] }}</p>
        </div>
        
        <div class="bg-green-50 rounded-lg p-4 shadow">
            <h3 class="text-lg font-semibold text-green-700">عدد المناطق</h3>
            <p class="text-3xl font-bold text-green-900">{{ $stats['total_regions'] }}</p>
        </div>
        
        <div class="bg-purple-50 rounded-lg p-4 shadow">
            <h3 class="text-lg font-semibold text-purple-700">إجمالي المندوبين</h3>
            <p class="text-3xl font-bold text-purple-900">{{ $stats['total_representatives'] }}</p>
        </div>
        
        <div class="bg-yellow-50 rounded-lg p-4 shadow">
            <h3 class="text-lg font-semibold text-yellow-700">مجموع المشاريع</h3>
            <p class="text-3xl font-bold text-yellow-900">{{ $stats['distributions_stats']['total_distributions'] }}</p>
        </div>
    </div>

    {{-- Distribution Statistics --}}
    @if($stats['distributions_stats']['total_distributions'] > 0)
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">المشاريع والمستفيدين</h2>
            <span class="text-sm text-gray-500">{{ $stats['total_citizens'] }} مواطن في المنطقة</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($stats['distributions_stats']['distributions'] as $dist)
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="font-semibold text-lg">{{ $dist['name'] }}</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ $dist['beneficiaries_count'] }} مستفيد
                        </p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm 
                        @if($dist['status'] === 'active') bg-green-100 text-green-800
                        @elseif($dist['status'] === 'completed') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $dist['status'] }}
                    </span>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>نسبة التغطية</span>
                        <span>{{ $dist['percentage'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                             style="width: {{ $dist['percentage'] }}%">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Coverage Progress --}}
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4">تغطية المندوبين</h2>
        <div class="space-y-2">
            <div class="flex justify-between text-sm text-gray-600">
                <span>نسبة التغطية</span>
                <span>{{ $stats['coverage_stats']['coverage_percentage'] }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" 
                     style="width: {{ $stats['coverage_stats']['coverage_percentage'] }}%">
                </div>
            </div>
            <p class="text-sm text-gray-500">
                {{ $stats['coverage_stats']['regions_with_representatives'] }} 
                من 
                {{ $stats['coverage_stats']['total_regions'] }} 
                مناطق لديها مندوبين
            </p>
        </div>
    </div>

    {{-- Regions Summary --}}
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4">ملخص المناطق</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($stats['regions_summary'] as $region)
            <div class="border rounded-lg p-4">
                <h3 class="font-semibold text-lg mb-2">{{ $region['name'] }}</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">المواطنين:</span>
                        <span class="font-medium">{{ $region['citizens_count'] }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">المندوبين:</span>
                        <span class="font-medium">{{ $region['representatives_count'] }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-600">مجموع أفراد الأسر:</span>
                        <span class="font-medium">{{ $region['total_family_members'] }}</span>
                    </div>
                </div>
                @if($region['representatives_count'] > 0)
                <div class="mt-3 pt-3 border-t">
                    <span class="text-sm text-gray-600">المندوبين:</span>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach($region['representatives'] as $rep)
                        <span class="inline-flex items-center px-2 py-1 bg-gray-100 rounded-full text-xs">
                            {{ $rep['name'] }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>