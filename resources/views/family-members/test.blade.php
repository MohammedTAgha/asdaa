@extends('dashboard')

@section('title', 'فحص أفراد العائلات')

@section('content')
<div class="container mx-auto px-4 py-6">
    @component('components.box', ['title' => 'المواطنون بدون أفراد عائلة'])
        <div class="space-y-6">
            <!-- Citizens without self association -->
            <div>
                <h3 class="text-lg font-semibold mb-4">المواطنون بدون تسجيل ذاتي</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    رقم الهوية
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    الاسم
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    المنطقة
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    الحالة
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    التفاصيل
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($results['without_self'] as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['citizen']->id }}</td>
                                    <td class="px-6 py-4">{{ $item['citizen']->full_name }}</td>
                                    <td class="px-6 py-4">{{ $item['citizen']->region->name ?? 'غير محدد' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $item['status'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $item['details'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        لا يوجد مواطنون بدون تسجيل ذاتي
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Citizens without spouse association -->
            <div>
                <h3 class="text-lg font-semibold mb-4">المواطنون بدون تسجيل الزوجة</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    رقم الهوية
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    الاسم
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    رقم هوية الزوجة
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    المنطقة
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    الحالة
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    التفاصيل
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($results['without_spouse'] as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['citizen']->id }}</td>
                                    <td class="px-6 py-4">{{ $item['citizen']->full_name }}</td>
                                    <td class="px-6 py-4">{{ $item['citizen']->wife_id }}</td>
                                    <td class="px-6 py-4">{{ $item['citizen']->region->name ?? 'غير محدد' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ $item['status'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $item['details'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        لا يوجد مواطنون بدون تسجيل الزوجة
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endcomponent
</div>
@endsection 