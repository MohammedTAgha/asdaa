<div>
    <div class="mb-3">
        <label for="distribution_category_id" class="form-label">الفئة:</label>
        <select id="distribution_category_id" name="distribution_category_id" 
            wire:model.live="selectedCategory"
            required class="form-select">
            <option value="">اختر الفئة</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
            <option value="add_new">إضافة فئة جديدة</option>
        </select>
        <div class="text-sm text-gray-500 mt-1">
            Current Selection: {{ $selectedCategory ?: 'None' }}
        </div>
    </div>

    @if ($showNewCategoryInput)
        <div class="mb-3">
            <label for="newCategory" class="form-label">اسم الفئة الجديدة:</label>
            <input type="text" name="new_category_name" id="newCategory" wire:model.live="newCategory" class="form-control">
        </div>
        <button type="button" wire:click="addCategory" class="btn btn-primary">إضافة الفئة</button>
    @endif

    <!-- Source Dropdown -->
    <div class="mb-3">
        <label for="source_id" class="form-label">المصدر:</label>
        <select id="source_id" name="source_id" 
            wire:model.live="selectedSource"
            required class="form-select">
            <option value="">اختر المصدر</option>
            @foreach ($sources as $source)
                <option value="{{ $source->id }}">{{ $source->name }}</option>
            @endforeach
            <option value="add_new_source">إضافة مصدر جديد</option>
        </select>
        <div class="text-sm text-gray-500 mt-1">
            Current Selection: {{ $selectedSource ?: 'None' }}
        </div>
    </div>

    @if ($showNewSourceInput)
        <div class="mb-3">
            <label for="newSourceName" class="form-label">اسم المصدر الجديد:</label>
            <input type="text" id="newSourceName" wire:model.live="newSourceName" class="form-control">
        </div>
        <div class="mb-3">
            <label for="newSourcePhone" class="form-label">هاتف المصدر:</label>
            <input type="text" id="newSourcePhone" wire:model.live="newSourcePhone" class="form-control">
        </div>
        <div class="mb-3">
            <label for="newSourceEmail" class="form-label">البريد الإلكتروني للمصدر:</label>
            <input type="email" id="newSourceEmail" wire:model.live="newSourceEmail" class="form-control">
        </div>
        <button type="button" wire:click="addSource" class="btn btn-primary">إضافة المصدر</button>
    @endif
</div>
