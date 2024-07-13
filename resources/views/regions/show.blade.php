<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Region Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold mb-4">Region Details</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">Name:</h2>
                <p class="text-gray-700">{{ $region->name }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">Position:</h2>
                <p class="text-gray-700">{{ $region->position }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">Note:</h2>
                <p class="text-gray-700">{{ $region->note }}</p>
            </div>
            <div>
                <a href="{{ route('regions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back</a>
            </div>
        </div>
    </div>
</body>
</html>