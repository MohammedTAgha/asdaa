@extends('dashboard')
@section('title', "تعديل مندوب")

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold mb-4">تعديل مندوب</h1>
        <form action="{{ route('representatives.update', $representative->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="id" class="block text-gray-700">الهوية:</label>
                <input type="number" name="id" id="id" value="{{ $representative->id }}" class="w-full px-4 py-2 border rounded-md" required readonly>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700">الاسم:</label>
                <input type="text" name="name" id="name" value="{{ $representative->name }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>
            <div class="mb-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_big_region_representative" id="is_big_region_representative" 
                           class="mr-2" value="1" {{ $representative->is_big_region_representative ? 'checked' : '' }}
                           {{ $representative->managedBigRegion()->exists() ? 'disabled' : '' }}>
                    <label for="is_big_region_representative" class="text-gray-700">مندوب منطقة كبيرة</label>
                    @if($representative->managedBigRegion()->exists())
                        <span class="text-sm text-red-500 ml-2">(يدير منطقة كبيرة حالياً)</span>
                    @endif
                </div>
            </div>

            {{-- Regular Region Selection --}}
            <div class="mb-4" id="region-select" style="{{ $representative->is_big_region_representative ? 'display: none;' : '' }}">
                <label for="region_id" class="block text-gray-700">المنطقة:</label>
                <select name="region_id" id="region_id" class="w-full px-4 py-2 border rounded-md">
                    <option value="">اختر منطقة</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}" {{ $representative->region_id == $region->id ? 'selected' : '' }}>
                            {{ $region->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Big Region Selection --}}
            <div class="mb-4" id="big-region-select" style="{{ !$representative->is_big_region_representative ? 'display: none;' : '' }}">
                <label for="big_region_id" class="block text-gray-700">المنطقة الكبيرة:</label>
                <select name="big_region_id" id="big_region_id" class="w-full px-4 py-2 border rounded-md"
                        {{ $representative->managedBigRegion()->exists() ? '' : 'disabled' }}>
                    <option value="">اختر منطقة كبيرة</option>
                    @foreach ($bigRegions as $bigRegion)
                        <option value="{{ $bigRegion->id }}" 
                            {{ $representative->managedBigRegion && $representative->managedBigRegion->id == $bigRegion->id ? 'selected' : '' }}>
                            {{ $bigRegion->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700">رقم الهاتف:</label>
                <input type="text" name="phone" id="phone" value="{{ $representative->phone }}" class="w-full px-4 py-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700">العنوان:</label>
                <input type="text" name="address" id="address" value="{{ $representative->address }}" class="w-full px-4 py-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="note" class="block text-gray-700">ملاحظة:</label>
                <textarea name="note" id="note" class="w-full px-4 py-2 border rounded-md">{{ $representative->note }}</textarea>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">تحديث</button>
                <a href="{{ route('representatives.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded ml-2 hover:bg-gray-600">الغاء</a>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.getElementById('is_big_region_representative').addEventListener('change', function() {
            const regionSelect = document.getElementById('region-select');
            const bigRegionSelect = document.getElementById('big-region-select');
            const bigRegionSelectInput = document.getElementById('big_region_id');
            
            if (this.checked) {
                regionSelect.style.display = 'none';
                bigRegionSelect.style.display = 'block';
                bigRegionSelectInput.disabled = false;
                document.getElementById('region_id').value = '';
            } else {
                regionSelect.style.display = 'block';
                bigRegionSelect.style.display = 'none';
                bigRegionSelectInput.disabled = true;
                bigRegionSelectInput.value = '';
            }
        });
    </script>
    @endpush
@endsection
