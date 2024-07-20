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
@endsection