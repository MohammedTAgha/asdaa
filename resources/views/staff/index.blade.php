@extends('dashboard')
@section('title', "الاعضاء")

@section('content')
<div class="container">
    <h1>Staff</h1>
    <a href="{{ route('staff.create') }}" class="btn btn-primary">Create Staff</a>
    <div class="table-responsive">
    <table class="table  table-hover mt-3">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="text-white" >الاسم</th>
                <th class="text-white" >الهاتف</th>
                <th class="text-white" >اللجنة</th>
                <th class="text-white" >Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $member)
            <tr>
                
                <td class="d-flex fd-center">
                    <img src="{{ asset('storage/' . $member->image) }}" alt="member" class="rounded-circle" width="50" height="50"> 

                    <a href="{{route('staff.edit',$member->id)}}" class="fs-5 fw-bold">
                    {{ $member->name }}
                    </a>
                </td>
                <td>{{ $member->phone }}</td>
                {{-- <td  class="avatar avatar-lg me-2">
                </td> --}}
                <td>{{ $member->committee ? $member->committee->name : 'N/A' }}</td>
                <td>
                    <a href="{{ route('staff.edit', $member->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('staff.destroy', $member->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection
