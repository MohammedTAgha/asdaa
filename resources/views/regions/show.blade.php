@extends('dashboard')

@section('content')
@component('components.box', ['title' => 'منطقة' . ' ' . $region->name . ' ' , 'styles'=> 'mb-4'])

    
        {{-- <h1 class="text-4xl font-bold mb-4">بيانات المنطقة</h1> --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">الاسم:</h2>
                <p class="text-gray-700">{{ $region->name }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">مندوبها:</h2>
                
                @if (!$region->representatives->isEmpty())
                    @foreach ($region->representatives as $representative)
                    <p class="text-gray-700">
                        <a href="{{route('representatives.show',$representative->id)}}">
                            {{ $representative->name }}
                        </a>
                    </p>
                    @endforeach
                @else
                <p class="text-gray-700">N/A</p>
                @endif
                
            </div>
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">الموقع:</h2>
                <p class="text-gray-700">{{ $region->position }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">ملاحظة:</h2>
                <p class="text-gray-700">{{ $region->note }}</p>
            </div>
            <div>
                <a href="{{ route('regions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">رجوع</a>
            </div>
        </div>

    @endcomponent
@component('components.box', ['title' => ' المواطنين في منطقة' . ' ' . $region->name , 'styles'=> 'mb-8'])
            <x-citizens :citizens="$region->citizens" />
@endcomponent

@endsection
