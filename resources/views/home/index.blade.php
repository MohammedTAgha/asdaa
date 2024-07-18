<!-- resources/views/home.blade.php -->

@extends('dashboard')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Home</h1>
        <p>Welcome to the Dashboard!</p>
        @include(layouts.header)
    </div>
@endsection