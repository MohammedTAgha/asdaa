@extends('dashboard')
@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4">Distributions</h1>
    <a href="{{ route('distributions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Distribution</a>
    <ul class="mt-4">
        @foreach($distributions as $distribution)
            <li class="border-b py-2">
                <a href="{{ route('distributions.show', $distribution->id) }}" class="text-blue-600 hover:underline">{{ $distribution->name }}</a>
                <span class="text-gray-600"> ({{ $distribution->category->name }})</span>
            </li>
        @endforeach
    </ul>
</div>
@endsection