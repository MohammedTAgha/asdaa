<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Representative</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold mb-4">Edit Region Representative</h1>
        <form action="{{ route('representatives.update', $representative->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700">ID:</label>
                <input type="text" name="id" id="id" value="{{ $representative->id }}" class="w-full px-4 py-2 border rounded-md" >
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name:</label>
                <input type="text" name="name" id="name" value="{{ $representative->name }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="region_id" class="block text-gray-700">Region:</label>
                <select name="region_id" id="region_id" class="w-full px-4 py-2 border rounded-md" required>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" {{ $region->id == $representative->region_id ? 'selected' : '' }}>{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700">Phone:</label>
                <input type="text" name="phone" id="phone" value="{{ $representative->phone }}" class="w-full px-4 py-2 border rounded-md" >
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700">Address:</label>
                <input type="text" name="address" id="address" value="{{ $representative->address }}" class="w-full px-4 py-2 border rounded-md" >
            </div>
            <div class="mb-4">
                <label for="note" class="block text-gray-700">Note:</label>
                <textarea name="note" id="note" class="w-full px-4 py-2 border rounded-md">{{ $representative->note }}</textarea>
            </div>
            <div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
                <a href="{{ route('representatives.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>