@extends('dashboard')

@section('content')
<div class="container">
    <h1>{{ isset($staff) ? 'Edit' : 'Create' }} Staff</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ isset($staff) ? route('staff.update', $staff->id) : route('staff.store') }}" method="POST">
        @csrf
        @if(isset($staff))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Staff Name</label>
            <input type="text" name="name" class="form-control" value="{{ $staff->name ?? old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $staff->phone ?? old('phone') }}">
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <div class="form-group">
            <label for="committee_id">Committee</label>
            <select name="committee_id" class="form-control">
                <option value="">None</option>
                @foreach($committees as $committee)
                    <option value="{{ $committee->id }}" {{ isset($staff) && $staff->committee_id == $committee->id ? 'selected' : '' }}>
                        {{ $committee->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($staff) ? 'Update' : 'Create' }}</button>
    </form>
</div>
@endsection
