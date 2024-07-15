@extends('dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4">{{ $category->name }}</h1>
    <p>Description: {{ $category->description }}</p>
    <h2 class="text-xl font-semibold mt-6">Distributions</h2>
    <ul class="list-disc ml-5">
        @foreach($category->distributions as $distribution)
            <li>{{ $distribution->name }}</li>
        @endforeach
    </ul>
</div>
@endsection