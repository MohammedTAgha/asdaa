@extends('dashboard')

@section('content')

@component('components.box',['title'=>'بيانات التوزيع'])
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">رقم</label>
                <p class="mt-1 text-gray-900">{{ $distribution->id }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">الوصف</label>
                <p class="mt-1 text-gray-900">{{ $distribution->name }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">تاريخ الوصول</label>
                <p class="mt-1 text-gray-900">{{ $distribution->arrive_date }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">الكمية</label>
                <p class="mt-1 text-gray-900">{{ $distribution->quantity }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">الفئة المستهدفة</label>
                <p class="mt-1 text-gray-900">{{ $distribution->target }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">المصدر</label>
                <p class="mt-1 text-gray-900">{{ $distribution->source }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">اكتمل</label>
                <p class="mt-1 text-gray-900">{{ $distribution->done ? 'مكتمل' : 'غير مكتمل' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">عدد المستفيدين</label>
                <p class="mt-1 text-gray-900">{{ $distribution->target_count }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">المتوقعين</label>
                <p class="mt-1 text-gray-900">{{ $distribution->expectation }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">عدد الافراد</label>
                <p class="mt-1 text-gray-900">من : {{ $distribution->min_count }} {{ $distribution->max_count }}الى:</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">ملاحظة</label>
                <p class="mt-1 text-gray-900">{{ $distribution->note }}</p>
            </div>

        </div>
    @foreach($distribution->citizens as $citizen)
    <li> {{$citizen->id }}  | {{$citizen->name }}  </li>
    @endforeach
    </ul>
</div>
@endcomponent

@component('components.box',['title'=>'المواطنين المستفيدين])

@endcomponent

<div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">التوزيع</h1>
        @php
        $citizens = $distribution->citizens;
        @endphp
        @if (!$citizens->isEmpty())
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">الهوية</th>
                        <th class="w-2/7 py-3 px-4 uppercase font-semibold text-sm">الاسم</th>
                        <th class="w-2/7 py-3 px-4 uppercase font-semibold text-sm">المنطقة</th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">عدد افراد الاسرة </th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">الحالة الاجتماعية</th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">الكمية المستلمة</th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">استلم</th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">تاريخ الاستلام</th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">اسم المستلم</th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">ملاحظة </th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm"> </th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">  
                @foreach($citizens as $citizen)
                    <tr>
                        <td class="w-1/7 py-3 px-4">
                            <a href="{{ route('citizens.show', $citizen->id) }}" class="text-blue-600 hover:underline">
                            {{ $citizen->pivot->id }}
                            </a> 
                        </td> 
                     
                        <td class="w-2/7 py-3 px-4">
                        <a href="{{ route('citizens.show', $citizen->id) }}" class="text-blue-600 hover:underline">
                        {{ $citizen->name }}
                        </a>
                    </td>
                     
                        <td class="w-1/7 py-3 px-4">{{ $citizen->source }}</td>
                        <td class="w-1/7 py-3 px-4">{{ $citizen->pivot->quantity }}</td>
                        <td class="w-1/7 py-3 px-4">
                        <input class="text-sm" type="checkbox" name="done" value="{{ $citizen->pivot->done }}" {{ $citizen->pivot->done ? 'checked' : '' }}>
                        </td>
                        <td class="w-1/7 py-3 px-4">{{ $citizen->pivot->recipient }}</td>
                        <td class="w-1/7 py-3 px-4">
                            <input type="date" name="date" value="{{ $citizen->pivot->date }}">
                        </td>
                        <td class="w-1/7 py-3 px-4"> {{ $citizen->pivot->note }}</td>
                        <td class="w-1/7 py-3 px-4">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded update-button" data-id="{{ $citizen->pivot->id }}">
                            Update
                        </button>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h2> no citizns exist</h2>
            @endif
    </div>

@endsection