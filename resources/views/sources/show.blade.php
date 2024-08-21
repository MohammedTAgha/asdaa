@extends('dashboard')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>{{ $source->name }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Phone:</strong> {{ $source->phone }}</p>
            <p><strong>Email:</strong> {{ $source->email }}</p>

            <h3>Distributions</h3>
            <ul class="list-group">
                @foreach($source->distributions as $distribution)
                    <li class="list-group-item">{{ $distribution->name }} ({{ $distribution->date }})</li>
                @endforeach
            </ul>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('sources.edit', $source->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('sources.destroy', $source->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <a href="{{ route('sources.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
