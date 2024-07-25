@extends('dashboard')

@section('content')
    <div class="container mx-auto py-12 mb-4">
        <h1 class="text-4xl font-bold mb-4">Representative Details</h1>
        <div class="bg-white shadow-md rounded-lg p-6 mb-4">
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">Name:</h2>
                <p class="text-gray-700">{{ $representative->name }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">Region:</h2>
                <p class="text-gray-700">{{ $representative->region->name }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">Phone:</h2>
                <p class="text-gray-700">{{ $representative->phone }}</p>
            </div>
            @if($representative->address)
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">Address:</h2>
                <p class="text-gray-700">{{ $representative->address }}</p>
            </div>
            @endif
            @if($representative->note)
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">Note:</h2>
                <p class="text-gray-700">{{ $representative->note }}</p>
            </div>
            @endif
        </div>
        
        @component('components.box',['title'=>" المواطنين في منطقة"." ".$representative->region->name])

        @component('components.citizens',['citizens'=>$representative->region->citizens])
        @endcomponent

        @endcomponent
    </div>
@endsection