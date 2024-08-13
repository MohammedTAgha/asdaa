@extends('dashboard')
@section('content')
    <div class="container mx-auto px-1">
        <h1 class="text-2xl font-bold my-4">الكشوفات</h1>
        <a href="{{ route('distributions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">اضافة كشف</a>
        <ul class="mt-4">
            <div class="table-responsive">
                <table class="table table-hover" >
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">رقم</th>
                            <th class="w-2/7 py-3 px-4 uppercase font-semibold text-sm">الوصف</th>
                            <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">الفئة</th>
                            <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">المزود</th>
                            <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">الكمية</th>
                            <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">اكتمل</th>
                            <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">خيارات</th>

                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($distributions as $distribution)
                            <tr>
                                <td class="w-1/7 py-3 px-4">
                                    <a href="{{ route('distributions.show', $distribution->id) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $distribution->id }}
                                    </a>
                                </td>

                                <td class="w-2/7 py-3 px-4">
                                    <a href="{{ route('distributions.show', $distribution->id) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $distribution->name }}
                                    </a>
                                </td>

                                <td class="w-1/7 py-3 px-4">{{ $distribution->name }}</td>
                                <td class="w-1/7 py-3 px-4">{{ $distribution->source }}</td>
                                <td class="w-1/7 py-3 px-4">{{ $distribution->quantity }}</td>
                                <td class="w-1/7 py-3 px-4">{{ $distribution->done }}</td>
                                <td class="w-1/7 py-3 px-4">
                                    <a href="{{ route('distributions.show', $distribution->id) }}">
                                        عرض
                                    </a>
                                    <a href="{{ route('distributions.edit', $distribution->id) }}">
                                        تحرير
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </ul>
    </div>
@endsection
