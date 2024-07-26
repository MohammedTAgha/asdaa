@extends('dashboard')

@section('content')
<div class="container mx-auto px-4">
        <!-- Modal -->
        <div id="addCitizenModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    اختر التوزيع
                                </h3>
                                <div class="mt-2">
                                    <select id="distributionSelect" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <!-- Options will be populated dynamically -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="addCitizenToDistribution()">
                            تأكيد
                        </button>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" onclick="hideModal()">
                            إلغاء
                        </button>
                    </div>
                </div>
            </div>
        </div>
  <!-- show.blade.php -->
    @component('components.box',['title'=>'بيانات النازح'.' '.$citizen->name,'styles'=>'mt-8'])
            @slot('side')
                <div class="mt-6">
                    <a href="{{ route('citizens.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">Back to List</a>
                    <a href="{{ route('citizens.edit', $citizen->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md">Edit</a>
                </div>
            @endslot

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
          
    @endcomponent

    @component('components.box',['title'=>'الابناء','styles'=>'mt-4'])
        @slot('side')
            <button class="px-4 py-4 bg-blue-600 text-white rounded-md" onclick="showModal()">اضافة</button>
        @endslot
        
    @endcomponent

    @component('components.box',['title'=>'الكشوفات','styles'=>'mt-4'])
    @slot('side')
            <button class="px-4 py-4 bg-blue-600 text-white rounded-md" onclick="showModal()">اضافة</button>
    @endslot
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
                        <td class="flex-1 w-1/7 py-3 px-4" >
                            
                        <button class="update-button" data-id="{{ $distribution->pivot->id }}" style="color: blue;">
                        <i class="fas fa-upload" style="color: green;"></i>
                    </button>

                    <a href="#" onclick="removeCitizenFromDistribution({{ $distribution->pivot->id }})" class="text-red-600 hover:text-red-900">
                        <i class="fas fa-trash-alt" style="color: red;"></i>
                    </a>                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h2>لم يستلم يعد</h2>
            @endif

    @endcomponent



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

<script>

    function showModal() {
    document.getElementById('addCitizenModal').classList.remove('hidden');
    // Optionally, populate the distribution select options here
}

function hideModal() {
    document.getElementById('addCitizenModal').classList.add('hidden');
}
document.addEventListener('DOMContentLoaded', function() {
    fetch('{{ route('getDistributions') }}') // Ensure you have this route
        .then(response => response.json())
        .then(data => {
            const distributionSelect = document.getElementById('distributionSelect');
            data.distributions.forEach(distribution => {
                const option = document.createElement('option');
                option.value = distribution.id;
                option.textContent = distribution.name;
                distributionSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
});
function addCitizenToDistribution() {
    const citizenId = {{ $citizen->id }}; // Assuming you have the citizen ID in the Blade template
    const distributionId = document.getElementById('distributionSelect').value;
    console.log(citizenId)
    console.log(distributionId)

    fetch('{{ route('distributions.addCitizens') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            citizen_ids: [citizenId].join(','),
            distribution_id: distributionId
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('data')
        console.log(data)
        
        if (data.success) {
            alert('تمت الاضفاة');
        } else if (data.existing_citizens) {
            alert('موجود مسبقا ');
        } else {
            alert('خطا');
        }
        hideModal();
    })
    .catch(error => {

        hideModal();
    });
}

function removeCitizenFromDistribution(id) {
    fetch(`{{ route('distributions.removeCitizen',$distribution->pivot->id)}}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Citizen removed successfully!');
            // Optionally, you can update the UI to reflect the deletion
        } else {
            alert('An error occurred while removing the citizen.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
    });
}
</script>
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