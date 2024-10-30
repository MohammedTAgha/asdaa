@extends('dashboard')
@section('title',' رفع كشف الى قاعدة البيانات ')

@section('content')

    <div id="myModal" class="  inset-0 z-50 overflow-auto   flex justify-center items-center">
        <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md">
            <h1 class="mb-6 text-2xl font-bold text-center text-gray-700">تحميل ملف اكسل</h1>
            @if (session('errors'))
                <div class="mb-4 text-red-600">
                    <strong>Errors:</strong>
                    <ul>
                        @foreach (session('errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mb-4 text-center">
                <a href="{{ route('citizens.template') }}" class="btn btn-outline btn-outline btn-outline-primary btn-active-light-primary waves-effect">
                    تحميل الترويسةهة
                    <span class="ti-xs ti ti-file-download me-1"></span>
                </a>
            </div>
            <form action="{{ route('citizens.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    <label for="excel_file" class="block mb-2 font-medium text-gray-700">اختر ملف اكسل</label>
                    <input type="file" id="excel_file" name="excel_file" required
                        class=" form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                {{-- select it --}}

                <div class="mb-4">
                    <label for="regionId" class="block mb-1 font-medium text-gray-700">اختر المنطقة:</label>
                    <select id="regionId" name="regionId"
                        class="select2-multiple p-2  border border-gray-300 rounded-lg" style="width: 100%;" >
                        @foreach ($regions as $region)
                         <option value=""></option>
                            <option   value="{{ $region->id }}" 
                                {{ in_array($region, request('regions', [])) ? 'selected' : '' }}>
    
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
                {{-- <div class="flex justify-center mb-2">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" checked="">
                        <label class="btn btn-outline-primary waves-effect" for="btnradio1">انشاء جديد</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2">
                        <label class="btn btn-outline-primary waves-effect" for="btnradio2">تحديث</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3">
                        <label class="btn btn-outline-primary waves-effect" for="btnradio3">فحص</label>
                    </div>

                </div> --}}
                <div class="flex justify-center">
                    <button type="submit" class="btn btn-xl btn-primary waves-effect waves-light">
                        رفع الكشف
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
