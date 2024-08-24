@extends('dashboard')
@section('title', "تعديل المصدر")

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
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
