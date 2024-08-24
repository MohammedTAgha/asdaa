@extends('dashboard')
@section('title', "اضافة عضو")

@section('content')
<div class="container">
    <h1>{{ isset($staff) ? 'نحرير' : 'انشاء' }} عضو </h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ isset($staff) ? route('staff.update', $staff->id) : route('staff.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($staff))
            @method('PUT')
        @endif
        {{-- <div class="form-group">
            <label for="id">الاسم</label>
            <input type="text" name="id" class="form-control" value="{{ $staff->id ?? old('id') }}" required>
        </div> --}}
        <div class="form-group">
            <label for="name">الاسم</label>
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
            <label for="committee_id">اختر اللجنة</label>
            <select name="committee_id" class="form-control">
                <option value="">بلا</option>
                @foreach($committees as $committee)
                    <option value="{{ $committee->id }}" {{ isset($staff) && $staff->committee_id == $committee->id ? 'selected' : '' }}>
                        {{ $committee->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="user_id">اختر المستخدم</label>
            <select name="user_id" class="form-control">
                <option value="">بلا</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ isset($staff) && $staff->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($staff) ? 'تحديث' : 'انشاء' }}</button>
    </form>
</div>
@endsection
