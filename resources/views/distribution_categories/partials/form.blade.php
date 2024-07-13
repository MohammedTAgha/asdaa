<div class="mb-4">
    <label for="name" class="block text-gray-700">Name:</label>
    <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="description" class="block text-gray-700">Description:</label>
    <textarea id="description" name="description" class="mt-1 block w-full rounded border-gray-300">{{ old('description', $category->description ?? '') }}</textarea>
</div>