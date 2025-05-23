@extends('dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Add Citizens to Category</h1>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('categories.add-citizens', $category) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Category: {{ $category->name }}
                    </label>
                </div>

                <div class="mb-4">
                    <label for="citizen_ids" class="block text-sm font-medium text-gray-700 mb-2">
                        Citizen IDs (one per line)
                    </label>
                    <textarea
                        id="citizen_ids"
                        name="citizen_ids"
                        rows="10"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        placeholder="Enter citizen IDs (one per line)"
                    >{{ old('citizen_ids') }}</textarea>
                    @error('citizen_ids')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('categories.show', $category) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Add Citizens to Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
