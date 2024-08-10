@extends('dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="mb-0">بيانات اللجنة </h1>
                            <div class="btn-group">
                                <a href="{{ route('committees.edit', $committee) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> تعديل
                                </a>
                                <form action="{{ route('committees.destroy', $committee) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> حذف
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">الاسم</label>
                            <p class="form-control-plaintext">{{ $committee->name }}</p>
                        </div>

                        <div class="form-group">
                            <label for="manager_id">المدير المسؤول</label>
                            <p class="form-control-plaintext">{{ $committee->manager->name ?? 'N/A' }}</p>
                        </div>

                        <div class="form-group">
                            <label for="description">الوصف</label>
                            <p class="form-control-plaintext">{{ $committee->description }}</p>
                        </div>
                        @if ($committee->note)
                            <div class="form-group">
                                <label for="note">ملاحظات</label>
                                <p class="form-control-plaintext">{{ $committee->note }}</p>
                            </div>
                        @endif

                        @if (!empty($committee->staff))
                            <table class="table mt-3">
                                <thead>
                                    <tr>
                                        <th>الاسم</th>
                                        <th>الهاتف</th>
                                        <th>Image</th>
                                        <th>اللجنة</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($committee->staff as $member)
                                        <tr>
                                            <td>{{ $member->name }}</td>
                                            <td>{{ $member->phone }}</td>
                                            <td class="avatar avatar-lg me-2">
                                                <img src="{{ asset('storage/' . $member->image) }}" alt="member"
                                                    class="rounded-circle" width="50" height="50">

                                            </td>
                                            <td>{{ $member->committee ? $member->committee->name : 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('staff.edit', $member->id) }}" class="btn btn-warning">
                                                    <i class="tf-icons ti ti-edit"></i>
                                                </a>
                                                <form action="{{ route('staff.destroy', $member->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="tf-icons ti ti-trash-x"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
