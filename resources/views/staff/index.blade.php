@extends('dashboard')

@section('content')
<div class="container">
    <h1>Staff</h1>
    <a href="{{ route('staff.create') }}" class="btn btn-primary">Create Staff</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Image</th>
                <th>Committee</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->phone }}</td>
                <td><img src="{{ asset('storage/images/' . $member->image) }}" alt="Image" width="50" height="50"></td>
                <td>{{ $member->committee ? $member->committee->name : 'N/A' }}</td>
                <td>
                    <a href="{{ route('staff.edit', $member->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('staff.destroy', $member->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
