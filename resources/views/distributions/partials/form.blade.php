<div class="container">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">الوصف:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $distribution->name ?? '') }}"
                required class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label for="date" class="form-label">تاريخ التسليم:</label>
            <input type="date" id="date" name="date" value="{{ old('date', $distribution->date ?? '') }}"
                required class="form-control">
        </div>
    </div>

    <div class="row">
        {{-- <div class="col-md-6 mb-3">
                <label for="distribution_category_id" class="form-label">الفئة:</label>
                <select id="distribution_category_id" name="distribution_category_id" required class="form-select">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ (old('distribution_category_id') ?? ($distribution->distribution_category_id ?? '')) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div> --}}
            @livewire('category-dropdown', ['selectedCategory' => $distribution->distribution_category_id ?? null])        <div class="col-md-6 mb-3">
            <label for="arrive_date" class="form-label">تاريخ التوريد:</label>
            <input type="date" id="arrive_date" name="arrive_date"
                value="{{ old('arrive_date', $distribution->arrive_date ?? '') }}" class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="quantity" class="form-label">الكمية:</label>
            <input type="number" id="quantity" name="quantity"
                value="{{ old('quantity', $distribution->quantity ?? '') }}" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label for="target" class="form-label">نوع المستفيدين:</label>
            <input type="text" id="target" name="target" value="{{ old('target', $distribution->target ?? '') }}"
                class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="source" class="form-label">المصدر:</label>
            <input type="text" id="source" name="source" value="{{ old('source', $distribution->source ?? '') }}"
                class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label for="done" class="form-label">اكتمال:</label>
            <select id="done" name="done" class="form-select">
                <option value="1" {{ (old('done') ?? ($distribution->done ?? '')) == '1' ? 'selected' : '' }}>مكتمل
                </option>
                <option value="0" {{ (old('done') ?? ($distribution->done ?? '')) == '0' ? 'selected' : '' }}>غير
                    مكتمل</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="target_count" class="form-label">عدد المستهدفين:</label>
            <input type="number" id="target_count" name="target_count"
                value="{{ old('target_count', $distribution->target_count ?? '') }}" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label for="expectation" class="form-label">عدد المتوقعين:</label>
            <input type="text" id="expectation" name="expectation"
                value="{{ old('expectation', $distribution->expectation ?? '') }}" class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="min_count" class="form-label">اقل عدد للاسرة:</label>
            <input type="number" id="min_count" name="min_count"
                value="{{ old('min_count', $distribution->min_count ?? '') }}" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label for="max_count" class="form-label">اقصى عدد للاسرة:</label>
            <input type="number" id="max_count" name="max_count"
                value="{{ old('max_count', $distribution->max_count ?? '') }}" class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-3">
            <label for="note" class="form-label">ملاحظة:</label>
            <textarea id="note" name="note" class="form-control">{{ old('note', $distribution->note ?? '') }}</textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
