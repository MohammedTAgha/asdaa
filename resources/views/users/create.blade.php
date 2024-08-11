@extends('dashboard')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <h2>Create User</h2>
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
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
                <label for="committee_id">اختر اللجنة</label>
                <select name="committee_id" class="form-control">
                    <option value="">بلا</option>
                    @foreach ($committees as $committee)
                        <option value="{{ $committee->id }}"
                            {{ isset($staff) && $staff->committee_id == $committee->id ? 'selected' : '' }}>
                            {{ $committee->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="role_id">Role</label>
                <select name="role_id" class="form-control" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }} {{ $role->id }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
