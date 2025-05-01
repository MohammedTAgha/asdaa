@extends('dashboard')
@section('title', 'تفاصيل المنطقة')

@section('content')
    <div class="container mx-auto py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">تفاصيل المنطقة: {{ $region->name }}</h1>
            <div>
                <a href="{{ route('regions.edit', $region->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded ml-2">
                    تعديل
                </a>
                <a href="{{ route('regions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">
                    رجوع
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded my-6">
            <div class="p-6 space-y-6">
                <div class="border-b pb-4">
                    <h2 class="text-xl font-semibold mb-4">معلومات اساسية</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600">اسم المنطقة:</p>
                            <p class="font-semibold">{{ $region->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">الموقع:</p>
                            <p class="font-semibold">{{ $region->position }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-b pb-4">
                    <h2 class="text-xl font-semibold mb-4">المنطقة الكبيرة</h2>
                    @if($region->bigRegion)
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-600">اسم المنطقة الكبيرة:</p>
                                    <p class="font-semibold">{{ $region->bigRegion->name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">مندوب المنطقة الكبيرة:</p>
                                    <p class="font-semibold">
                                        {{ $region->bigRegion->representative ? $region->bigRegion->representative->name : 'لا يوجد' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 italic">هذه المنطقة ليست جزءاً من منطقة كبيرة</p>
                    @endif
                </div>

                <div class="border-b pb-4">
                    <h2 class="text-xl font-semibold mb-4">مندوبي المنطقة</h2>
                    @if($region->representatives->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($region->representatives->where('is_big_region_representative', false) as $representative)
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <p class="font-semibold">{{ $representative->name }}</p>
                                    @if($representative->phone)
                                        <p class="text-gray-600">رقم الهاتف: {{ $representative->phone }}</p>
                                    @endif
                                    @if($representative->address)
                                        <p class="text-gray-600">العنوان: {{ $representative->address }}</p>
                                    @endif
                                    @if($representative->note)
                                        <p class="text-gray-600">ملاحظات: {{ $representative->note }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">لا يوجد مندوبين لهذه المنطقة</p>
                    @endif
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-4">احصائيات</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-gray-600">عدد المواطنين:</p>
                            <p class="font-semibold text-2xl">{{ $region->citizens->count() }}</p>
                        </div>
                    </div>
                </div>

                @if($region->note)
                    <div class="border-t pt-4">
                        <h2 class="text-xl font-semibold mb-2">ملاحظات</h2>
                        <p class="text-gray-700">{{ $region->note }}</p>
                    </div>
                @endif
            </div>
            
        </div>

        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">مواطني المنطقة</h2>
            
            <!-- Region Statistics Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 rounded-lg p-4 shadow">
                    <h3 class="text-lg font-semibold text-blue-700">إجمالي المواطنين</h3>
                    <p class="text-3xl font-bold text-blue-900">{{ $region->citizens->count() }}</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4 shadow">
                    <h3 class="text-lg font-semibold text-green-700">إجمالي أفراد الأسر</h3>
                    <p class="text-3xl font-bold text-green-900">{{ $region->citizens->sum('family_members') }}</p>
                </div>
                <div class="bg-purple-50 rounded-lg p-4 shadow">
                    <h3 class="text-lg font-semibold text-purple-700">المشاريع المستفاد منها</h3>
                    <p class="text-3xl font-bold text-purple-900">{{ $region->citizens->flatMap->distributions->unique()->count() }}</p>
                </div>
            </div>

            <!-- Projects/Distributions Summary -->
            @if($distributions->count() > 0)
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h3 class="text-xl font-semibold mb-4">ملخص المشاريع</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($distributions as $distribution)
                    @php
                        $regionCitizens = $region->citizens->whereIn('id', $distribution->citizens->pluck('id'));
                        $totalBenefited = $regionCitizens->count();
                        $percentage = $region->citizens->count() > 0 
                            ? round(($totalBenefited / $region->citizens->count()) * 100, 1) 
                            : 0;
                    @endphp
                    <div class="bg-gray-50 rounded p-4">
                        <h4 class="text-lg font-semibold text-gray-700">{{ $distribution->name }}</h4>
                        <div class="mt-2">
                            <div class="flex justify-between mb-1">
                                <span class="text-sm text-gray-600">المستفيدين:</span>
                                <span class="text-sm font-semibold">{{ $totalBenefited }}</span>
                            </div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm text-gray-600">النسبة:</span>
                                <span class="text-sm font-semibold">{{ $percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <x-citizens :citizens="$region->citizens" :distributions="$distributions" :regions="$regions" :regionId="$region->id" />
        </div>
    </div>
@endsection
