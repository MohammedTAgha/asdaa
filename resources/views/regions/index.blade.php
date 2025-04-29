@extends('dashboard')
@section('title', 'المناطق')

@section('content')
    <div class="container mx-auto py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">المناطق</h1>
            <a href="{{ route('regions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                اضافة منطقة جديدة
            </a>
        </div>

        <div class="bg-white shadow-md rounded my-6">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-right">المنطقة</th>
                        <th class="py-3 px-6 text-right">الموقع</th>
                        <th class="py-3 px-6 text-right">المنطقة الكبيرة</th>
                        <th class="py-3 px-6 text-right">مندوب المنطقة الكبيرة</th>
                        <th class="py-3 px-6 text-right">مندوبي المنطقة</th>
                        <th class="py-3 px-6 text-right">عدد المواطنين</th>
                        <th class="py-3 px-6 text-center">الاجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($regions as $region)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-right">{{ $region->name }}</td>
                        <td class="py-3 px-6 text-right">{{ $region->position }}</td>
                        <td class="py-3 px-6 text-right">
                            @if($region->bigRegion)
                                <span class="bg-purple-200 text-purple-600 py-1 px-3 rounded-full text-xs">
                                    {{ $region->bigRegion->name }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-right">
                            @if($region->bigRegion && $region->bigRegion->representative)
                                {{ $region->bigRegion->representative->name }}
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-right">
                            <div class="flex flex-col gap-1">
                                @forelse($region->representatives->where('is_big_region_representative', false) as $representative)
                                    <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">
                                        {{ $representative->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400">-</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="py-3 px-6 text-right">
                            {{ $region->citizens_count ?? $region->citizens->count() }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('regions.show', $region->id) }}" 
                                   class="bg-blue-500 text-white rounded-lg px-3 py-1 mx-1">
                                    عرض
                                </a>
                                <a href="{{ route('regions.edit', $region->id) }}" 
                                   class="bg-yellow-500 text-white rounded-lg px-3 py-1 mx-1">
                                    تعديل
                                </a>
                                @if($region->citizens_count == 0)
                                    <form action="{{ route('regions.destroy', $region->id) }}" 
                                          method="POST" class="inline"
                                          onsubmit="return confirm('هل انت متأكد من حذف هذه المنطقة؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white rounded-lg px-3 py-1 mx-1">
                                            حذف
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
