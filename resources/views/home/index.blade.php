@extends('dashboard')
@section('title','الرئيسية')
@section('content')

<!-- Section 1: Overview Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
    <div class="bg-blue-50 border-l-4 border-blue-300 shadow-md rounded-lg p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-200">
                <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="mr-4">
                <h3 class="text-blue-700 text-xl font-semibold">عدد الافراد الاجمالي</h3>
                <p class="text-5xl font-bold text-blue-800 mt-4" id="citizen-counter" data-target="{{ $statistics['total_citizens'] }}">0</p>
            </div>
        </div>
    </div>

    <div class="bg-green-50 border-l-4 border-green-300 shadow-md rounded-lg p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-200">
                <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
            <div class="mr-4">
                <h3 class="text-green-700 text-xl font-semibold">المساعدات الموزعة</h3>
                <p class="text-5xl font-bold text-green-800 mt-4" id="aid-counter" data-target="{{ $statistics['total_distributed_aid'] }}">0</p>
            </div>
        </div>
    </div>

    <div class="bg-purple-50 border-l-4 border-purple-300 shadow-md rounded-lg p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-200">
                <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div class="mr-4">
                <h3 class="text-purple-700 text-xl font-semibold">عدد المناطق</h3>
                <p class="text-5xl font-bold text-purple-800 mt-4" id="regions-counter" data-target="{{ $statistics['total_regions'] }}">0</p>
            </div>
        </div>
    </div>

    <div class="bg-yellow-50 border-l-4 border-yellow-300 shadow-md rounded-lg p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-200">
                <svg class="w-6 h-6 text-yellow-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div class="mr-4">
                <h3 class="text-yellow-700 text-xl font-semibold">عدد التوزيعات</h3>
                <p class="text-5xl font-bold text-yellow-800 mt-4" id="distributions-counter" data-target="{{ $statistics['total_distributions'] }}">0</p>
            </div>
        </div>
    </div>
</div>

<!-- Section 2: Distributions Overview -->
<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">التوزيعات الأخيرة</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($recentDistributions as $distribution)
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $distribution['name'] }}</h3>
                    <p class="text-sm text-gray-600">{{ $distribution['category'] }}</p>
                </div>
                <span class="px-3 py-1 text-sm rounded-full {{ $distribution['status'] === 'مكتمل' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $distribution['status'] }}
                </span>
            </div>
            <div class="mt-4">
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <span>التقدم</span>
                    <span>{{ $distribution['progress'] }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $distribution['progress'] }}%"></div>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <p>المصدر: {{ $distribution['source'] }}</p>
                <p>التاريخ: {{ $distribution['date'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Section 3: Big Region Cards -->
<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">المناطق الكبرى</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($bigRegions as $bigRegion)
            {{-- @dump($bigRegion) --}}
            <x-big-region-card :big-region="$bigRegion" />
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('[data-target]');
    
    counters.forEach(counter => {
        const target = +counter.getAttribute('data-target');
        const duration = 1000; // Animation duration in milliseconds
        const steps = 50; // Number of steps in the animation
        const stepValue = target / steps;
        let current = 0;
        
        const updateCounter = () => {
            current += stepValue;
            if (current > target) {
                counter.innerText = Math.round(target).toLocaleString();
            } else {
                counter.innerText = Math.round(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            }
        };
        
        updateCounter();
    });
});
</script>

@endsection
