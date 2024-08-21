@extends('dashboard')


@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Sources</h1>
            <a href="{{ route('sources.create') }}" class="btn btn-primary">جديد</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (empty($sources))
            <h3>
                لا يوجد مصادر
            </h3>
        @else
        
        <table class="table table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Distributions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sources as $source)
                    <tr>
                        <td>{{ $source->name }}</td>
                        <td>{{ $source->phone }}</td>
                        <td>{{ $source->email }}</td>
                        <td>{{ $source->distributions->count() }}</td>
                        <td>
                            <a href="{{ route('sources.show', $source->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('sources.edit', $source->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('sources.destroy', $source->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif

    </div>
@endsection
