@extends('dashboard')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-4xl font-bold mb-4">المناطق</h1>
        <a href="{{ route('regions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create New Region</a>
        <div class="mt-6">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class=" py-3 px-4 uppercase font-semibold text-sm">المنطقة</th>
                        <th class=" py-3 px-4 uppercase font-semibold text-sm">اسم المندوب</th>
                        <th class=" py-3 px-4 uppercase font-semibold text-sm">عدد السكان</th>
                        <th class=" py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($regions as $region)
                        <tr>
                            
                            <td class=" py-3 px-4">
                                <a href="{{route('regions.show',$region->id)}}">
                                     {{ $region->name }}
                                </a>
                            </td>
                            <td class=" py-3 px-4">
                                
                                 {{ $region->representatives->first()->name ??'N/A' }}
                                
                            </td>
                            <td class=" py-3 px-4">{{ $region->citizens->count() }}</td>
                            <td class=" py-3 px-4">
                                <a href="{{ route('regions.show', $region->id) }}" class="text-blue-500">عرض</a>
                                <a href="{{ route('regions.edit', $region->id) }}" class="text-green-500 ml-2">تحرير</a>
                                <form action="{{ route('regions.destroy', $region->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 ml-2">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
