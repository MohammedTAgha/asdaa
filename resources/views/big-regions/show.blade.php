@extends('dashboard')
@section('title', 'عرض المنطقة الكبيرة - ' . $bigRegion->name)

@section('content')
<div class="container mx-auto py-6">
    {{-- Header Actions --}}
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('big-regions.index') }}" 
           class="text-gray-600 hover:text-gray-900 flex items-center">
            <i class="fas fa-arrow-right ml-2"></i>
            رجوع للمناطق الكبيرة
        </a>
        <div class="flex gap-2">
            <a href="{{ route('big-regions.edit', $bigRegion) }}" 
               class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 flex items-center">
                <i class="fas fa-edit ml-2"></i>
                تعديل المنطقة
            </a>
            <a href="{{ route('big-regions.export-citizens', $bigRegion) }}" 
               class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 flex items-center">
                <i class="fas fa-file-export ml-2"></i>
                تصدير المواطنين
            </a>
        </div>
    </div>

    {{-- Big Region Card (Detailed Mode) --}}
    <x-big-region-card :bigRegion="$bigRegion" :detailed="true" :showActions="false" />

    {{-- Regions Grid --}}
    @if($bigRegion->regions->isNotEmpty())
    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4">المناطق التابعة</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($bigRegion->regions as $region)
                <x-region-card :region="$region" :detailed="false" />
            @endforeach
        </div>
    </div>
    @endif

    {{-- Citizens Table --}}
    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4">المواطنين</h2>
        
        <x-citizens 
            :citizens="$bigRegion->regions->flatMap->citizens" 
            :distributions="$distributions" 
            :regions="$regions"
            :regionId="$bigRegion->id"
        />
    </div>
</div>
@endsection

