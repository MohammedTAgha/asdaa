@extends('dashboard')
@section('content')
@section('title', "اضافة لجنة")
<div class="container">
    <h1>{{ isset($committee) ? 'تحرير' : 'انشاء' }} لجنة</h1>

    <form action="{{ isset($committee) ? route('committees.update', $committee->id) : route('committees.store') }}" method="POST">
        @csrf
        @if(isset($committee))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">اسم اللجنة</label>
            <input type="text" name="name" class="form-control" value="{{ $committee->name ?? old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="manager_id">المدير</label>
            <select name="manager_id" class="form-control">
                <option value="">بلا</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->id }}" {{ isset($committee) && $committee->manager_id == $manager->id ? 'selected' : '' }}>
                        {{ $manager->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="description">الوصف و المهام</label>
            <textarea name="description" class="form-control">{{ $committee->description ?? old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="note">ملاحظات</label>
            <textarea name="note" class="form-control">{{ $committee->note ?? old('note') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($committee) ? 'Update' : 'Create' }}</button>
    </form>
</div>
@endsection
