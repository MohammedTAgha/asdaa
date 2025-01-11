@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Big Regions</h1>
    <a href="{{ route('big-regions.create') }}" class="btn btn-primary mb-3">Create Big Region</a>
    <div class="row">
        @foreach ($bigRegions as $bigRegion)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $bigRegion->name }}</h5>
                        <p class="card-text">Representative: {{ $bigRegion->representative->name ?? 'None' }}</p>
                        <p class="card-text">Regions: {{ $bigRegion->regions->count() }}</p>
                        <a href="{{ route('big-regions.show', $bigRegion->id) }}" class="btn btn-info">View Details</a>
                        <a href="{{ route('big-regions.edit', $bigRegion->id) }}" class="btn btn-warning">Edit</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
