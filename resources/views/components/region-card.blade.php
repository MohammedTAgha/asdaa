@props([
    'region',
    'showActions' => true,
    'detailed' => false,
])

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    {{-- Header with Region Name and Actions --}}
    <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ $region->name }}</h3>
          
                @if (!empty($region->representatives()))
                    @foreach ($region->representatives as $representative)
                        <p class="text-sm text-gray-600 mt-1 flex items-center">
                            <i class="fas fa-user-tie ml-2"></i>
                            {{ $representative->name }}
                        </p>
                    @endforeach
                @endif

                <p class="text-sm text-gray-600 mt-1 flex items-center">
                    <i class="fas fa-map-marker-alt ml-2"></i>
                    {{ $region->position }}
                </p>
            </div>
            @if($showActions)
            <div class="flex space-x-2 rtl:space-x-reverse">
                <a href="{{ route('regions.show', $region) }}" 
                   class="text-blue-600 hover:text-blue-800 p-1" 
                   title="عرض">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('regions.edit', $region) }}" 
                   class="text-yellow-600 hover:text-yellow-800 p-1"
                   title="تعديل">
                    <i class="fas fa-edit"></i>
                </a>
                @if($region->citizens->count() === 0)
                    <form action="{{ route('regions.destroy', $region) }}" 
                          method="POST" 
                          class="inline-block"
                          onsubmit="return confirm('هل أنت متأكد من حذف هذه المنطقة؟')">
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

    {{-- Statistics Grid --}}
    <div class="grid grid-cols-2 divide-x rtl:divide-x-reverse divide-y">
        <div class="p-4 text-center">
            <span class="text-sm text-gray-600">المواطنين</span>
            <p class="text-2xl font-bold text-blue-600">{{ $region->citizens->count() }}</p>
        </div>
        <div class="p-4 text-center">
            <span class="text-sm text-gray-600">المندوبين</span>
            <p class="text-2xl font-bold text-green-600">{{ $region->representatives->count() }}</p>
        </div>
        <div class="p-4 text-center">
            <span class="text-sm text-gray-600">أفراد الأسر</span>
            <p class="text-2xl font-bold text-purple-600">{{ $region->citizens->sum('family_members') }}</p>
        </div>
        <div class="p-4 text-center">
            <span class="text-sm text-gray-600">المشاريع</span>
            <p class="text-2xl font-bold text-yellow-600">
                {{ $region->citizens->flatMap->distributions->unique()->count() }}
            </p>
        </div>
    </div>

    {{-- Big Region Info --}}
    @if($region->bigRegion)
    <div class="p-4 bg-gray-50 border-t">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center ml-3">
                <i class="fas fa-building text-blue-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">المنطقة الكبيرة</p>
                <p class="font-medium">{{ $region->bigRegion->name }}</p>
            </div>
        </div>
        @if($region->bigRegion->representative)
        <div class="flex items-center mt-3">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center ml-3">
                <i class="fas fa-user-tie text-green-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">مندوب المنطقة الكبيرة</p>
                <p class="font-medium">{{ $region->bigRegion->representative->name }}</p>
            </div>
        </div>
        @endif
    </div>
    @endif

    {{-- Representatives List (if detailed view) --}}
    @if($detailed && $region->representatives->count() > 0)
    <div class="p-4 border-t">
        <h4 class="font-semibold mb-3 flex items-center">
            <i class="fas fa-users text-gray-600 ml-2"></i>
            المندوبين
        </h4>
        <div class="space-y-2">
            @foreach($region->representatives as $representative)
            <div class="flex items-center p-2 bg-gray-50 rounded-lg">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center ml-3">
                    <i class="fas fa-user text-blue-600"></i>
                </div>
                <div>
                    <p class="font-medium">{{ $representative->name }}</p>
                    @if($representative->phone)
                    <p class="text-sm text-gray-600">{{ $representative->phone }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Additional Info (if detailed) --}}
    @if($detailed && $region->note)
    <div class="p-4 border-t bg-yellow-50">
        <h4 class="font-semibold mb-2 flex items-center">
            <i class="fas fa-sticky-note text-yellow-600 ml-2"></i>
            ملاحظات
        </h4>
        <p class="text-gray-700 text-sm">{{ $region->note }}</p>
    </div>
    @endif
</div>