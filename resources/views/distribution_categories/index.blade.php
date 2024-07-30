@extends('dashboard')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold my-4">Distribution Categories</h1>
        <a href="{{ route('distribution_categories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add
            Category</a>
        <ul class="mt-4">
            @foreach ($categories as $category)
                <li class="border-b py-2">
                    <a href="{{ route('distribution_categories.show', $category->id) }}"
                        class="text-blue-600 hover:underline">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
