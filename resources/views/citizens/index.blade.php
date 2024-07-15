@extends('dashboard')

@section('content')
<div class="container mx-auto py-8 ">

        <div class="relative overflow-x-auto shadow-md px-4 sm:rounded-lg">
        <h1 class="text-2xl font-bold my-4">المواطنين</h1>
        <a href="{{ route('citizens.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Distribution</a>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-9">

          <!-- Search and Filter Form -->
          <form method="GET" action="{{ route('citizens.index') }}" class="mb-4">
            <div class="flex flex-wrap mb-4">
                <!-- Search -->
                <div class="w-full md:w-1/2 lg:w-1/4 px-2 mb-4 md:mb-0">
                    <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

              
                <!-- Regions -->
                <div class="w-full md:w-1/2 lg:w-1/3 px-2 mb-4 md:mb-0">
                    <label for="regions" class="block text-sm font-medium text-gray-700">Regions</label>
                    <select name="regions[]" id="regions" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}" {{ in_array($region, request('regions', [])) ? 'selected' : '' }}>
                            @if ($region->representatives->isNotEmpty())
                            {{$region->name}} - {{ $region->representatives->first()->name }}
                            @else
                                {{$region->name}}
                            @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Social Status -->
                <div class="w-full md:w-1/2 lg:w-1/4 px-2 mb-4 md:mb-0">
                    <label for="social_status" class="block text-sm font-medium text-gray-700">Social Status</label>
                    <select name="social_status" id="social_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Select Status</option>
                        <option value="متزوج" {{ request('social_status') == 'متزوج' ? 'selected' : '' }}>متزوج</option>
                        <option value="مطلق" {{ request('social_status') == 'مطلق' ? 'selected' : '' }}>مطلق</option>
                        <option value="مطلقة" {{ request('social_status') == 'مطلقة' ? 'selected' : '' }}>مطلقة</option>
                        <option value="اعزب" {{ request('social_status') == 'اعزب' ? 'selected' : '' }}>اعزب</option>
                    </select>
                </div>

                <!-- Widowed -->
                <div class="w-full md:w-1/2 lg:w-1/4 px-2 mb-4 md:mb-0">
                    <label for="widowed" class="block text-sm font-medium text-gray-700">Widowed</label>
                    <select name="widowed" id="widowed" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="0">لا</option>
                        <option value="1" {{ request('widowed') == '1' ? 'selected' : '' }}>ارمل</option>
                        <option value="2" {{ request('widowed') == '0' ? 'selected' : '' }}>ارملة</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Filter</button>
        </form>

        <form method="GET" action="{{ route('citizens.index') }}">
                <label for="per_page" class="mr-2">Entries per page:</label>
                <select name="per_page" id="per_page" onchange="this.form.submit()" class="border border-gray-300 rounded p-1">
                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    <option value="200" {{ request('per_page') == 200 ? 'selected' : '' }}>200</option>
                    <option value="500" {{ request('per_page') == 500 ? 'selected' : '' }}>500</option>
                    <option value="1000" {{ request('per_page') == 1000 ? 'selected' : '' }}>1000</option>
                    <option value="7000" {{ request('per_page') == 7000 ? 'selected' : '' }}>7000</option>
                </select>
            </form>
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
            <h3>nav </h3>{{$citizens->links()}}
</div>
            <!-- <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing <span class="font-semibold text-gray-900 dark:text-white">1-10</span> of <span class="font-semibold text-gray-900 dark:text-white">100</span></span>
                <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                    </li>
                    <li>
                        <a href="#" aria-current="page" class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">4</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">5</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                    </li>
                </ul>
            </nav> -->
        </div>
    </div>
@endsection