@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $bigRegion->name }}</h1>
    <p>Representative: {{ $bigRegion->representative->name ?? 'None' }}</p>
    <h2>Regions</h2>
    <ul>
        @foreach ($bigRegion->regions as $region)
            <li>
                <h5>{{ $region->name }}</h5>
                <p>Representative: {{ $region->representatives->pluck('name')->join(', ') }}</p>
                <p>Citizens: {{ $region->citizens->count() }}</p>
            </li>
        @endforeach
    </ul>
</div>
@endsection

    