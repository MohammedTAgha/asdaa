<div class="mb-4">
    <label for="name" class="block text-gray-700">Name:</label>
    <input type="text" id="name" name="name" value="{{ old('name', $distribution->name ?? '') }}" required class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="date" class="block text-gray-700">Date:</label>
    <input type="date" id="date" name="date" value="{{ old('date', $distribution->date ?? '') }}" required class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="distribution_category_id" class="block text-gray-700">Category:</label>
    <select id="distribution_category_id" name="distribution_category_id" required class="mt-1 block w-full rounded border-gray-300">
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ (old('distribution_category_id') ?? $distribution->distribution_category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-4">
    <label for="arrive_date" class="block text-gray-700">Arrive Date:</label>
    <input type="date" id="arrive_date" name="arrive_date" value="{{ old('arrive_date', $distribution->arrive_date ?? '') }}" required class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="quantity" class="block text-gray-700">Quantity:</label>
    <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $distribution->quantity ?? '') }}" required class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="target" class="block text-gray-700">Target:</label>
    <input type="text" id="target" name="target" value="{{ old('target', $distribution->target ?? '') }}" required class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="source" class="block text-gray-700">Source:</label>
    <input type="text" id="source" name="source" value="{{ old('source', $distribution->source ?? '') }}" required class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="done" class="block text-gray-700">Done:</label>
    <select id="done" name="done" required class="mt-1 block w-full rounded border-gray-300">
        <option value="1" {{ (old('done') ?? $distribution->done ?? '') == '1' ? 'selected' : '' }}>Yes</option>
        <option value="0" {{ (old('done') ?? $distribution->done ?? '') == '0' ? 'selected' : '' }}>No</option>
    </select>
</div>
<div class="mb-4">
    <label for="target_count" class="block text-gray-700">Target Count:</label>
    <input type="number" id="target_count" name="target_count" value="{{ old('target_count', $distribution->target_count ?? '') }}" required class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="expectation" class="block text-gray-700">Expectation:</label>
    <input type="text" id="expectation" name="expectation" value="{{ old('expectation', $distribution->expectation ?? '') }}" required class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="min_count" class="block text-gray-700">Min Count:</label>
    <input type="number" id="min_count" name="min_count" value="{{ old('min_count', $distribution->min_count ?? '') }}" required class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="max_count" class="block text-gray-700">Max Count:</label>
    <input type="number" id="max_count" name="max_count" value="{{ old('max_count', $distribution->max_count ?? '') }}" required class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="note" class="block text-gray-700">Note:</label>
    <textarea id="note" name="note" class="mt-1 block w-full rounded border-gray-300">{{ old('note', $distribution->note ?? '') }}</textarea>
</div>