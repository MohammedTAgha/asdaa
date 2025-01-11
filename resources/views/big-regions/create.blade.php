@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Big Region</h1>
    <form action="{{ route('big-regions.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="representative_id">Representative</label>
            <select name="representative_id" id="representative_id" class="form-control" required>
                <option value="">Select a representative</option>
                @foreach ($representatives as $rep)
                    <option value="{{ $rep->id }}">{{ $rep->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="regions">Regions</label>
            <select name="regions[]" id="regions" class="select2-multiple p-2  border border-gray-300 rounded-lg" style="width: 100%;" multiple>
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}">
                        {{ $region->name }}
                        @if ($region->representatives->isNotEmpty())
                        {{ $region->name }} </br> :
                        {{ $region->representatives->first()->name }}
                        @else
                            {{ $region->name }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="note">Note</label>
            <textarea name="note" id="note" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
@endsection
