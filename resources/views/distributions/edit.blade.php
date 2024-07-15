@extends('dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4">Edit Distribution</h1>
    <form action="{{ route('distributions.update', $distribution->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('distributions.partials.form')
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Distribution</button>
    </form>
</div>
@endsection