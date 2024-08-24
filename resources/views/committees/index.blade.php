@extends('dashboard')
@section('title', "اللجان")

@section('content')
<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-auto">
            <h1 class="mb-0">اللجان</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('committees.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> انشاء لجنة
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-white">ID</th>
                    <th class="text-white">الاسم</th>
                    <th class="text-white">المسؤول</th>
                    <th class="text-white">الاعضاء</th>
                    <th class="text-white">الوصف</th>
                    <th class="text-white">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($committees as $committee)
                <tr>
                    <td>{{ $committee->id }}</td>
                    <td>{{ $committee->name }}</td>
                    <td>{{ $committee->manager->name ?? 'N/A' }}</td>
                    <td>
                        <div class="d-flex align-items-center avatar-group my-3">
                            @foreach($committee->staff->take(3) as $staff)
                                <div class="avatar">
                                    <img src="{{ asset('storage/' . $staff->image) }}" alt="{{ $staff->name }}" class="rounded-circle pull-up">
                                </div>
                            @endforeach
                            @if($committee->staff->count() > 3)
                                <div class="avatar">
                                    <span class="avatar-initial rounded-circle pull-up" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ $committee->staff->count() - 3 }} more">+{{ $committee->staff->count() - 3 }}</span>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>{{ $committee->description }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('committees.show', $committee) }}" class="btn btn-sm btn-primary">
                                <i class="tf-icons ti ti-eye"></i>
                            </a>
                            <a href="{{ route('committees.edit', $committee->id) }}" class="btn btn-warning">
                                <i class="tf-icons ti ti-edit"></i>
                            </a>
                            <form action="{{ route('committees.destroy', $committee->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="tf-icons ti ti-trash-x"></i>
                                </button>
                            </form>
        
                        
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection