@extends('dashboard')
@section('title', 'تعديل المندوب')

@section('content')
<div class="container mx-auto py-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">تعديل المندوب: {{ $representative->name }}</h1>
                <a href="{{ route('representatives.index') }}" 
                   class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>

            @if($errors->any())
                <div class="bg-red-50 p-4 rounded-lg mb-6">
                    <ul class="list-disc list-inside text-red-500">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('representatives.update', $representative) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            الرقم التعريفي
                        </label>
                        <input type="text" name="id" value="{{ old('id', $representative->id) }}"
                               class="w-full px-4 py-2 border rounded-md @error('id') border-red-500 @enderror bg-gray-100"
                               readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            الاسم
                        </label>
                        <input type="text" name="name" value="{{ old('name', $representative->name) }}"
                               class="w-full px-4 py-2 border rounded-md @error('name') border-red-500 @enderror"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            رقم الهاتف
                        </label>
                        <input type="text" name="phone" value="{{ old('phone', $representative->phone) }}"
                               class="w-full px-4 py-2 border rounded-md @error('phone') border-red-500 @enderror">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            العنوان
                        </label>
                        <input type="text" name="address" value="{{ old('address', $representative->address) }}"
                               class="w-full px-4 py-2 border rounded-md @error('address') border-red-500 @enderror">
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_big_region_representative" 
                                   class="form-checkbox h-5 w-5 text-blue-600"
                                   @if(old('is_big_region_representative', $representative->is_big_region_representative)) checked @endif
                                   onchange="toggleRepresentativeType(this)"
                                   @if($representative->managedBigRegion) disabled @endif>
                            <span class="ml-2 text-gray-700">مندوب منطقة كبيرة</span>
                            @if($representative->managedBigRegion)
                                <span class="text-sm text-gray-500 ml-2">(لا يمكن تغيير النوع أثناء إدارة منطقة كبيرة)</span>
                            @endif
                        </label>
                    </div>

                    <div id="region-select" class="mb-4 {{ $representative->is_big_region_representative ? 'hidden' : '' }}">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            المنطقة
                        </label>
                        <select name="region_id" 
                                class="w-full px-4 py-2 border rounded-md @error('region_id') border-red-500 @enderror">
                            <option value="">اختر المنطقة</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" 
                                    {{ old('region_id', $representative->region_id) == $region->id ? 'selected' : '' }}>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="big-region-select" class="mb-4 {{ !$representative->is_big_region_representative ? 'hidden' : '' }}">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            المنطقة الكبيرة
                        </label>
                        <select name="big_region_id" 
                                class="w-full px-4 py-2 border rounded-md @error('big_region_id') border-red-500 @enderror">
                            <option value="">اختر المنطقة الكبيرة</option>
                            @foreach($bigRegions as $bigRegion)
                                <option value="{{ $bigRegion->id }}" 
                                    {{ old('big_region_id', optional($representative->managedBigRegion)->id) == $bigRegion->id ? 'selected' : '' }}>
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
                              class="w-full px-4 py-2 border rounded-md @error('note') border-red-500 @enderror">{{ old('note', $representative->note) }}</textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">
                        حفظ التغييرات
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
    if (checkbox.disabled) return;
    
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
