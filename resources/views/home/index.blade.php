
@extends('dashboard')

@section('content')
    @component('components.box',['title'=>'بيانات المواطنين','styles'=>'mt-19']) 
        <x-citizens :citizens="$citizens" /> 
    @endcomponent
@endsection