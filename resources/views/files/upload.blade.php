@extends('dashboard')

@section('content')

 <!-- File Upload Form -->
 <div class="bg-white shadow rounded-lg p-6 mb-6">
    <h2 class="text-xl font-medium mb-4">Upload a New File</h2>
    <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="flex items-center">
        @csrf
        <div class="flex-1">
            <input type="file" name="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
        </div>
        <div class="ml-4">
            <label for="hidden" class="inline-flex items-center text-sm text-gray-700">
                <input type="checkbox" name="hidden" id="hidden" class="form-checkbox h-4 w-4 text-indigo-600">
                <span class="ml-2">Hidden (Super Admins Only)</span>
            </label>
        </div>
        <div class="ml-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Upload
            </button>
        </div>
    </form>
</div>


@endsection