@extends('dashboard')

@push('custom_styles')
@endpush
@section('title', "المصادر")

@section('content')


    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Sources</h1>
            <a href="{{ route('sources.create') }}" class="btn btn-primary">جديد</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (empty($sources))
            <h3>
                لا يوجد مصادر
            </h3>
        @else
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>الاسم</th>
                        <th>الهاتف</th>
                        <th>الايميل</th>
                        <th>عدد المشاريع</th>
                        <th>اجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sources as $source)
                        <tr>
                            <td>
                                <a href="{{route('sources.show',$source->id)}}"></a>
                                {{ $source->name }}
                            </td>
                            <td>{{ $source->phone }}</td>
                            <td>{{ $source->email }}</td>
                            <td>{{ $source->distributions->count() }}</td>
                            <td>
                                <a href="{{ route('sources.edit', $source->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal-{{ $source->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>

                                {{-- del model  --}}

                                <div class="modal fade" id="deleteModal-{{ $source->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel-{{ $source->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel-{{ $source->id }}">
                                                    تاكيد الحذف
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                               هل انت متاكد من حذف {{$source->name}}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">الغاء</button>
                                                <form action="{{ route('sources.destroy', $source->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">حذف</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
@endsection
