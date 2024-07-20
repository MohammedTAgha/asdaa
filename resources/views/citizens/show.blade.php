@extends('dashboard')

@section('content')
<div class="container mx-auto px-4">
  <!-- show.blade.php -->
  
    <div class="bg-white shadow-md rounded-lg p-6 mb-4">
        <h1 class="text-2xl font-bold mb-6">Citizen Details</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">ID</label>
                <p class="mt-1 text-gray-900">{{ $citizen->id }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <p class="mt-1 text-gray-900">{{ $citizen->name }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                <p class="mt-1 text-gray-900">{{ $citizen->date_of_birth }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Gender</label>
                <p class="mt-1 text-gray-900">{{ $citizen->gender }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Region</label>
                <p class="mt-1 text-gray-900">{{ $citizen->region->name }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Wife ID</label>
                <p class="mt-1 text-gray-900">{{ $citizen->wife_id }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Wife Name</label>
                <p class="mt-1 text-gray-900">{{ $citizen->wife_name }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Widowed</label>
                <p class="mt-1 text-gray-900">{{ $citizen->widowed ? 'Yes' : 'No' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Social Status</label>
                <p class="mt-1 text-gray-900">{{ $citizen->social_status }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Living Status</label>
                <p class="mt-1 text-gray-900">{{ $citizen->living_status }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Job</label>
                <p class="mt-1 text-gray-900">{{ $citizen->job }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Original Address</label>
                <p class="mt-1 text-gray-900">{{ $citizen->original_address }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Elderly Count</label>
                <p class="mt-1 text-gray-900">{{ $citizen->elderly_count }}</p>
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Note</label>
                <p class="mt-1 text-gray-900">{{ $citizen->note }}</p>
            </div>
        </div>
        
        <div class="mt-6">
            <a href="{{ route('citizens.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">Back to List</a>
            <a href="{{ route('citizens.edit', $citizen->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md">Edit</a>
        </div>
    </div>


    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">الابناء</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">التوزيع</h1>
        @php
        $distributions = $citizen->distributions
        @endphp
        @if (!$distributions->isEmpty())
        <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">رقم</th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">الوصف</th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">المزود</th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">الكمية المستلمة</th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">استلم</th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">اسم المستلم</th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">تاريخ الاستلام</th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm">ملاحظة </th>
                        <th class="w-1/7 py-3 px-4 uppercase font-semibold text-sm"> </th>

                    </tr>
                </thead>
                <tbody class="text-gray-700">  
                @foreach($distributions as $distribution)
                    <tr>
                        <td class="w-1/7 py-3 px-4">
                            <a href="{{ route('distributions.show', $distribution->id) }}" class="text-blue-600 hover:underline">
                            {{ $distribution->pivot->id }}
                            </a> 
                        </td> 
                     
                        <td class="w-1/7 py-3 px-4">
                        <a href="{{ route('distributions.show', $distribution->id) }}" class="text-blue-600 hover:underline">
                        {{ $distribution->name }}
                        </a>
                    </td>
                     
                        <td class="w-1/7 py-3 px-4">{{ $distribution->source }}</td>
                        <td class="w-1/7 py-3 px-4">
                            <input type="number" name="quantity" value="{{ $distribution->pivot->quantity }}" id="quantity">
                        </td>
                        <td class="w-1/7 py-3 px-4">
                        <input type="checkbox" name="done" value="{{ $distribution->pivot->done }}" {{ $distribution->pivot->done ? 'checked' : '' }}>
                        </td>
                        <td class="w-1/7 py-3 px-4">
                        <input  name="recipient" value="{{ $distribution->pivot->recipient }}" id="recipient">
                        </td>
                        <td class="w-1/7 py-3 px-4">
                            <input type="date" name="date" value="{{ $distribution->pivot->date }}">
                        </td>
                        <td class="w-1/7 py-3 px-4"> 
                            <input  name="note" id="note" value="{{ $distribution->pivot->note }}">

                        </td>
                        <td class="w-1/7 py-3 px-4">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded update-button" data-id="{{ $distribution->pivot->id }}">
                            Update
                        </button>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h2>لم يستلم يعد</h2>
            @endif
    </div>


</div>
    <h2 class="text-xl font-semibold mt-6">Children</h2>
    <ul class="list-disc ml-5">
        @foreach($citizen->children as $child)
            <li>{{ $child->name }} ({{ $child->age() }} years old)</li>
        @endforeach
    </ul>

    <h3 class="text-xl font-semibold mt-6">Add a Child</h3>
    <form action="{{ route('children.store') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="citizen_id" value="{{ $citizen->id }}">
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name:</label>
            <input type="text" id="name" name="name" required class="mt-1 block w-full rounded border-gray-300">
        </div>
        <div class="mb-4">
            <label for="date_of_birth" class="block text-gray-700">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" required class="mt-1 block w-full rounded border-gray-300">
        </div>
        <div class="mb-4">
            <label for="gender" class="block text-gray-700">Gender:</label>
            <select id="gender" name="gender" required class="mt-1 block w-full rounded border-gray-300">
                <option value="0">Male</option>
                <option value="1">Female</option>
            </select>
        </div>
        <!-- Add other child fields as needed -->
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Child</button>
    </form>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Set CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.update-button').click(function() {
            var pivotId = $(this).data('id');
            var selectedDate = $(this).closest('tr').find('input[name="date"]').val();
            var quantity = $(this).closest('tr').find('input[name="quantity"]').val();
            var recipient = $(this).closest('tr').find('input[name="recipient"]').val();
            var note = $(this).closest('tr').find('input[name="note"]').val();

            var isChecked = $(this).closest('tr').find('input[name="done"]').prop('checked');
            var data = isChecked ? 1 : 0;
            
            $.ajax({
                url: '/update-pivot',
                method: 'POST',
                data: {
                    pivotId: pivotId,
                    isChecked: data,
                    selectedDate: selectedDate,
                    quantity: quantity,
                    recipient:recipient,
                    note:note,
                },
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    alert('Pivot updated successfully');
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText);
                    alert('Failed to update pivot');
                }
            });
        });
    });
</script>
@endsection