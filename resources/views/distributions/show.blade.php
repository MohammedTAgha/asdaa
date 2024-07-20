@extends('dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4">{{ $distribution->name }}</h1>
    <p>Date: {{ $distribution->date }}</p>
    <p>Arrive Date: {{ $distribution->arrive_date }}</p>
    <p>Quantity: {{ $distribution->quantity }}</p>
    <p>Target: {{ $distribution->target }}</p>
    <p>Source: {{ $distribution->source }}</p>
    <p>Done: {{ $distribution->done ? 'Yes' : 'No' }}</p>
    <p>Target Count: {{ $distribution->target_count }}</p>
    <p>Expectation: {{ $distribution->expectation }}</p>
    <p>Min Count: {{ $distribution->min_count }}</p>
    <p>Max Count: {{ $distribution->max_count }}</p>
    <p>Note: {{ $distribution->note }}</p>
    <ul>
    
    @foreach($distribution->citizens as $citizen)
    <li> {{$citizen->id }}  | {{$citizen->name }}  </li>
    @endforeach
    </ul>
</div>
@endsection