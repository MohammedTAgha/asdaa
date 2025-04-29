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
    </div>
@endsection
