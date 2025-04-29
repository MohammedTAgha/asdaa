@extends('dashboard')
@section('title', 'اضافة منطقة جديدة')

@section('content')
    <div class="container mx-auto py-6">
        <h1 class="text-3xl font-bold mb-6">اضافة منطقة جديدة</h1>
        <form action="{{ route('regions.store') }}" method="POST">
            @csrf
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        اسم المنطقة
                    </label>
                    <input type="text" name="name" id="name" 
                           class="form-input w-full @error('name') border-red-500 @enderror" 
                           value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="position">
                        الموقع
                    </label>
                    <input type="text" name="position" id="position" 
                           class="form-input w-full @error('position') border-red-500 @enderror" 
                           value="{{ old('position') }}" required>
                    @error('position')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="big_region_id">
                        المنطقة الكبيرة
                    </label>
                    <select name="big_region_id" id="big_region_id" 
                            class="form-select w-full @error('big_region_id') border-red-500 @enderror">
                        <option value="">لا يوجد</option>
                        @foreach($bigRegions as $bigRegion)
                            <option value="{{ $bigRegion->id }}" 
                                {{ old('big_region_id') == $bigRegion->id ? 'selected' : '' }}>
                                {{ $bigRegion->name }} 
                                ({{ $bigRegion->representative ? $bigRegion->representative->name : 'لا يوجد مندوب' }})
                            </option>
                        @endforeach
                    </select>
                    @error('big_region_id')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        مندوبي المنطقة
                    </label>
                    <div class="mt-2 space-y-2">
                        @foreach($representatives as $representative)
                            <div class="flex items-center">
                                <input type="checkbox" name="representative_ids[]" 
                                       id="rep_{{ $representative->id }}"
                                       value="{{ $representative->id }}"
                                       class="form-checkbox h-4 w-4 text-blue-600"
                                       {{ in_array($representative->id, old('representative_ids', [])) ? 'checked' : '' }}>
                                <label for="rep_{{ $representative->id }}" class="mr-2">
                                    {{ $representative->name }}
                                    @if($representative->phone)
                                        <span class="text-gray-500 text-sm">({{ $representative->phone }})</span>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('representative_ids')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="note">
                        ملاحظات
                    </label>
                    <textarea name="note" id="note" rows="3" 
                              class="form-textarea w-full @error('note') border-red-500 @enderror">{{ old('note') }}</textarea>
                    @error('note')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        اضافة
                    </button>
                    <a href="{{ route('regions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        الغاء
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection