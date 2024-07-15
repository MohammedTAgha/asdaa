@extends('dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4">Add Category</h1>
    <form action="{{ route('distribution_categories.store') }}" method="POST">
        @csrf
        @include('distribution_categories.partials.form')
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Category</button>
    </form>
</div>
@endsection