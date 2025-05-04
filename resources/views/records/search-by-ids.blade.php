@extends('dashboard')
@section('title', "بحث عن عن طريق الهوية")
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>البحث عن المواطنين بواسطة الأرقام</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('search.by.ids') }}" method="post" class="mt-4">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="ids" class="form-label">أرقام المواطنين (رقم في كل سطر)</label>
                                <textarea class="form-control" id="ids" name="ids" rows="5" placeholder="أدخل أرقام المواطنين (رقم واحد لكل سطر)"></textarea>
                            </div>
                        </div>
        <button type="submit" class="btn btn-primary">بحث</button>
        @if(isset($results))
        @php
            $ids = $results->pluck('CI_ID_NUM')->implode(',');
        @endphp
        <a href="{{ route('search.export', ['ids' => $ids]) }}" class="btn btn-success">تصدير</a>
        @endif
    </form>

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
                                                    <td>{{ !empty($citizen->getWife()) ? $citizen->getWife()->fullName() :"0" }}</td>
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
                                    <p>لم يتم العثور على نتائج.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
