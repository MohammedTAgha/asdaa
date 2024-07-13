<!-- resources/views/child/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Child to {{ $citizen->name }}</h1>
    <form action="{{ route('children.store') }}" method="POST">
        @csrf
        <input type="hidden" name="citizen_id" value="{{ $citizen->id }}">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" required>
        </div>
        <div>
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <!-- Add other child fields as needed -->
        <button type="submit">Add Child</button>
    </form>
</div>
@endsection