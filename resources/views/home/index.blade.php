
@extends('dashboard')

@section('content')
    @component('components.box',['title'=>'بيانات المواطنين','styles'=>'mt-19']) 
        @component('components.citizens', ['citizens' => $citizens, 'distributions' => $distributions])
        @endcomponent
    @endcomponent
@endsection