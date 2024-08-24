@extends('dashboard')
@section('title', "مناديب المناطق")

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold mb-4"> مناديب المناطق</h1>
        <a href="{{ route('representatives.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded"> اضافة مندوب جديد </a>
        <div class="mt-6">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/5 py-3 px-4 uppercase font-semibold text-sm">الاسم</th>
                        <th class="w-1/5 py-3 px-4 uppercase font-semibold text-sm">المنطقة</th>
                        <th class="w-1/5 py-3 px-4 uppercase font-semibold text-sm">رقم</th>
                        <th class="w-1/5 py-3 px-4 uppercase font-semibold text-sm">عدد السكان</th>
                        <th class="w-1/5 py-3 px-4 uppercase font-semibold text-sm">اجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($representatives as $representative)
                        <tr>

                            <td class="w-1/5 py-3 px-4">
                                <a href="{{ route('representatives.show', $representative->id) }}">
                                    {{ $representative->name }}
                                </a>
                            </td>

                            <td class="w-1/5 py-3 px-4">
                                <a href="{{ route('regions.show', $representative->region->id ?? 0 ) }}">
                                {{ $representative->region->name ??'N/A'  }} - {{ $representative->region->id ??'**'  }}
                            
                            </td>
                            
                            <td class="w-1/5 py-3 px-4">{{ $representative->phone }}</td>
                            <td class="w-1/5 py-3 px-4">{{  count($representative->region->citizens) }} اسرة</td>
                            {{-- <td class="w-1/5 py-3 px-4">{{ $representative->address }}</td> --}}
                            <td class="w-1/5 py-3 px-4">
                                <a href="{{ route('representatives.show', $representative->id) }}"
                                    class="text-blue-500">عرض</a>
                                <a href="{{ route('representatives.edit', $representative->id) }}"
                                    class="text-green-500 ml-2">تعديل</a>
                                {{-- <form action="{{ route('representatives.destroy', $representative->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 ml-2">الغاء</button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
