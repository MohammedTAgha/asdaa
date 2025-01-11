@extends('layouts.app')

@section('content')
<div class="container">
    <h1>edit Big Region</h1>
    <form action="{{ route('big-regions.update',$bigRegion->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input value="{{$bigRegion->name}}" type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="representative_id">Representative</label>
            <select name="representative_id" id="representative_id" class="form-control" required>
                <option value="">Select a representative</option>
                @foreach ($representatives as $rep)
                    <option value="{{ $rep->id }}" {{isset($bigRegion->representative->id) && $bigRegion->representative->id== $rep->id ? 'selected' : ''}}>{{ $rep->name }}   
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="regions">Regions</label>
            <select name="regions[]" id="regions" class="form-control" multiple>
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}">{{ $region->name }}</option>
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
