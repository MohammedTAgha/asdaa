@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4">Citizens</h1>
    <a href="{{ route('citizens.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Citizen</a>
    <ul class="mt-4">
        @foreach($citizens as $citizen)
            <li class="border-b py-2">
                <a href="{{ route('citizens.show', $citizen->id) }}" class="text-blue-600 hover:underline">{{ $citizen->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection