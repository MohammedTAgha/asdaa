{{-- 
This is a new component file to render distribution cards.
It receives a $distribution variable.
--}}
<div class="bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
    {{-- Project Header --}}
    <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ $distribution->name }}</h3>
                <p class="text-sm text-gray-600 mt-1">
                    <i class="fas fa-tag ml-1"></i>
                    {{ $distribution->category?->name ?? 'غير مصنف' }}
                </p>
            </div>
            <div class="flex space-x-2 rtl:space-x-reverse">
                <a href="{{ route('distributions.show', $distribution->id) }}"
                   class="text-blue-600 hover:text-blue-800 p-1"
                   title="عرض">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('distributions.edit', $distribution->id) }}"
                   class="text-yellow-600 hover:text-yellow-800 p-1"
                   title="تعديل">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="{{ route('distributions.export', $distribution->id) }}"
                   class="text-green-600 hover:text-green-800 p-1"
                   title="تنزيل">
                    <i class="fas fa-download"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Project Stats --}}
    <div class="p-4">
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center">
                <span class="text-sm text-gray-500">المستفيدين</span>
                <p class="text-xl font-bold text-gray-800">{{ $distribution->citizens()->count() }}</p>
            </div>
            <div class="text-center">
                <span class="text-sm text-gray-500">الكمية</span>
                <p class="text-xl font-bold text-gray-800">{{ $distribution->quantity ?? 0 }}</p>
            </div>
        </div>

        {{-- Progress Bar --}}
        <div class="mt-4">
            @php
                $completedCount = $distribution->citizens()->wherePivot('done', true)->count();
                $totalCount = $distribution->citizens()->count();
                $percentage = $totalCount > 0 ? ($completedCount / $totalCount) * 100 : 0;
            @endphp
            <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>تقدم التوزيع</span>
                <span>{{ number_format($percentage, 1) }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-green-600 h-2 rounded-full transition-all duration-300"
                     style="width: {{ $percentage }}%">
                </div>
            </div>
        </div>
    </div>

    {{-- Project Footer --}}
    <div class="px-4 py-3 bg-gray-50 border-t flex justify-between items-center text-sm">
        <span class="text-gray-600">
            <i class="fas fa-calendar-alt ml-1"></i>
            {{ $distribution->date ? \Carbon\Carbon::parse($distribution->date)->format('Y/m/d') : 'غير محدد' }}
        </span>
        <span class="text-gray-600">
            <i class="fas fa-building ml-1"></i>
            {{ $distribution->source?->name ?? $distribution->source ?? 'غير محدد' }}
        </span>
    </div>
</div>