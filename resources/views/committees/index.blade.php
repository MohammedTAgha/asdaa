@extends('dashboard')

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
            <thead>
                <tr>
                    <th>ID</th>
                    <th>الاسم</th>
                    <th>المسؤول</th>
                    <th>الوصف</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($committees as $committee)
                <tr>
                    <td>{{ $committee->id }}</td>
                    <td>{{ $committee->name }}</td>
                    <td>{{ $committee->manager->name ?? 'N/A' }}</td>
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