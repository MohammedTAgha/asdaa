@extends('dashboard')

@section('topbar')


@component('components.toolbar',['title'=>'المواطنين'])


    @slot('side')
    
    @endslot
@endcomponent

@endsection

@section('content')
    @component('components.box',['title'=>'بيانات المواطنين','styles'=>'mt-19']) 
        @component('components.citizens', ['citizens' => $citizens, 'distributions' => $distributions])
        @endcomponent
    @endcomponent
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
    </script>
@endpush