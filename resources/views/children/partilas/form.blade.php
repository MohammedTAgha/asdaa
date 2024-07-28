<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-4">{{ isset($child) ? 'Edit' : 'Create' }} Child</h2>
        <form action="{{ isset($child) ? route('children.update', $child->id) : route('children.store') }}" method="POST">
            @csrf
            @if(isset($child))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">الاسم:</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $child->name ?? '') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">تاريخ الميلاد:</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $child->date_of_birth ?? '') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">الجنس:</label>
                    <select name="gender" id="gender" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="male" {{ old('gender', $child->gender ?? '') === 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ old('gender', $child->gender ?? '') === 'female' ? 'selected' : '' }}>انثى</option>
                    </select>
                </div>
                <div>
                    <label for="citizen_id" class="block text-sm font-medium text-gray-700">الاب:</label>
                    <select name="citizen_id" id="citizen_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach($citizens as $citizen)
                            <option value="{{ $citizen->id }}" {{ old('citizen_id', $child->citizen_id ?? '') == $citizen->id ? 'selected' : '' }}>{{ $citizen->firstname . " " .  $citizen->secondname . ' ' .$citizen->thirdname. ' ' .$citizen->lastname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="orphan" id="orphan" {{ old('orphan', $child->orphan ?? false) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label for="orphan" class="ml-2 block text-sm text-gray-900">يتيم</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="infant" id="infant" {{ old('infant', $child->infant ?? false) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label for="infant" class="ml-2 block text-sm text-gray-900">رضيع</label>
                </div>
                <div>
                    <label for="bambers_size" class="block text-sm font-medium text-gray-700">حجم الحفاات:</label>
                    <input type="text" name="bambers_size" id="bambers_size" value="{{ old('bambers_size', $child->bambers_size ?? '') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="disease" id="disease" {{ old('disease', $child->disease ?? false) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label for="disease" class="ml-2 block text-sm text-gray-900">يوجد مرض</label>
                </div>
                <div>
                    <label for="disease_description" class="block text-sm font-medium text-gray-700">وصف المرض:</label>
                    <input type="text" name="disease_description" id="disease_description" value="{{ old('disease_description', $child->disease_description ?? '') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="obstruction" id="obstruction" {{ old('obstruction', $child->obstruction ?? false) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label for="obstruction" class="ml-2 block text-sm text-gray-900">يوجد اعاقة</label>
                </div>
                <div>
                    <label for="obstruction_description" class="block text-sm font-medium text-gray-700">وصف الاعاقة:</label>
                    <input type="text" name="obstruction_description" id="obstruction_description" value="{{ old('obstruction_description', $child->obstruction_description ?? '') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="md:col-span-2">
                    <label for="note" class="block text-sm font-medium text-gray-700">ملاحظة:</label>
                    <textarea name="note" id="note" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('note', $child->note ?? '') }}</textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ isset($child) ? 'تحديث' : 'اضافة طفل' }}</button>
                <a href="{{ route('children.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">رجوع</a>

            </div>
        </form>
    </div>
</div>