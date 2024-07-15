@extends('dashboard')

@section('content')
    <h1>Edit DistributionCitizen</h1>

    <form action="{{ route('distribution_citizens.update', $distributionCitizen->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="distribution_id">Distribution:</label>
        <select name="distribution_id" id="distribution_id" required>
            @foreach($distributions as $distribution)
                <option value="{{ $distribution->id }}" {{ $distribution->id == $distributionCitizen->distribution_id ? 'selected' : '' }}>
                    {{ $distribution->name }}
                </option>
            @endforeach
        </select>
        
        <label for="citizen_id">Citizen:</label>
        <select name="citizen_id" id="citizen_id" required>
            @foreach($citizens as $citizen)
                <option value="{{ $citizen->id }}" {{ $citizen->id == $distributionCitizen->citizen_id ? 'selected' : '' }}>
                    {{ $citizen->name }}
                </option>
            @endforeach
        </select>
        
        <label for="quantity">Quantity:</label>
        <input type="text" name="quantity" id="quantity" value="{{ $distributionCitizen->quantity }}" required>
        
        <label for="recipient">Recipient:</label>
        <input type="text" name="recipient" id="recipient" value="{{ $distributionCitizen->recipient }}" >
        
        <label for="note">Note:</label>
        <textarea name="note" id="note">{{ $distributionCitizen->note }}</textarea>
        
        <label for="done">Done:</label>
        <input type="checkbox" name="done" id="done" value="1" {{ $distributionCitizen->done ? 'checked' : '' }}>
        
        <button type="submit">Update</button>
    </form>
@endsection