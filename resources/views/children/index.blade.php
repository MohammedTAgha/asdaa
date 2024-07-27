@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Children List</h2>
        <a href="{{ route('children.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Child</a>
        <table class="min-w-full mt-4">
            <thead>
                <tr>
                    <th class="border px-4 py-2">الاسم</th>
                    <th class="border px-4 py-2">تاريخ الميلاد</th>
                    <th class="border px-4 py-2">الجنس</th>
                    <th class="border px-4 py-2">الاب</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($children as $child)
                <tr>
                    <td class="border px-4 py-2">{{ $child->name }}</td>
                    <td class="border px-4 py-2">{{ $child->date_of_birth }}</td>
                    <td class="border px-4 py-2">{{ $child->gender }}</td>
                    <td class="border px-4 py-2">{{ $child->citizen->name }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('children.show', $child->id) }}" class="bg-green-500 text-white px-4 py-2 rounded-md">View</a>
                        <a href="{{ route('children.edit', $child->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md">Edit</a>
                        <form action="{{ route('children.destroy', $child->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection