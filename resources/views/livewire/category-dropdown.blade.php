<div>
    <div class="mb-3">
        <label for="distribution_category_id" class="form-label">الفئة:</label>
        <select id="distribution_category_id" name="distribution_category_id" wire:model="selectedCategory" required class="form-select">
            <option value="">اختر الفئة</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
            <option value="add_new">إضافة فئة جديدة</option>
        </select>
    </div>

    @if ($showNewCategoryInput)
        <div class="mb-3">
            <label for="newCategory" class="form-label">اسم الفئة الجديدة:</label>
            <input type="text" id="newCategory" wire:model="newCategory" class="form-control">
        </div>
        <button type="button" wire:click="addCategory" class="btn btn-primary">إضافة الفئة</button>
    @endif
</div>
