
@extends('dashboard')

@section('content')


    @component('components.citizens',['citizens'=>$citizens])
    @endcomponent 
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Home</h1>
        <p>Welcome to the Dashboard!</p>
       
        
    </div>
@endsection