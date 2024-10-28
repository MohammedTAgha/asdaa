@extends('dashboard')

@section('content')
<div class="container">
    <h2>Edit User</h2>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control">
            <small class="form-text text-muted">Leave blank to keep current password.</small>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <div class="form-group">
            <label for="role_id">Role</label>
            <select name="role_id" class="form-control" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">اختر المناطق:</label>
            <select id="regions" name="regions[]" style="width: 100%;"
                class="select2-multiple p-2 border border-gray-300 rounded-lg" multiple>
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}"
                        {{ $user->regions->contains($region->id) ? 'selected' : '' }}>
                        @if ($region->representatives->isNotEmpty())
                            {{ $region->name }} 
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
