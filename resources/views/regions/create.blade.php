<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Region</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold mb-4">Create Region</h1>
        <form action="{{ route('regions.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name:</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="position" class="block text-gray-700">Position:</label>
                <input type="text" name="position" id="position" class="w-full px-4 py-2 border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="note" class="block text-gray-700">Note:</label>
                <textarea name="note" id="note" class="w-full px-4 py-2 border rounded-md"></textarea>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
                <a href="{{ route('regions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>