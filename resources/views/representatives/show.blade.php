@extends('dashboard')

@section('content')
    @component('components.box', ['title' => 'المندوب' . ' ' . $representative->name . ' ', 'styles' => 'mb-4'])
        @slot('side')
            <div class="mt-6">
                <a href="{{ route('representatives.edit', $representative->id) }}"
                    class="px-4 py-2 bg-yellow-600 text-white rounded-md">تعدبل</a>
                <a href="{{ route('representatives.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">رجوع</a>

            </div>
        @endslot


        <div class="mb-4">
            <h2 class="text-2xl font-semibold">الاسم:</h2>
            <p class="text-gray-700">{{ $representative->name }}</p>
        </div>
        <div class="mb-4">
            <h2 class="text-2xl font-semibold">المنطقة:</h2>
            <p class="text-gray-700">{{ $representative->region->name ?? 'N/A' }}</p>
        </div>
        <div class="mb-4">
            <h2 class="text-2xl font-semibold">الهاتف:</h2>
            <p class="text-gray-700">{{ $representative->phone }}</p>
        </div>
        @if ($representative->address)
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">العنوان:</h2>
                <p class="text-gray-700">{{ $representative->address }}</p>
            </div>
        @endif
        @if ($representative->note)
            <div class="mb-4">
                <h2 class="text-2xl font-semibold">ملاحظة:</h2>
                <p class="text-gray-700">{{ $representative->note }}</p>
            </div>
        @endif
    @endcomponent
    @if ($representative->region)
        @component('components.box', ['title' => ' المواطنين في منطقة' . ' ' . $representative->region->name ?? 'N/A'])
            @component('components.citizens' ,['citizens'=>$representative->region->citizens , 'regions'=>$regions] )
                
            @endcomponent
            {{-- <x-citizens :citizens="$representative->region->citizens" /> --}}
        @endcomponent
    @endif
    <h3> no reion</h3>
    </div>

@endsection
