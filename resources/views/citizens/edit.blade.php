@extends('dashboard')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold my-4">Edit Citizen</h1>
        @include('citizens.partials.form')
        {{-- <form action="{{ route('citizens.update', $citizen->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label for="id" class="block font-medium text-gray-700">الهوية</label>
                <input type="text" id="id" name="id" value="{{ $citizen->id }}"
                    class="w-full border-gray-300 w-full px-4 py-2 border rounded-md"
                    required>
            </div>
            <!-- name -->

            <div class="mb-4">
                <label for="firstname" class="block text-gray-700">الاسم الاول:</label>
                <input type="text" name="firstname" id="firstname" value="{{ $citizen->firstname }}"
                    class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="secondname" class="block text-gray-700">الاب:</label>
                <input type="text" name="secondname" id="secondname" value="{{ $citizen->secondname }}"
                    class="w-full px-4 py-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="thirdname" class="block text-gray-700">الجد:</label>
                <input type="text" name="thirdname" id="thirdname" value="{{ $citizen->thirdname }}"
                    class="w-full px-4 py-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="lastname" class="block text-gray-700">العائلة:</label>
                <input type="text" name="lastname" id="lastname" value="{{ $citizen->lastname }}"
                    class="w-full px-4 py-2 border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="date_of_birth" class="block text-gray-700">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ $citizen->date_of_birth }}"
                    class="mt-1 block w-full rounded border-gray-300">
            </div>
            <div class="mb-4">
                <label for="gender" class="block text-gray-700">Gender:</label>
                <select id="gender" name="gender" required class="mt-1 block w-full rounded border-gray-300">
                    <option value="0" {{ $citizen->gender == '0' ? 'selected' : '' }}>ذكر</option>
                    <option value="1" {{ $citizen->gender == '1' ? 'selected' : '' }}>انثى</option>
                </select>
            </div>
            <!-- Add other citizen fields as needed -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">تحديث البيانات</button>
        </form> --}}
    </div>
@endsection
