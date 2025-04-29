@extends('dashboard')
@section('title', 'المندوبين')

@section('content')
    <div class="container mx-auto py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">المندوبين</h1>
            <a href="{{ route('representatives.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                اضافة مندوب جديد
            </a>
        </div>

        <div class="bg-white shadow-md rounded my-6">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-right">الهوية</th>
                        <th class="py-3 px-6 text-right">الاسم</th>
                        <th class="py-3 px-6 text-right">نوع المندوب</th>
                        <th class="py-3 px-6 text-right">المنطقة</th>
                        <th class="py-3 px-6 text-right">رقم الهاتف</th>
                        <th class="py-3 px-6 text-right">العنوان</th>
                        <th class="py-3 px-6 text-right">ملاحظة</th>
                        <th class="py-3 px-6 text-center">الاجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($representatives as $representative)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-right">{{ $representative->id }}</td>
                        <td class="py-3 px-6 text-right">{{ $representative->name }}</td>
                        <td class="py-3 px-6 text-right">
                            @if($representative->is_big_region_representative)
                                <span class="bg-purple-200 text-purple-600 py-1 px-3 rounded-full text-xs">
                                    مندوب منطقة كبيرة
                                    @if($representative->managedBigRegion)
                                        ({{ $representative->managedBigRegion->name }})
                                    @endif
                                </span>
                            @else
                                <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">
                                    مندوب منطقة
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-right">
                            @if(!$representative->is_big_region_representative)
                                {{ $representative->region ? $representative->region->name : '-' }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="py-3 px-6 text-right">{{ $representative->phone ?? '-' }}</td>
                        <td class="py-3 px-6 text-right">{{ $representative->address ?? '-' }}</td>
                        <td class="py-3 px-6 text-right">{{ $representative->note ?? '-' }}</td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('representatives.edit', $representative->id) }}" 
                                   class="bg-blue-500 text-white rounded-lg px-3 py-1 mx-1">
                                    تعديل
                                </a>
                                <form action="{{ route('representatives.destroy', $representative->id) }}" 
                                      method="POST" class="inline"
                                      onsubmit="return confirm('هل انت متأكد من حذف هذا المندوب؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white rounded-lg px-3 py-1 mx-1">
                                        حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
