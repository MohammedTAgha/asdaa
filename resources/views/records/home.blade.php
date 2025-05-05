@extends('dashboard')
@section('title', "نظام السجل المدني")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>بحث عن مواطن</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('records.search') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="searchFirstName" class="form-label">الاسم الاول</label>
                                <input type="text" class="form-control" id="searchFirstName" name="first_name" placeholder="الاسم الاول">
                            </div>
                            <div class="col">
                                <label for="searchFatherName" class="form-label">اسم الاب</label>
                                <input type="text" class="form-control" id="searchFatherName" name="father_name" placeholder="اسم الأب">
                            </div>
                            <div class="col">
                                <label for="searchGrandfatherName" class="form-label">اسم الجد</label>
                                <input type="text" class="form-control" id="searchGrandfatherName" name="grandfather_name" placeholder="اسم الجد">
                            </div>
                            <div class="col">
                                <label for="searchFamilyName" class="form-label">اسم العائلة</label>
                                <input type="text" class="form-control" id="searchFamilyName" name="family_name" placeholder="اسم العائلة">
                            </div>
                            <div class="col">
                                <label for="searchIDNumber" class="form-label">رقم الهوية</label>
                                <input type="text" class="form-control" id="searchIDNumber" name="id_number" placeholder="رقم الهوية">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">بحث</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(isset($results))
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>نتائج البحث</h3>
                </div>
                <div class="card-body">
                    @if(count($results) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered shadow-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>رقم الهوية</th>
                                    <th>الاسم</th>
                                    <th>العمر</th>
                                    <th>تفاصيل</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $citizen)
                                    <tr>
                                        <td>{{ $citizen->CI_ID_NUM }}</td>
                                        <td>{{ $citizen->full_name }}</td>
                                        <td>{{ $citizen->age }}</td>
                                        <td>
                                            <a href="{{ route('citizen.details', $citizen->CI_ID_NUM) }}" class="btn btn-info btn-sm">عرض التفاصيل</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p>لم يتم العثور على نتائج.</p>
                    @endif
                    @if(isset($executionTime))
                        <p>وقت تنفيذ البحث: {{ $executionTime }} ms</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@if(isset($results))
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>نتائج البحث</h3>
                </div>
                <div class="card-body">
                    @if(count($results) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered shadow-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Citizen ID</th>
                                    <th>Name</th>
                                    <th>الاسم الاول</th>
                                    <th>الاب</th>
                                    <th>الجد</th>
                                    <th>العائلة</th>
                                    <th>الحالة</th>
                                    <th>هوية الزوجة</th>
                                    <th>اسم الزوجة</th>
                                    <th>المدينة </th>
                                    <th>العنوان </th>
                                    <th>الميلاد </th>
                                    <th>الجنس</th>
                                    <th>Age</th>
                                    <th>الوفاة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $citizen)
                                <tr>
                                    <td>{{ $citizen->CI_ID_NUM }}</td>
                                    <td>{{ $citizen->CI_FIRST_ARB }} {{ $citizen->CI_FATHER_ARB }} {{ $citizen->CI_GRAND_FATHER_ARB }} {{ $citizen->CI_FAMILY_ARB }}</td>
                                    <td>{{ $citizen->CI_FIRST_ARB }}</td>
                                    <td>{{ $citizen->CI_FATHER_ARB }}</td>
                                    <td> {{ $citizen->CI_GRAND_FATHER_ARB }}</td>
                                    <td>{{ $citizen->CI_FAMILY_ARB }}</td>

                                    <td>{{ $citizen->CI_PERSONAL_CD }}</td>
                                    <td>{{ !empty($citizen->getWife()) ? $citizen->getWife()->CI_ID_NUM :"0" }}</td>
                                    <td>{{ !empty($citizen->getWife()) ? $citizen->getWife()->full_name :"0" }}</td>
                                    <td>{{ $citizen->CITTTTY }}</td>
                                    <td>{{ $citizen->CITY }}</td>
                                    <td>{{ $citizen->CI_BIRTH_DT }}</td>
                                    <td>{{ $citizen->CI_SEX_CD }}</td>
                                    
                                    <td>{{ $citizen->age }}</td>
                                    <td>{{ $citizen->CI_DEAD_DT }}</td>

                                    {{-- <td>
                                        <a href="{{ route('citizen.details', $citizen->CI_ID_NUM) }}" class="btn btn-info btn-sm">View Details</a>
                                    </td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                    </div>
                    @else
                    <p>No results found.</p>
                    @endif
                    @if(isset($executionTime))
                        <p>Search execution time: {{ $executionTime }} ms</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
