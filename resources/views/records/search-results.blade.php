@extends('dashboard')
@section('title', "نتائج البحث عن المواطنين")
@section('content')
<div class="container mt-4">
    <h3 class="mb-4">نتائج البحث</h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered shadow-sm">
            <thead class="thead-dark">
                <tr>
                    <th>رقم الهوية</th>
                    <th>الاسم</th>
                    <th>العمر</th>
                    <th>التفاصيل</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $citizen)
                    <tr>
                        <td>{{ $citizen->CI_ID_NUM }}</td>
                        <td>{{ $citizen->CI_FIRST_ARB }} {{ $citizen->CI_FATHER_ARB }} {{ $citizen->CI_GRAND_FATHER_ARB }} {{ $citizen->CI_FAMILY_ARB }}</td>
                        <td>{{ $citizen->age ? $citizen->age . ' سنة' : 'غير متوفر' }}</td>
                        <td>
                            <a href="{{ route('citizen.details', $citizen->CI_ID_NUM) }}" class="btn btn-info btn-sm">عرض التفاصيل</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
