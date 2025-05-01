@props(['distribution' => null])

@php
    $distributionService = app(App\Services\DistributionService::class);
    $stats = $distributionService->getDistributionStatistics($distribution?->id);
    $progress = $distribution ? $distributionService->getDistributionProgress($distribution->id) : null;
@endphp

<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Citizens Card -->
        <div class="bg-blue-50 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-blue-700">إجمالي المستفيدين</h3>
            <p class="text-3xl font-bold text-blue-900">{{ $stats['total_citizens'] ?? 0 }}</p>
        </div>

        <!-- Total Family Members Card -->
        <div class="bg-green-50 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-green-700">إجمالي أفراد الأسر</h3>
            <p class="text-3xl font-bold text-green-900">{{ $stats['total_family_members'] ?? 0 }}</p>
        </div>

        <!-- Distribution Status -->
        <div class="bg-purple-50 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-purple-700">حالة التوزيع</h3>
            <p class="text-xl font-semibold text-purple-900">{{ $stats['status'] ?? 'غير محدد' }}</p>
        </div>

        <!-- Last Update -->
        <div class="bg-yellow-50 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-yellow-700">آخر تحديث</h3>
            <p class="text-xl font-semibold text-yellow-900">{{ $stats['updated_at'] ?? '-' }}</p>
        </div>
    </div>

    @if($progress)
    <!-- Distribution Progress -->
    <div class="mb-6">
        <h3 class="text-xl font-semibold mb-4">تقدم التوزيع</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-green-100 rounded-lg p-4">
                <h4 class="text-green-700">تم التوزيع</h4>
                <p class="text-2xl font-bold text-green-900">{{ $progress['total_distributed'] }}</p>
            </div>
            <div class="bg-yellow-100 rounded-lg p-4">
                <h4 class="text-yellow-700">قيد الانتظار</h4>
                <p class="text-2xl font-bold text-yellow-900">{{ $progress['total_pending'] }}</p>
            </div>
            <div class="bg-red-100 rounded-lg p-4">
                <h4 class="text-red-700">ملغى</h4>
                <p class="text-2xl font-bold text-red-900">{{ $progress['total_cancelled'] }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Regional Distribution -->
    @if(isset($stats['citizens_by_region']) && count($stats['citizens_by_region']) > 0)
    <div>
        <h3 class="text-xl font-semibold mb-4">التوزيع حسب المنطقة</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($stats['citizens_by_region'] as $regionStats)
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-700">{{ $regionStats['region_name'] }}</h4>
                <div class="grid grid-cols-2 gap-2 mt-2">
                    <div>
                        <p class="text-sm text-gray-600">المستفيدين</p>
                        <p class="text-xl font-bold text-gray-900">{{ $regionStats['count'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">مجموع الأفراد</p>
                        <p class="text-xl font-bold text-gray-900">{{ $regionStats['total_members'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>