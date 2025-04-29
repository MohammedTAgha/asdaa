@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Big Region</h1>
    <form action="{{ route('big-regions.update', $bigRegion->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input value="{{ $bigRegion->name }}" type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="representative_id">Representative</label>
            <select name="representative_id" id="representative_id" class="form-control" required>
                <option value="">Select a representative</option>
                @foreach ($representatives as $rep)
                    <option value="{{ $rep->id }}" {{ $bigRegion->representative_id == $rep->id ? 'selected' : '' }}>
                        {{ $rep->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="regions">Regions</label>
            <select name="regions[]" id="regions" class="select2-multiple form-control" multiple>
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}" {{ in_array($region->id, $bigRegion->regions->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $region->name }}
                        @if ($region->representatives->isNotEmpty())
                            (Rep: {{ $region->representatives->first()->name }})
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="note">Note</label>
            <textarea name="note" id="note" class="form-control">{{ $bigRegion->note }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
