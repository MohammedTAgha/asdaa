@extends('dashboard')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold mb-4">انشاء مندوب</h1>
        <form action="{{ route('representatives.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="id" class="block text-gray-700">الهوية:</label>
                <input type="text" name="id" id="id" class="w-full px-4 py-2 border rounded-md" >
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700">الاسم:</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="region_id" class="block text-gray-700">المنطقة:</label>
                <select name="region_id" id="region_id" class="w-full px-4 py-2 border rounded-md" required>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700">رقم الهاتف:</label>
                <input type="text" name="phone" id="phone" class="w-full px-4 py-2 border rounded-md" >
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700">العنوان:</label>
                <input type="text" name="address" id="address" class="w-full px-4 py-2 border rounded-md" >
            </div>
            <div class="mb-4">
                <label for="note" class="block text-gray-700">ملاحظة:</label>
                <textarea name="note" id="note" class="w-full px-4 py-2 border rounded-md"></textarea>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">انشاء</button>
                <a href="{{ route('representatives.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">الغاء</a>
            </div>
        </form>
    </div>
@endsection