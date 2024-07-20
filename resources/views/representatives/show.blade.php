@extends('dashboard')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold mb-4">Representative Details</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
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
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">Address:</h2>
                <p class="text-gray-700">{{ $representative->address }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">Note:</h2>
                <p class="text-gray-700">{{ $representative->note }}</p>
            </div>
            <div>
                <a href="{{ route('representatives.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back</a>
            </div>
        </div>
    </div>
@endsection