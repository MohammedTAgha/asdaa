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

    {{-- Representative Information --}}
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
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

    {{-- Statistics Component --}}
    <x-big-region-stats :bigRegion="$bigRegion" />

    {{-- Notes Section if exists --}}
    @if($bigRegion->note)
        <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
            <h2 class="text-xl font-bold mb-4">ملاحظات</h2>
            <p class="text-gray-600">{{ $bigRegion->note }}</p>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .rtl\:rotate-180 {
        transform: rotate(180deg);
    }
</style>
@endpush

