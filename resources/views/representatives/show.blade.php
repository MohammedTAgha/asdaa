@extends('dashboard')

@section('content')
    <div class="container mx-auto py-12 mb-4">
        <h1 class="text-4xl font-bold mb-4">بيانات المندوب</h1>
        <div class="bg-white shadow-md rounded-lg p-6 mb-4">
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">الاسم:</h2>
                <p class="text-gray-700">{{ $representative->name }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">المنطقة:</h2>
                <p class="text-gray-700">{{ $representative->region->name ??'N/A'}}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">الهاتف:</h2>
                <p class="text-gray-700">{{ $representative->phone }}</p>
            </div>
            @if ($representative->address)
                <div class="mb-4">
                    <h2 class="text-2xl font-semibold">العنوان:</h2>
                    <p class="text-gray-700">{{ $representative->address }}</p>
                </div>
            @endif
            @if ($representative->note)
                <div class="mb-4">
                    <h2 class="text-2xl font-semibold">ملاحظة:</h2>
                    <p class="text-gray-700">{{ $representative->note }}</p>
                </div>
            @endif
        </div>
        @if ($representative->region)
            @component('components.box', ['title' => ' المواطنين في منطقة' . ' ' . $representative->region->name ??'N/A'])
            <x-citizens :citizens="$representative->region->citizens" />
        @endcomponent
        @endif
       <h3> no reion</h3>
    </div>
@endsection
