@extends('dashboard')

@section('content')
<div class="container mx-auto px-4">
  <!-- show.blade.php -->
  
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Citizen Details</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">ID</label>
                <p class="mt-1 text-gray-900">{{ $citizen->id }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <p class="mt-1 text-gray-900">{{ $citizen->name }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                <p class="mt-1 text-gray-900">{{ $citizen->date_of_birth }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Gender</label>
                <p class="mt-1 text-gray-900">{{ $citizen->gender }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Region</label>
                <p class="mt-1 text-gray-900">{{ $citizen->region->name }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Wife ID</label>
                <p class="mt-1 text-gray-900">{{ $citizen->wife_id }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Wife Name</label>
                <p class="mt-1 text-gray-900">{{ $citizen->wife_name }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Widowed</label>
                <p class="mt-1 text-gray-900">{{ $citizen->widowed ? 'Yes' : 'No' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Social Status</label>
                <p class="mt-1 text-gray-900">{{ $citizen->social_status }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Living Status</label>
                <p class="mt-1 text-gray-900">{{ $citizen->living_status }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Job</label>
                <p class="mt-1 text-gray-900">{{ $citizen->job }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Original Address</label>
                <p class="mt-1 text-gray-900">{{ $citizen->original_address }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Elderly Count</label>
                <p class="mt-1 text-gray-900">{{ $citizen->elderly_count }}</p>
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Note</label>
                <p class="mt-1 text-gray-900">{{ $citizen->note }}</p>
            </div>
        </div>
        
        <div class="mt-6">
            <a href="{{ route('citizens.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">Back to List</a>
            <a href="{{ route('citizens.edit', $citizen->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md">Edit</a>
        </div>
    </div>
</div>
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