@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Child Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <strong>Name:</strong> {{ $child->name }}
            </div>
            <div>
                <strong>Date of Birth:</strong> {{ $child->date_of_birth }}
            </div>
            <div>
                <strong>Gender:</strong> {{ $child->gender }}
            </div>
            <div>
                <strong>Orphan:</strong> {{ $child->orphan ? 'Yes' : 'No' }}
            </div>
            <div>
                <strong>Infant:</strong> {{ $child->infant ? 'Yes' : 'No' }}
            </div>
            <div>
                <strong>Bambers Size:</strong> {{ $child->bambers_size }}
            </div>
            <div>
                <strong>Disease:</strong> {{ $child->disease ? 'Yes' : 'No' }}
            </div>
            <div>
                <strong>Disease Description:</strong> {{ $child->disease_description }}
            </div>
            <div>
                <strong>Obstruction:</strong> {{ $child->obstruction ? 'Yes' : 'No' }}
            </div>
            <div>
                <strong>Obstruction Description:</strong> {{ $child->obstruction_description }}
            </div>
            <div class="md:col-span-2">
                <strong>Note:</strong> {{ $child->note }}
            </div>
        </div>
        <h2 class="text-2xl font-bold mt-6 mb-4">Father Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <strong>Name:</strong>  
            </div>
            <div>
                <strong>Age:</strong>  
            </div>
            <div>
                <strong>Occupation:</strong> 
            </div>
        </div>
    </div>
</div>

@endsection