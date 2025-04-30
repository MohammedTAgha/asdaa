@extends('dashboard')
@section('title', 'إضافة مندوب جديد')

@section('content')
<div class="container mx-auto py-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold mb-6">إضافة مندوب جديد</h1>

            @if($errors->any())
                <div class="bg-red-50 p-4 rounded-lg mb-6">
                    <ul class="list-disc list-inside text-red-500">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('representatives.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            الرقم التعريفي
                        </label>
                        <input type="text" name="id" value="{{ old('id') }}"
                               class="w-full px-4 py-2 border rounded-md @error('id') border-red-500 @enderror"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            الاسم
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full px-4 py-2 border rounded-md @error('name') border-red-500 @enderror"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            رقم الهاتف
                        </label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="w-full px-4 py-2 border rounded-md @error('phone') border-red-500 @enderror">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            العنوان
                        </label>
                        <input type="text" name="address" value="{{ old('address') }}"
                               class="w-full px-4 py-2 border rounded-md @error('address') border-red-500 @enderror">
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_big_region_representative" 
                                   class="form-checkbox h-5 w-5 text-blue-600"
                                   @if(old('is_big_region_representative')) checked @endif
                                   onchange="toggleRepresentativeType(this)">
                            <span class="ml-2 text-gray-700">مندوب منطقة كبيرة</span>
                        </label>
                    </div>

                    <div id="region-select" class="mb-4 {{ old('is_big_region_representative') ? 'hidden' : '' }}">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            المنطقة
                        </label>
                        <select name="region_id" 
                                class="w-full px-4 py-2 border rounded-md @error('region_id') border-red-500 @enderror">
                            <option value="">اختر المنطقة</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" 
                                    {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="big-region-select" class="mb-4 {{ !old('is_big_region_representative') ? 'hidden' : '' }}">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            المنطقة الكبيرة
                        </label>
                        <select name="big_region_id" 
                                class="w-full px-4 py-2 border rounded-md @error('big_region_id') border-red-500 @enderror">
                            <option value="">اختر المنطقة الكبيرة</option>
                            @foreach($bigRegions as $bigRegion)
                                <option value="{{ $bigRegion->id }}" 
                                    {{ old('big_region_id') == $bigRegion->id ? 'selected' : '' }}>
                                    {{ $bigRegion->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        ملاحظات
                    </label>
                    <textarea name="note" rows="3" 
                              class="w-full px-4 py-2 border rounded-md @error('note') border-red-500 @enderror">{{ old('note') }}</textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">
                        حفظ
                    </button>
                    <a href="{{ route('representatives.index') }}" 
                       class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400">
                        إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleRepresentativeType(checkbox) {
    const regionSelect = document.getElementById('region-select');
    const bigRegionSelect = document.getElementById('big-region-select');
    
    if (checkbox.checked) {
        regionSelect.classList.add('hidden');
        bigRegionSelect.classList.remove('hidden');
    } else {
        regionSelect.classList.remove('hidden');
        bigRegionSelect.classList.add('hidden');
    }
}
</script>
@endpush
@endsection
