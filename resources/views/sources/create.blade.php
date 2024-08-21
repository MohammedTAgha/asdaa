@extends('dashboard')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>{{ isset($source) ? 'تعديل' : 'اضافة جديد' }}</h2>
        </div>
        <div class="card-body">
            @include('sources._form')
        </div>
    </div>
</div>
@endsection
