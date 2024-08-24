@extends('dashboard')
@section('title', "تعديل المشروع")

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold my-4">تعديل المشروع</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
                        <div class="alert alert-{{ session('status')['type'] }}">
                            {{ session('status')['message'] }}
                        </div>
                    @endif
        <form action="{{ route('distributions.update', $distribution->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('distributions.partials.form')
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">تعديل المشروع</button>
        </form>
    </div>
@endsection
