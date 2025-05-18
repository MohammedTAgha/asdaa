@extends('dashboard')

@section('title', 'تقرير استيراد أفراد العائلات')

@section('content')
<div class="container mx-auto px-4 py-6">
    @component('components.box', ['title' => 'نتائج الاستيراد'])
        <div class="space-y-6">
            <div class="bg-green-50 border border-green-400 text-green-700 px-4 py-3 rounded">
                <p class="font-bold">تم استيراد {{ $successes }} من أفراد العائلات بنجاح</p>
            </div>

            @if(count($failures) > 0)
                <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <p class="font-bold mb-2">فشل استيراد {{ count($failures) }} من السجلات:</p>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">رقم هوية رب الأسرة</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الاسم</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">سبب الفشل</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($failures as $failure)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $failure['row']['citizen_id'] ?? 'غير محدد' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ ($failure['row']['firstname'] ?? '') . ' ' . 
                                               ($failure['row']['secondname'] ?? '') . ' ' . 
                                               ($failure['row']['lastname'] ?? '') }}
                                        </td>
                                        <td class="px-6 py-4 text-red-600">
                                            {{ $failure['error'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="flex justify-between">
                <a href="{{ route('family-members.import-form') }}" class="btn btn-secondary">
                    <i class="fas fa-upload ml-1"></i>
                    استيراد ملف آخر
                </a>
                
                <a href="{{ route('family-members.index') }}" class="btn btn-primary">
                    <i class="fas fa-list ml-1"></i>
                    عرض جميع أفراد العائلات
                </a>
            </div>
        </div>
    @endcomponent
</div>
@endsection
