@extends('dashboard')

@section('content')
    @component('components.toolbar',['title'=>'المواطنين'])

            <!--begin::Compact form-->
            <form method="GET" action="{{ route('citizens.index') }}">
            <div class="d-flex align-items-center">
            <!--begin::Input group-->
            <div class="position-relative w-md-400px me-md-2">
                <input type="text" class="form-control form-control-solid ps-10" name="search" value="" placeholder="بحث">
            </div>
            <!--end::Input group-->
            <!--begin:Action-->
            <div class="d-flex align-items-center">
                <button type="submit" class="btn btn-primary me-5">بحث</button>
                <!-- <a id="kt_horizontal_search_advanced_link" class="btn btn-link collapsed" data-bs-toggle="collapse" href="#kt_advanced_search_form" aria-expanded="false">Advanced Search</a> -->
            </div>
            <!--end:Action-->
        </div>
        </form>
        <!--end::Compact form-->
        @slot('side')
            <!--begin::Menu-->
            <a  class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
            <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                </svg>
            </span>
            <!--end::Svg Icon-->فلترة</a>
            <!--begin::Menu 1-->
            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_61484c45b0e77">
                <!--begin::Header-->
                <div class="px-5 py-3">
                    <div class="fs-6 text-dark fw-bolder">خيارات التصنيف</div>
                </div>
                <!--end::Header-->
                <!--begin::Menu separator-->
                <div class="separator border-gray-200"></div>
                <!--end::Menu separator-->
                <!--begin::Form-->
                <div class="px-5 py-3">
                    <!--begin::Input group-->
                    <div class="mb-6">
                        <!--begin::Label-->
                        <label class="form-label fw-bold">Status:</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div>
                            <select class="form-select form-select-solid" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_61484c45b0e77" data-allow-clear="true">
                                <option></option>
                                <option value="1">Approved</option>
                                <option value="2">Pending</option>
                                <option value="2">In Process</option>
                                <option value="2">Rejected</option>
                            </select>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    
                    <!--begin::Input group-->
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-bold">Notifications:</label>
                        <!--end::Label-->
                        <!--begin::Switch-->
                        <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked" />
                            <label class="form-check-label">Enabled</label>
                        </div>
                        <!--end::Switch-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end">
                        <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                        <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Form-->
            </div>
            <!--end::Menu 1-->
            <!--end::Menu-->
            <a href="{{ route('citizens.create') }}" class="btn btn-sm btn-primary">اضافة جديد</a>

        @endslot
    @endcomponent

aa
        <div class="relative overflow-x-auto shadow-md px-4 sm:rounded-lg">
        <!-- <h1 class="text-2xl font-bold my-4">المواطنين</h1>
        <a href="{{ route('citizens.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Distribution</a> -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-9">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase rtl:text-right bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                        <a href="{{ route('citizens.index', ['sort' => 'name', 'direction' => $sortField == 'name' && $sortDirection == 'asc' ? 'desc' : 'asc', 'per_page' => $perPage]) }}">
                                Name
                                @if($sortField == 'name')
                                    <span>{{ $sortDirection == 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3">
                           
                        <a href="{{ route('citizens.index', ['sort' => 'date_of_birth', 'direction' => $sortField == 'date_of_birth' && $sortDirection == 'asc' ? 'desc' : 'asc', 'per_page' => $perPage]) }}">
                                 Date of Birth
                                @if($sortField == 'date_of_birth')
                                    <span>{{ $sortDirection == 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <a href="{{ route('citizens.index', ['sort' => 'gender', 'direction' => $sortField == 'gender' && $sortDirection == 'asc' ? 'desc' : 'asc', 'per_page' => $perPage]) }}">
                            Gender
                                @if($sortField == 'gender')
                                    <span>{{ $sortDirection == 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3">
                        <a href="{{ route('citizens.index', ['sort' => 'wife_name', 'direction' => $sortField == 'wife_name' && $sortDirection == 'asc' ? 'desc' : 'asc', 'per_page' => $perPage]) }}">
                            wife name
                                @if($sortField == 'wife_name')
                                    <span>{{ $sortDirection == 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            
                            <a href="{{ route('citizens.index', ['sort' => 'social_status', 'direction' => $sortField == 'social_status' && $sortDirection == 'asc' ? 'desc' : 'asc', 'per_page' => $perPage]) }}">
                            Social Status
                                @if($sortField == 'social_status')
                                    <span>{{ $sortDirection == 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            
                            <a href="{{ route('citizens.index', ['sort' => 'region_id', 'direction' => $sortField == 'region_id' && $sortDirection == 'asc' ? 'desc' : 'asc', 'per_page' => $perPage]) }}">
                            Region
                                @if($sortField == 'region_id')
                                    <span>{{ $sortDirection == 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Note
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($citizens as $citizen)
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td class="w-4 p-4">
            <div>
                <input id="checkbox-table-search-{{ $citizen->id }}" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="checkbox-table-search-{{ $citizen->id }}" class="sr-only">checkbox</label>
            </div>
        </td>
        <td class="px-6 py-4 bg-gray-50">{{ $citizen->id }}</td>
        <td class="px-6 py-4">{{ $citizen->name }}</td>
        <td class="px-6 py-4 bg-gray-50">{{ $citizen->date_of_birth }}</td>
        <td class="px-6 py-4">{{ $citizen->gender }}</td>
        <td class="px-6 py-4 bg-gray-50">{{ $citizen->wife_name }}</td>
        <td class="px-6 py-4">{{ $citizen->social_status }}</td>
        <td class="px-6 py-4 bg-gray-50">{{ $citizen->region->name ?? 'N/A' }}</td>
        <td class="px-6 py-4">{{ $citizen->note }}</td>
        <td class="px-6 py-4 bg-gray-50">
            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
        </td>
    </tr>
    @endforeach
                </tbody>
                
            </table>
</div>
    <form method="GET" action="{{ route('citizens.index') }}">
                <label for="per_page" class="mr-2">Entries per page:</label>
                <select name="per_page" id="per_page" onchange="this.form.submit()" class="border border-gray-300 rounded p-1">
                    <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                </select>
            </form>
            {{$citizens->links()}}
        </div>
    
@endsection