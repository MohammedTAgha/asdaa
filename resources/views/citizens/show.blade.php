@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4">{{ $citizen->name }}</h1>
    <p>Date of Birth: {{ $citizen->date_of_birth }}</p>
    <p>Gender: {{ $citizen->gender }}</p>
    <!-- Add other citizen details as needed -->

    <h2 class="text-xl font-semibold mt-6">Children</h2>
    <ul class="list-disc ml-5">
        @foreach($citizen->children as $child)
            <li>{{ $child->name }} ({{ $child->age() }} years old)</li>
        @endforeach
    </ul>

    <h3 class="text-xl font-semibold mt-6">Add a Child</h3>
    <form action="{{ route('children.store') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="citizen_id" value="{{ $citizen->id }}">
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name:</label>
            <input type="text" id="name" name="name" required class="mt-1 block w-full rounded border-gray-300">
        </div>
        <div class="mb-4">
            <label for="date_of_birth" class="block text-gray-700">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" required class="mt-1 block w-full rounded border-gray-300">
        </div>
        <div class="mb-4">
            <label for="gender" class="block text-gray-700">Gender:</label>
            <select id="gender" name="gender" required class="mt-1 block w-full rounded border-gray-300">
                <option value="0">Male</option>
                <option value="1">Female</option>
            </select>
        </div>
        <!-- Add other child fields as needed -->
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Child</button>
    </form>
</div>
@endsection