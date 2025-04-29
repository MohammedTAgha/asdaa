@extends('dashboard')
@section('title', "انشاء مندوب")

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold mb-4">انشاء مندوب</h1>
        <form action="{{ route('representatives.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="id" class="block text-gray-700">الهوية:</label>
                <input type="number" name="id" id="id" 
                       class="w-full px-4 py-2 border rounded-md @error('id') border-red-500 @enderror" 
                       value="{{ old('id') }}" required>
                @error('id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700">الاسم:</label>
                <input type="text" name="name" id="name" 
                       class="w-full px-4 py-2 border rounded-md @error('name') border-red-500 @enderror" 
                       value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_big_region_representative" id="is_big_region_representative" 
                           class="mr-2" value="1" {{ old('is_big_region_representative') ? 'checked' : '' }}>
                    <label for="is_big_region_representative" class="text-gray-700">مندوب منطقة كبيرة</label>
                </div>
            </div>
            
            {{-- Regular Region Selection --}}
            <div class="mb-4" id="region-select" style="{{ old('is_big_region_representative') ? 'display: none;' : '' }}">
                <label for="region_id" class="block text-gray-700">المنطقة:</label>
                <select name="region_id" id="region_id" 
                        class="w-full px-4 py-2 border rounded-md @error('region_id') border-red-500 @enderror">
                    <option value="">اختر منطقة</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                            {{ $region->name }}
                        </option>
                    @endforeach
                </select>
                @error('region_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- Big Region Selection --}}
            <div class="mb-4" id="big-region-select" style="{{ !old('is_big_region_representative') ? 'display: none;' : '' }}">
                <label for="big_region_id" class="block text-gray-700">المنطقة الكبيرة:</label>
                <select name="big_region_id" id="big_region_id" 
                        class="w-full px-4 py-2 border rounded-md @error('big_region_id') border-red-500 @enderror">
                    <option value="">اختر منطقة كبيرة</option>
                    @foreach ($bigRegions as $bigRegion)
                        <option value="{{ $bigRegion->id }}" {{ old('big_region_id') == $bigRegion->id ? 'selected' : '' }}>
                            {{ $bigRegion->name }}
                        </option>
                    @endforeach
                </select>
                @error('big_region_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700">رقم الهاتف:</label>
                <input type="text" name="phone" id="phone" 
                       class="w-full px-4 py-2 border rounded-md @error('phone') border-red-500 @enderror" 
                       value="{{ old('phone') }}">
                @error('phone')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700">العنوان:</label>
                <input type="text" name="address" id="address" 
                       class="w-full px-4 py-2 border rounded-md @error('address') border-red-500 @enderror" 
                       value="{{ old('address') }}">
                @error('address')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="note" class="block text-gray-700">ملاحظة:</label>
                <textarea name="note" id="note" 
                          class="w-full px-4 py-2 border rounded-md @error('note') border-red-500 @enderror">{{ old('note') }}</textarea>
                @error('note')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">انشاء</button>
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
            
            if (this.checked) {
                regionSelect.style.display = 'none';
                bigRegionSelect.style.display = 'block';
                document.getElementById('region_id').value = '';
            } else {
                regionSelect.style.display = 'block';
                bigRegionSelect.style.display = 'none';
                document.getElementById('big_region_id').value = '';
            }
        });

        // Check for any validation errors and show them
        @if($errors->any())
            const hasErrors = {!! json_encode($errors->toArray()) !!};
            const isBigRegion = document.getElementById('is_big_region_representative').checked;
            
            if (hasErrors.region_id && !isBigRegion) {
                document.getElementById('region-select').style.display = 'block';
                document.getElementById('big-region-select').style.display = 'none';
            }
            
            if (hasErrors.big_region_id && isBigRegion) {
                document.getElementById('region-select').style.display = 'none';
                document.getElementById('big-region-select').style.display = 'block';
            }
        @endif
    </script>
    @endpush
@endsection
