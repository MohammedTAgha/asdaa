@extends('dashboard')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-semibold mb-6">File Manager</h1>

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

    <!-- File List -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-medium mb-4">Uploaded Files</h2>
        <ul class="space-y-4">
            @foreach($files as $file)
                <li class="flex items-center justify-between bg-gray-50 p-4 rounded-lg shadow-sm">
                    <div class="flex items-center space-x-4">
                        <div>
                            @if($file->hidden)
                                <span class="inline-block px-3 py-1 text-sm font-medium bg-red-100 text-red-800 rounded-full">Hidden</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-gray-900">{{ $file->name }}</p>
                            <p class="text-sm text-gray-500">Uploaded by: {{ $file->uploaded_by }}</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('files.show', $file->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Download
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
