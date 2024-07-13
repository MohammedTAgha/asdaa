@extends('layouts.app')

@section('content')
    <h1>Create DistributionCitizen</h1>

    <form action="{{ route('distribution_citizens.store') }}" method="POST">
        @csrf
        <label for="distribution_id">Distribution:</label>
        <select name="distribution_id" id="distribution_id" required>
            @foreach($distributions as $distribution)
                <option value="{{ $distribution->id }}">{{ $distribution->name }}</option>
            @endforeach
        </select>
        
        <label for="citizen_id">Citizen:</label>
        <select name="citizen_id" id="citizen_id" required>
            @foreach($citizens as $citizen)
                <option value="{{ $citizen->id }}">{{ $citizen->name }}</option>
            @endforeach
        </select>
        
        <label for="quantity">Quantity:</label>
        <input type="text" name="quantity" id="quantity" required>
        
        <label for="recipient">Recipient:</label>
        <input type="text" name="recipient" id="recipient" >
        
        <label for="note">Note:</label>
        <textarea name="note" id="note"></textarea>
        
        <label for="done">Done:</label>
        <input type="checkbox" name="done" id="done" value="1">
        
        <button type="submit">Create</button>
    </form>
@endsection