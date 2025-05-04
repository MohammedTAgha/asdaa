@extends('dashboard')
@section('title', "نتيجة البحث عن المواطن")
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>تفاصيل المواطن</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">الاسم الأول</label>
                            <p class="form-control-plaintext">{{ $citizen->CI_FIRST_ARB }}</p>
                        </div>
                        <div class="col">
                            <label class="form-label">اسم الأب</label>
                            <p class="form-control-plaintext">{{ $citizen->CI_FATHER_ARB }}</p>
                        </div>
                        <div class="col">
                            <label class="form-label">اسم الجد</label>
                            <p class="form-control-plaintext">{{ $citizen->CI_GRAND_FATHER_ARB }}</p>
                        </div>
                        <div class="col">
                            <label class="form-label">اسم العائلة</label>
                            <p class="form-control-plaintext">{{ $citizen->CI_FAMILY_ARB }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">تاريخ الميلاد</label>
                            <p class="form-control-plaintext">{{ $citizen->CI_BIRTH_DT }}</p>
                        </div>
                        <div class="col">
                            <label class="form-label">العمر</label>
                            <p class="form-control-plaintext">{{ $citizen->age }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">العنوان</label>
                            <p class="form-control-plaintext">{{ $citizen->CITY }}, {{ $citizen->STREET }} - رقم المنزل: {{ $citizen->HOUSE_NO }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">الأقارب</label>
                            @if($relatives->isEmpty())
                            <p>لم يتم العثور على أقارب.</p>
                            @else
                            <ul class="list-group">
                                @foreach ($relatives as $relation)
                                <a href="{{ route('citizen.details', $relation->relative->CI_ID_NUM) }}">
                                    <li class="list-group-item">{{ $relation->relative->CI_FIRST_ARB }} {{ $relation->relative->CI_FATHER_ARB }} {{ $relation->relative->CI_FAMILY_ARB }} - ({{ $relation->relation_name }})</li>
                                </a>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">أقارب الأقارب</label>
                            <ul class="list-group">
                                @if($secondLevelRelatives->isEmpty())
                                <p>لم يتم العثور على أقارب من المستوى الثاني.</p>
                                @else
                                @foreach ($secondLevelRelatives as $relation)
                                <a href="{{ route('citizen.details', $relation['relative']->CI_ID_NUM) }}">
                                    <li class="list-group-item"> ({{ $relation['relation_type'] }} -> {{ $relation['relation_name'] }}) ||{{ $relation['relative']->CI_FIRST_ARB }} {{ $relation['relative']->CI_FATHER_ARB }} {{ $relation['relative']->CI_GRAND_FATHER_ARB }} {{ $relation['relative']->CI_FAMILY_ARB }} </li>
                                </a>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
