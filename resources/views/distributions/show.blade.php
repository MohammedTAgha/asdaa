@extends('dashboard')
@section('title', $distribution->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Project Header --}}
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $distribution->name }}</h1>
                <div class="flex items-center space-x-4 rtl:space-x-reverse text-gray-600">
                    <span class="flex items-center">
                        <i class="fas fa-tag ml-2"></i>
                        {{ $distribution->category?->name ?? 'غير مصنف' }}
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-building ml-2"></i>
                        {{ $distribution->source?->name ?? $distribution->source ?? 'غير محدد' }}
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-calendar ml-2"></i>
                        {{ $distribution->date ? \Carbon\Carbon::parse($distribution->date)->format('Y/m/d') : 'غير محدد' }}
                    </span>
                </div>
            </div>
            <div class="flex space-x-2 rtl:space-x-reverse">
                <a href="{{ route('distributions.edit', $distribution) }}" 
                   class="btn-secondary">
                    <i class="fas fa-edit ml-1"></i>
                    تعديل
                </a>
                <a href="{{ route('distributions.export', $distribution->id) }}" 
                   class="btn-primary">
                    <i class="fas fa-download ml-1"></i>
                    تصدير
                </a>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Target Count --}}
        <div class="stat-card bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-700">المستفيدين</h2>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-users text-2xl text-blue-600"></i>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">العدد الكلي</span>
                    <span class="text-2xl font-bold text-gray-800">{{ $stats['citizens_count'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">تم التوزيع</span>
                    <span class="text-xl text-green-600">{{ $stats['benafated'] }}</span>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">نسبة الإنجاز</span>
                    <span class="text-blue-600">{{ number_format($stats['benefated_percentage'], 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $stats['benefated_percentage'] }}%"></div>
                </div>
            </div>
        </div>

        {{-- Package Stats --}}
        <div class="stat-card bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-700">الكميات</h2>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-box text-2xl text-green-600"></i>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">الكمية الكلية</span>
                    <span class="text-2xl font-bold text-gray-800">{{ $distribution->quantity ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">تم توزيع</span>
                    <span class="text-xl text-green-600">{{ $stats['total_quantity'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">متوسط لكل مستفيد</span>
                    <span class="text-lg text-blue-600">{{ number_format($stats['avg_quantity'] ?? 0, 1) }}</span>
                </div>
            </div>
        </div>

        {{-- Coverage Stats --}}
        <div class="stat-card bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-700">تغطية المناطق</h2>
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-map-marker-alt text-2xl text-purple-600"></i>
                </div>
            </div>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">عدد المناطق المستفيدة</span>
                    <span class="text-2xl font-bold text-gray-800">{{ count($stats['regions_summary'] ?? []) }}</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach(array_slice($stats['regions_summary'] ?? [], 0, 3) as $region)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            {{ $region['name'] }}
                        </span>
                    @endforeach
                    @if(count($stats['regions_summary'] ?? []) > 3)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            +{{ count($stats['regions_summary']) - 3 }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Time Stats --}}
        <div class="stat-card bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-700">معلومات زمنية</h2>
                <div class="bg-yellow-100 rounded-full p-3">
                    <i class="fas fa-clock text-2xl text-yellow-600"></i>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">تاريخ البدء</span>
                    <span class="text-gray-800">{{ $distribution->date ? \Carbon\Carbon::parse($distribution->date)->format('Y/m/d') : 'غير محدد' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">تاريخ الوصول</span>
                    <span class="text-gray-800">{{ $distribution->arrive_date ? \Carbon\Carbon::parse($distribution->arrive_date)->format('Y/m/d') : 'غير محدد' }}</span>
                </div>
                @if($distribution->done)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check-circle ml-1"></i>
                        مكتمل
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        <i class="fas fa-clock ml-1"></i>
                        قيد التنفيذ
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Project Details --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Main Info --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">تفاصيل المشروع</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($distribution->target)
                <div>
                    <label class="text-sm font-medium text-gray-600">الفئة المستهدفة</label>
                    <p class="mt-1 text-gray-800">{{ $distribution->target }}</p>
                </div>
                @endif
                
                @if($distribution->expectation)
                <div>
                    <label class="text-sm font-medium text-gray-600">العدد المتوقع</label>
                    <p class="mt-1 text-gray-800">{{ $distribution->expectation }}</p>
                </div>
                @endif

                @if($distribution->min_count || $distribution->max_count)
                <div>
                    <label class="text-sm font-medium text-gray-600">عدد الأفراد</label>
                    <p class="mt-1 text-gray-800">من {{ $distribution->min_count }} إلى {{ $distribution->max_count }}</p>
                </div>
                @endif
            </div>

            @if($distribution->note)
            <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
                <label class="text-sm font-medium text-gray-600">ملاحظات</label>
                <p class="mt-1 text-gray-800">{{ $distribution->note }}</p>
            </div>
            @endif
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">إجراءات سريعة</h2>
            <div class="space-y-3">
                <button class="w-full btn-primary" onclick="document.getElementById('addCitizensModal').style.display='block'">
                    <i class="fas fa-user-plus ml-2"></i>
                    إضافة مستفيدين
                </button>
                <button class="w-full btn-secondary" onclick="document.getElementById('filterModal').style.display='block'">
                    <i class="fas fa-filter ml-2"></i>
                    تصفية المستفيدين
                </button>
                <button class="w-full btn-secondary">
                    <i class="fas fa-file-export ml-2"></i>
                    تصدير التقرير
                </button>
                @if(!$distribution->done)
                <button class="w-full btn-success">
                    <i class="fas fa-check-circle ml-2"></i>
                    إنهاء المشروع
                </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Beneficiaries Table Section --}}
    @include('components.box', ['title' => 'المستفيدين'])
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-4 border-b">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <div class="relative">
                            <input type="text" 
                                   id="searchbar" 
                                   class="form-control pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   placeholder="بحث فوري...">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                            <button id="make-done" class="btn-success">
                                <i class="fas fa-check ml-1"></i>
                                تسليم المحدد
                            </button>
                            <button id="delete-from-distribution" class="btn-danger">
                                <i class="fas fa-trash ml-1"></i>
                                حذف المحدد
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="ctzlist" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-right">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">الهوية</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">الاسم</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">المنطقة</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">افراد</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">الكمية المستلمة</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">استلم</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">تاريخ الاستلام</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">اسم المستلم</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">ملاحظة</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-500">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- DataTable will populate this -->
                    </tbody>
                </table>
            </div>
        </div>
    @endsection

@push('scripts')
// ...existing scripts...
@endpush

<style>
.btn-primary {
    @apply bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center;
}

.btn-secondary {
    @apply bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors flex items-center justify-center;
}

.btn-success {
    @apply bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center;
}

.btn-danger {
    @apply bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center;
}

.stat-card {
    animation: fadeInUp 0.5s ease-out forwards;
    opacity: 0;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }
</style>
