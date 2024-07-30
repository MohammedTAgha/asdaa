@extends('dashboard')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold mb-4">تحرير بيانات المندوب</h1>
        <form action="{{ route('representatives.update', $representative->id) }}" method="PATCH">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">الهوية:</label>
                <input type="text" name="id" id="id" value="{{ $representative->id }}"
                    class="w-full px-4 py-2 border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700">الاسم:</label>
                <input type="text" name="name" id="name" value="{{ $representative->name }}"
                    class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <!-- name -->

            <div class="mb-4">
                <label for="region_id" class="block text-gray-700">المنطقة:</label>
                <select name="region_id" id="region_id" class="w-full px-4 py-2 border rounded-md" required>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}"
                            {{ $region->id == $representative->region_id ? 'selected' : '' }}>{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700">الهاتف:</label>
                <input type="text" name="phone" id="phone" value="{{ $representative->phone }}"
                    class="w-full px-4 py-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700">العنوان:</label>
                <input type="text" name="address" id="address" value="{{ $representative->address }}"
                    class="w-full px-4 py-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="note" class="block text-gray-700">ملاحظة:</label>
                <textarea name="note" id="note" class="w-full px-4 py-2 border rounded-md">{{ $representative->note }}</textarea>
            </div>
            <div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">تحديث</button>
                <a href="{{ route('representatives.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded ml-2">الغاء</a>
            </div>
        </form>
    </div>
@endsection
