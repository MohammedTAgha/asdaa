<div class="mb-4">
    <label for="name" class="block text-gray-700">الوصف:</label>
    <input type="text" id="name" name="name" value="{{ old('name', $distribution->name ?? '') }}" required
        class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="date" class="block text-gray-700">تاريخ التسليم:</label>
    <input type="date" id="date" name="date" value="{{ old('date', $distribution->date ?? '') }}" required
        class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="distribution_category_id" class="block text-gray-700">الفئة:</label>
    <select id="distribution_category_id" name="distribution_category_id" required
        class="mt-1 block w-full rounded border-gray-300">
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                {{ (old('distribution_category_id') ?? ($distribution->distribution_category_id ?? '')) == $category->id ? 'selected' : '' }}>
                {{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-4">
    <label for="arrive_date" class="block text-gray-700">تاريخ التوريد:</label>
    <input type="date" id="arrive_date" name="arrive_date"
        value="{{ old('arrive_date', $distribution->arrive_date ?? '') }}" 
        class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="quantity" class="block text-gray-700">الكمية:</label>
    <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $distribution->quantity ?? '') }}"
         class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="target" class="block text-gray-700">نوع المستفيدين:</label>
    <input type="text" id="target" name="target" value="{{ old('target', $distribution->target ?? '') }}"
         class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="source" class="block text-gray-700">المصدر:</label>
    <input type="text" id="source" name="source" value="{{ old('source', $distribution->source ?? '') }}"
         class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="done" class="block text-gray-700">اكتمال:</label>
    <select id="done" name="done"  class="mt-1 block w-full rounded border-gray-300">
        <option value="1" {{ (old('done') ?? ($distribution->done ?? '')) == '1' ? 'selected' : '' }}>مكتمل</option>
        <option value="0" {{ (old('done') ?? ($distribution->done ?? '')) == '0' ? 'selected' : '' }}>غير مكتمل
        </option>
    </select>
</div>
<div class="mb-4">
    <label for="target_count" class="block text-gray-700">عدد المستهدفين:</label>
    <input type="number" id="target_count" name="target_count"
        value="{{ old('target_count', $distribution->target_count ?? '') }}" 
        class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="expectation" class="block text-gray-700">عدد المتوقعين:</label>
    <input type="text" id="expectation" name="expectation"
        value="{{ old('expectation', $distribution->expectation ?? '') }}" 
        class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="min_count" class="block text-gray-700">اقل عدد للاسرة:</label>
    <input type="number" id="min_count" name="min_count"
        value="{{ old('min_count', $distribution->min_count ?? '') }}" 
        class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="max_count" class="block text-gray-700">اقصى عدد للاسرة:</label>
    <input type="number" id="max_count" name="max_count"
        value="{{ old('max_count', $distribution->max_count ?? '') }}" 
        class="mt-1 block w-full rounded border-gray-300">
</div>
<div class="mb-4">
    <label for="note" class="block text-gray-700">ملاحظة:</label>
    <textarea id="note" name="note" class="mt-1 block w-full rounded border-gray-300">{{ old('note', $distribution->note ?? '') }}</textarea>
</div>
