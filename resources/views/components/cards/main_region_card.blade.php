@props(['region'=>null])
{{-- @dd($region) --}}
@php
    
@endphp
@if (!$region)
{{-- add this in row --}}
<div class="col-md-6 col-xxl-4">
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
            <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0">{{$region->name ?? ''}}</a>
            <!--end::Name-->
            <!--begin::Position-->
            <div class="fw-bold text-gray-400 mb-2">{{$region->name ?? ''}}</div>
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
</div>
@endif