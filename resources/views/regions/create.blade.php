@extends('dashboard')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold mb-4">اضافة منطقة</h1>
        <form action="{{ route('regions.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">اسم المنطقة:</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="position" class="block text-gray-700">موقع المنطقة:</label>
                <input type="text" name="position" id="position" class="w-full px-4 py-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="note" class="block text-gray-700">ملاحطة:</label>
                <textarea name="note" id="note" class="w-full px-4 py-2 border rounded-md"></textarea>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">انشاء</button>
                <a href="{{ route('regions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">الغاء</a>
            </div>
        </form>
    </div>

@endsection