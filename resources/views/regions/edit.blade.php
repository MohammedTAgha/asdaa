<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Region</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold mb-4">تحرير المنطقة</h1>
        <form action="{{ route('regions.update', $region->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700">الاسم:</label>
                <input type="text" name="name" id="name" value="{{ $region->name }}"
                    class="w-full px-4 py-2 border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="position" class="block text-gray-700">الموقع:</label>
                <input type="text" name="position" id="position" value="{{ $region->position }}"
                    class="w-full px-4 py-2 border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="note" class="block text-gray-700">ملاحات:</label>
                <textarea name="note" id="note" class="w-full px-4 py-2 border rounded-md">{{ $region->note }}</textarea>
            </div>
            <div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">تحديث</button>
                <a href="{{ route('regions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">الغاء</a>
            </div>
        </form>
    </div>
</body>

</html>
