@extends('dashboard')
@section('content')
<div class="bg-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Create Citizen</h2>
        <form action="{{ route('citizens.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="id" class="block font-medium text-gray-700">id</label>
                <input type="text" id="id" name="id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>
            <div>
                <label for="name" class="block font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>
            <div>
                <label for="date_of_birth" class="block font-medium text-gray-700">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>
            <div>
                <label for="gender" class="block font-medium text-gray-700">Gender</label>
                <select id="gender" name="gender" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <option value="">Select Gender</option>
                    <option value="0">Male</option>
                    <option value="1">Female</option>
                </select>
            </div>
            <div>
                <label for="wife_name" class="block font-medium text-gray-700">Wife Name</label>
                <input type="text" id="wife_name" name="wife_name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="wife_id" class="block font-medium text-gray-700">Wife ID</label>
                <input type="text" id="wife_id" name="wife_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="widowed" class="block font-medium text-gray-700">Widowed</label>
                <select id="widowed" name="widowed" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="0">Select Widowed Status</option>
                    <option value="1">Husband is Widowed</option>
                    <option value="2">Wife is Widowed</option>
                </select>
            </div>
            <div>
                <label for="social_status" class="block font-medium text-gray-700">Social Status</label>
                <input type="text" id="social_status" name="social_status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="living_status" class="block font-medium text-gray-700">Living Status</label>
                <input type="text" id="living_status" name="living_status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="job" class="block font-medium text-gray-700">Job</label>
                <input type="text" id="job" name="job" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="original_address" class="block font-medium text-gray-700">Original Address</label>
                <input type="text" id="original_address" name="original_address" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="elderly_count" class="block font-medium text-gray-700">Elderly Count</label>
                <input type="text" id="elderly_count" name="elderly_count" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="region_id" class="block font-medium text-gray-700">Region</label>
                <select id="region_id" name="region_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <option value="">Select Region</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="note" class="block font-medium text-gray-700">Note</label>
                <textarea id="note" name="note" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection