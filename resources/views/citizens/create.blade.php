@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4">Add Citizen</h1>
    <form action="{{ route('citizens.store') }}" method="POST">
        @csrf
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
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <!-- Add other citizen fields as needed -->
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Citizen</button>
    </form>
</div>
@endsection