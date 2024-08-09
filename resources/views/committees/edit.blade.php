@extends('dashboard')
@section('content')
<div class="container">
    <h1>{{ isset($committee) ? 'Edit' : 'Create' }} Committee</h1>

    <form action="{{ isset($committee) ? route('committees.update', $committee->id) : route('committees.store') }}" method="POST">
        @csrf
        @if(isset($committee))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Committee Name</label>
            <input type="text" name="name" class="form-control" value="{{ $committee->name ?? old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="manager_id">Manager</label>
            <select name="manager_id" class="form-control">
                <option value="">None</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->id }}" {{ isset($committee) && $committee->manager_id == $manager->id ? 'selected' : '' }}>
                        {{ $manager->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control">{{ $committee->description ?? old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="note">Note</label>
            <textarea name="note" class="form-control">{{ $committee->note ?? old('note') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($committee) ? 'Update' : 'Create' }}</button>
    </form>
</div>
@endsection
