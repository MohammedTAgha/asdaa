@extends('dashboard')

@section('title', 'استيراد أفراد العائلات')

@section('content')
<div class="container mx-auto px-4 py-6">
    @component('components.box', ['title' => 'استيراد أفراد العائلات من ملف Excel'])
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-6">
            <div class="bg-yellow-50 border border-yellow-400 text-yellow-700 p-4 rounded">
                <h3 class="font-bold mb-2">تعليمات الاستيراد:</h3>
                <ul class="list-disc list-inside space-y-1">
                    <li>يجب أن يكون الملف بتنسيق Excel (.xlsx, .xls) أو CSV</li>
                    <li>يجب أن يحتوي الملف على الأعمدة التالية:
                        <ul class="list-disc list-inside mr-4 mt-1">
                            <li>citizen_id (رقم هوية رب الأسرة)</li>
                            <li>firstname (الاسم الأول)</li>
                            <li>secondname (اسم الأب)</li>
                            <li>thirdname (اسم الجد - اختياري)</li>
                            <li>lastname (اسم العائلة)</li>
                            <li>date_of_birth (تاريخ الميلاد - YYYY-MM-DD)</li>
                            <li>gender (الجنس - male/female)</li>
                            <li>relationship (صلة القرابة - father/mother/son/daughter)</li>
                            <li>national_id (رقم الهوية)</li>
                            <li>notes (ملاحظات - اختياري)</li>
                        </ul>
                    </li>
                    <li>يجب أن يكون رقم هوية رب الأسرة موجوداً في النظام</li>
                    <li>تاريخ الميلاد يجب أن يكون بالصيغة: YYYY-MM-DD</li>
                </ul>
            </div>
        </div>

        <form action="{{ route('family-members.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    اختر ملف Excel
                </label>
                <input type="file" name="file" 
                       class="block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100"
                       required
                       accept=".xlsx,.xls,.csv">
            </div>

            <div class="flex justify-between">
                <a href="{{ route('family-members.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right ml-1"></i>
                    عودة للقائمة
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload ml-1"></i>
                    استيراد الملف
                </button>
            </div>
        </form>
        
        <!-- نموذج للملف -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-4">نموذج للملف:</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">citizen_id</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">firstname</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">secondname</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">lastname</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">date_of_birth</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">gender</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">relationship</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4">1234567890</td>
                            <td class="px-6 py-4">احمد</td>
                            <td class="px-6 py-4">محمد</td>
                            <td class="px-6 py-4">العلي</td>
                            <td class="px-6 py-4">2000-01-01</td>
                            <td class="px-6 py-4">male</td>
                            <td class="px-6 py-4">son</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endcomponent
</div>
@endsection
