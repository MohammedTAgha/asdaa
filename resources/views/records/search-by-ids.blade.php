@extends('dashboard')
@section('title', "بحث بالهوية")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>البحث برقم الهوية</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('records.search-by-ids') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="ids">ادخل الهويات (كل هوية في سطر جديد)</label>
                            <textarea name="ids" id="ids" class="form-control" rows="5">{{ session('search_ids') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">بحث</button>
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
                                    <th>الحالة</th>
                                    <th>الزوجة</th>
                                    <th>المدينة</th>
                                    <th>العنوان</th>
                                    <th>الميلاد</th>
                                    <th>الجنس</th>
                                    <th>العمر</th>
                                    <th>الوفاة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $citizen)
                                <tr>
                                    <td>{{ $citizen->CI_ID_NUM }}</td>
                                    <td>{{ $citizen->full_name }}</td>
                                    <td>{{ $citizen->CI_PERSONAL_CD }}</td>
                                    @if($citizen->CI_PERSONAL_CD === "متزوج")
                                        @if($citizen->getWife())
                                            <td>{{ $citizen->getWife()->full_name }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    @else
                                        <td>-</td>
                                    @endif
                                    <td>{{ $citizen->CITTTTY }}</td>
                                    <td>{{ $citizen->CITY }}</td>
                                    <td>{{ $citizen->CI_BIRTH_DT }}</td>
                                    <td>{{ $citizen->CI_SEX_CD }}</td>
                                    <td>{{ $citizen->age }}</td>
                                    <td>{{ $citizen->CI_DEAD_DT }}</td>
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
@endsection
