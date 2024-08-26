@extends('dashboard')
@section('title', "تقارير المشاريع")

@section('content')
<h2>Statistics with Regions</h2>
<table>
    <thead>
        <tr>
            <th>Region Name</th>
            <th>Project Name</th>
            <th>Total Citizens</th>
            <th>Benefited Citizens</th>
            <th>Percentage</th>
        </tr>
    </thead>
    <tbody>
        @foreach($withRegions as $stat)
            <tr>
                <td>{{ $stat->region_name }}</td>
                <td>{{ $stat->project_name }}</td>
                <td>{{ $stat->total_citizens }}</td>
                <td>{{ $stat->benefited_citizens }}</td>
                <td>{{ $stat->percentage }}%</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h2>Statistics without Regions</h2>
<table>
    <thead>
        <tr>
            <th>Project Name</th>
            <th>Total Citizens</th>
            <th>Benefited Citizens</th>
        </tr>
    </thead>
    <tbody>
        @foreach($withoutRegions as $stat)
            <tr>
                <td>{{ $stat->project_name }}</td>
                <td>{{ $stat->total_citizens }}</td>
                <td>{{ $stat->benefited_citizens }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection