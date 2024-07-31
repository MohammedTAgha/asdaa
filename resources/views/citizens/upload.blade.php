@extends('dashboard')

@section('content')
<div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md">
    <h1 class="mb-6 text-2xl font-bold text-center text-gray-700">Upload Excel File</h1>
    @if(session('errors'))
        <div class="mb-4 text-red-600">
            <strong>Errors:</strong>
            <ul>
                @foreach(session('errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="mb-4 text-center">
        <a href="{{ route('citizens.template') }}" class="px-4 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Download Template</a>
    </div>
    
    <form action="{{ route('citizens.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="excel_file" class="block mb-2 font-medium text-gray-700">Excel File</label>
            <input type="file" id="excel_file" name="excel_file" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="flex justify-center">
            <button type="submit" class="px-10 py-4 text-xl font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Upload</button>
        </div>
    </form>
</div>

@endsection