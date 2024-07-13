<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regions</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold mb-4">Regions</h1>
        <a href="{{ route('regions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create New Region</a>
        <div class="mt-6">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/3 py-3 px-4 uppercase font-semibold text-sm">Name</th>
                        <th class="w-1/3 py-3 px-4 uppercase font-semibold text-sm">Position</th>
                        <th class="w-1/3 py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($regions as $region)
                    <tr>
                        <td class="w-1/3 py-3 px-4">{{ $region->name }}</td>
                        <td class="w-1/3 py-3 px-4">{{ $region->position }}</td>
                        <td class="w-1/3 py-3 px-4">
                            <a href="{{ route('regions.show', $region->id) }}" class="text-blue-500">View</a>
                            <a href="{{ route('regions.edit', $region->id) }}" class="text-green-500 ml-2">Edit</a>
                            <form action="{{ route('regions.destroy', $region->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 ml-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>