@extends('dashboard')

@section('content')
    <div class="container mx-auto px-1">

        <div class="card px-4 py-4">
            <div class="col">
                <span class="h3">المشاريع</span>
                <span class="my-3">|</span>
                <a href="{{ route('distributions.create') }}" class="btn btn-primary waves-effect">
                    مشروع جديد
                    <span class="ti-xs ti ti-plus me-1"></span>
                </a>
            </div>
            <div class="table-responsive text-nowrap mt-3">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>رقم</th>
                            <th>الوصف</th>
                            <th>الفئة</th>
                            <th>المزود</th>
                            <th>الكمية</th>
                            <th>اكتمل</th>
                            <th>خيارات</th>

                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach ($distributions as $distribution)
                            <tr class="py-2">
                                <td>
                                    <a href="{{ route('distributions.show', $distribution->id) }}">
                                        {{ $distribution->id }}
                                    </a>
                                </td>

                                <td>
                                    <a href="{{ route('distributions.show', $distribution->id) }}">
                                        {{ $distribution->name }}
                                    </a>
                                </td>

                                <td>{{ $distribution->name }}</td>
                                <td>{{ $distribution->source }}</td>
                                <td>{{ $distribution->quantity }}</td>
                                <td>{{ $distribution->done }}</td>
                                <td>
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
        </div>
        {{-- <div class="mt-4">
            <div class="table-responsive">
                <table class="table table-hover">
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
                                    <a href="{{ route('distributions.show', $distribution->id) }}">
                                        {{ $distribution->id }}
                                    </a>
                                </td>

                                <td class="w-2/7 py-3 px-4">
                                    <a href="{{ route('distributions.show', $distribution->id) }}">
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
        </div> --}}
    </div>
@endsection
