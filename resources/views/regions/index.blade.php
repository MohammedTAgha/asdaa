@extends('dashboard')

@section('title', "المناطق")

@section('content')
    <div class="container mx-auto py-6">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">المناطق الكبرى</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-light">
                        اضافة
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @component('components.cards.main_region_card')
                        
                    @endcomponent
                    {{-- <div class="col-md-6 col-xxl-4">
                        <!--begin::Card-->
                        <div class="card shadow-sm border border-2 border-gray-300 border-hover">
                            <!--begin::Card body-->
                            <div class="card-body d-flex flex-center flex-column pt-6 p-4">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-65px symbol-circle mb-5">
                                    <span class="symbol-label fs-2x fw-bold text-info bg-light-info">1</span>
                                    <div class="bg-success position-absolute border border-4 border-white h-15px w-15px rounded-circle translate-middle start-100 top-100 ms-n3 mt-n3"></div>
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Name-->
                                <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0">مخيم بسمة امل</a>
                                <!--end::Name-->
                                <!--begin::Position-->
                                <div class="fw-bold text-gray-400 mb-2">عبد الرحمن ابو سرية</div>
                                <!--end::Position-->
                                <!--begin::Info-->
                                <div class="d-flex flex-center flex-wrap">
                                    <!--begin::Stats-->
                                    <div class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                        <div class="fs-4 fw-bolder text-gray-800 ">1400</div>
                                        <div class="fw-bold text-gray-500">اسرة</div>
                                    </div>
                                    <!--end::Stats-->
        
                                     <!--begin::Stats-->
                                     <div class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                        <div class="fs-4 fw-bolder text-gray-800 ">1000</div>
                                        <div class="fw-bold text-gray-500">نسمة</div>
                                    </div>
                                    <!--end::Stats-->
        
                                    <!--begin::Stats-->
                                    <div class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                        <div class="fs-4 fw-bolder text-gray-800 ">6</div>
                                        <div class="fw-bold text-gray-500">مناطق</div>
                                    </div>
                                    <!--end::Stats-->

                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div> --}}
                </div>
            </div>
            
        </div>
        <div class="tab-pane fade show active">
           
        </div>
        <div class="card mb-4">
            <div class="card-header header-elements">
                <h2 class="text-2xl font-bold ">المناطق</h1>
                    <span class="h-13px border-gray-200 border-start mx-2 mx-2"></span>

                    <a href="{{ route('regions.create') }}" class="bg-blue-500 text-white px-2 py-1 rounded">جديد</a>

                    <div class="card-header-elements ms-auto d-flex">
                        <input type="text" class="form-control form-control-sm" placeholder="Search">

                    </div>

            </div>
           
           

            <div class="card-body">
                <div class="row">
                   
                    @foreach ($regions as $region)
                   
                    <div class="col-md-6 col-xl-4 bg-primary px-0 rounded" style="max-width: 32%;margin: 2px ; ">
                        <a href="{{route('regions.show',$region->id)}}">
                        <div class="card bg-primary text-white mb-0 px-0 rounded">
                            <div class="card-header text-xl font-bold py-3"> {{$region->name}} </div>
                            <div class="card-body text-xl mb-0 pb-0">
                                <h5 class=" text-white"> {{$region->representatives->first()->name ?? 'غير محدد'}} </h5>
                            </div>                       
                        </div>
                        <div class=" text-4xl font-bold text-center mt-1 mb-2 text-white">{{$region->citizens->count() ?? '  --  '}} <span class="fs-3">اسرة</span> </div>
                            </a>
                    </div>
                    
                    @endforeach


                </div>
            </div>
            {{-- <div class="mt-6">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class=" py-3 px-4 uppercase font-semibold text-sm">المنطقة</th>
                        <th class=" py-3 px-4 uppercase font-semibold text-sm">اسم المندوب</th>
                        <th class=" py-3 px-4 uppercase font-semibold text-sm">عدد السكان</th>
                        <th class=" py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($regions as $region)
                        <tr>
                            
                            <td class=" py-3 px-4">
                                <a href="{{route('regions.show',$region->id)}}">
                                     {{ $region->name }}
                                </a>
                            </td>
                            <td class=" py-3 px-4">
                                
                                 {{ $region->representatives->first()->name ??'N/A' }}
                                
                            </td>
                            <td class=" py-3 px-4">{{ $region->citizens->count() }}</td>
                            <td class=" py-3 px-4">
                                <a href="{{ route('regions.show', $region->id) }}" class="text-blue-500">عرض</a>
                                <a href="{{ route('regions.edit', $region->id) }}" class="text-green-500 ml-2">تحرير</a>
                                <form action="{{ route('regions.destroy', $region->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 ml-2">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}
        </div>
    @endsection
