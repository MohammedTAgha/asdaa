@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Child Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <strong>الاسم:</strong> {{ $child->name }}
            </div>
            <div>
                <strong>تاريخ الميلاد:</strong> {{ $child->date_of_birth }}
            </div>
            <div>
                <strong>الجنس:</strong> {{ $child->gender }}
            </div>
            <div>
                <strong>يتيم:</strong> {{ $child->orphan ? 'Yes' : 'No' }}
            </div>
            <div>
                <strong>رضيع:</strong> {{ $child->infant ? 'Yes' : 'No' }}
            </div>
            <div>
                <strong>حجم الحفاضات:</strong> {{ $child->bambers_size }}
            </div>
            <div>
                <strong> يوجد مرض:</strong> {{ $child->disease ? 'Yes' : 'No' }}
            </div>
            <div>
                <strong>وصف المرض:</strong> {{ $child->disease_description }}
            </div>
            <div>
                <strong> يوجد اعاقة:</strong> {{ $child->obstruction ? 'Yes' : 'No' }}
            </div>
            <div>
                <strong>وصف الاعاقة:</strong> {{ $child->obstruction_description }}
            </div>
            <div class="md:col-span-2">
                <strong>ملاحات:</strong> {{ $child->note }}
            </div>
        </div>
        <h2 class="text-2xl font-bold mt-6 mb-4">Father Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <strong>اسم الاب:</strong>  
            </div>
            <div>
                <strong>العمر:</strong>  
            </div>

        </div>
    </div>
</div>

@endsection