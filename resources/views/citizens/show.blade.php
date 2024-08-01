@extends('dashboard')

@section('content')
    <div class="container mx-auto px-4">
        <!-- Modal -->
       
        <div id="addCitizenModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
            <div class="bg-white p-6 rounded-md shadow-md w-1/3">
                <h2 class="text-lg font-semibold mb-4">اختر الكشف</h2>
              
                    <input type="hidden" name="citizen_ids" id="citizen-ids">

                    <select id="distributionSelect" class="form-select mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <!-- Options will be populated dynamically -->
                    </select>   
                       
                    <div class="flex justify-end mt-4">
                    <!-- <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="addCitizenToDistribution()">
                            تأكيد
                        </button>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" onclick="hideModal()">
                            إلغاء
                        </button> -->
                        <button type="button" class="px-4 py-2 bg-gray-600 text-white rounded-md mr-2" id="close-modal" onclick="hideModal()">Cancel</button>
                        <button  type="button" class="px-4 py-2 bg-green-600 text-white rounded-md" onclick="addCitizenToDistribution()">Confirm</button>
                    </div>
                
            </div>
        </div>
        
        <div id="childModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full md:w-1/2">
                    <h2 class="text-2xl font-bold mb-4">{{ $citizen->name }}اضافة  طفل جديد ل </h2>
                    <form id="addChildForm">
                        @csrf
                        <input type="hidden" name="citizen_id" value="{{ $citizen->id }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">الاسم:</label>
                                <input type="text" name="name" id="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">تاريخ الميلاد:</label>
                                <input type="date" name="date_of_birth" id="date_of_birth"  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700">الجنس:</label>
                                <select name="gender" id="gender" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="0">Male</option>
                                    <option value="1">Female</option>
                                </select>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="orphan" id="orphan" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <label for="orphan" class="ml-2 block text-sm text-gray-900">يتيم</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="infant" id="infant" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <label for="infant" class="ml-2 block text-sm text-gray-900">رضيع</label>
                            </div>
                            <div>
                                <label for="bambers_size" class="block text-sm font-medium text-gray-700">حجم الحفاظات:</label>
                                <input type="text" name="bambers_size" id="bambers_size" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="disease" id="disease" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <label for="disease" class="ml-2 block text-sm text-gray-900">المرض</label>
                            </div>
                            <div>
                                <label for="disease_description" class="block text-sm font-medium text-gray-700">وصف المرض :</label>
                                <input type="text" name="disease_description" id="disease_description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="obstruction" id="obstruction" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <label for="obstruction" class="ml-2 block text-sm text-gray-900">يوجد اعاقة</label>
                            </div>
                            <div>
                                <label for="obstruction_description" class="block text-sm font-medium text-gray-700">وصف الاعاقة:</label>
                                <input type="text" name="obstruction_description" id="obstruction_description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label for="note" class="block text-sm font-medium text-gray-700">ملاحظات:</label>
                                <textarea name="note" id="note" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">اضافة طفل</button>
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-md" onclick="hideChildModal()">الغاء</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

  <!-- show.blade.php -->
    @component('components.box',['title'=>'بيانات النازح'.' '.  $citizen->secondname . ' ' .$citizen->thirdname. ' ' .$citizen->lastname,'styles'=>'mt-8'])
            @slot('side')
                <div class="mt-6">
                    <a href="{{ route('citizens.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">Back to List</a>
                    <a href="{{ route('citizens.edit', $citizen->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md">Edit</a>
                </div>
            @endslot

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700"><strong>الهوية</strong></label>
                    <p class="mt-1 text-gray-900">{{ $citizen->id }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">الاسم</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->firstname . " " .  $citizen->secondname . ' ' .$citizen->thirdname. ' ' .$citizen->lastname }} </p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">تاريخ الميلاد</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->date_of_birth }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">الجنس</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->gender == '0' ? 'ذكر' : 'انثى' }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">اسم الزوجة</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->wife_name }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">رقم الزوجة</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->wife_id }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">المنطقة</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->region->name }} و مندوبه {{ $citizen->region->representatives->first()->name ?? 'غير محدد' }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">ارمل</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->widowed ? 'نعم' : 'a لا ' }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">الحالة الاجتماعبة</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->social_status }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">الحالة المعيشية</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->living_status }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">العمل</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->job }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">العنوان الاصلي</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->original_address }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">عدد كبار السن</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->elderly_count }}</p>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">ملاحطة</label>
                    <p class="mt-1 text-gray-900">{{ $citizen->note }}</p>
                </div>
            </div>
          
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
                    <th class="w-40px py-3 px-4 uppercase font-semibold text-sm">رقم</th>
                    <th class="w-140px py-3 px-4 uppercase font-semibold text-sm">الوصف</th>
                    <th class="w-90px py-3 px-4 uppercase font-semibold text-sm">المزود</th>
                    <th class="w-40px py-3 px-4 uppercase font-semibold text-sm">الكمية المستلمة</th>
                    <th class="w-50px py-3 px-4 uppercase font-semibold text-sm">استلم</th>
                    <th class="w-100px py-3 px-4 uppercase font-semibold text-sm">اسم المستلم</th>
                    <th class="w-120px py-3 px-4 uppercase font-semibold text-sm">تاريخ الاستلام</th>
                    <th class="w-150px py-3 px-4 uppercase font-semibold text-sm">ملاحظة </th>
                    <th class="w-100px py-3 px-4 uppercase font-semibold text-sm"> - </th>

                </tr>
            </thead>
            <tbody class="text-gray-700">  
            @foreach($distributions as $distribution)
                <tr>
                    <td class=" py-3 px-4">
                        <a href="{{ route('distributions.show', $distribution->id) }}" class="text-blue-600 hover:underline">
                        {{ $distribution->pivot->id }}
                        </a> 
                    </td> 
                 
                    <td class=" py-3 px-4">
                    <a href="{{ route('distributions.show', $distribution->id) }}" class="text-blue-600 hover:underline">
                    {{ $distribution->name }}
                    </a>
                </td>
                 
                    <td class=" py-3 px-4">{{ $distribution->source }}</td>
                    <td class=" py-3 px-4">
                        <input type="number" name="quantity" value="{{ $distribution->pivot->quantity }}" id="quantity">
                    </td>
                    <td class="w-90px py-3 px-4">
                    <input type="checkbox" name="done" value="{{ $distribution->pivot->done }}" {{ $distribution->pivot->done ? 'checked' : '' }}>
                    </td>
                    <td class=" py-3 px-4">
                    <input  name="recipient" value="{{ $distribution->pivot->recipient }}" id="recipient">
                    </td>
                    <td class=" py-3 px-4">
                        <input type="date" name="date" value="{{ $distribution->pivot->date }}">
                    </td>
                    <td class=" py-3 px-4"> 
                        <input  name="note" id="note" value="{{ $distribution->pivot->note }}">

                    </td>
                    <td class="flex-1  py-3 px-4" >
                        <button class="update-button" data-id="{{ $distribution->pivot->id }}" style="color: blue;">
                        <i class="fas fa-upload" style="color: green;"></i>
                        </button>

                        <a href="#" onclick="removeCitizenFromDistribution({{ $distribution->pivot->id }})" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash-alt" style="color: red;"></i>
                        </a>                    
                     </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <h2>لم يستلم يعد</h2>
        @endif

@endcomponent

    @component('components.box',['title'=>'الابناء','styles'=>'mt-4'])
        @slot('side')
           <!-- Button to trigger modal -->
            <button class="px-4 py-2 bg-blue-600 text-white rounded-md" onclick="showChildModal()">Add Child</button>
        @endslot
        
        <div   class="mt-4">
        <table id="childrenTable" class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">الاسم</th>
                    <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">العمر</th>
                    <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">الجنس</th>
                    <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                </tr>
            </thead>
            <tbody  id='childrenList'>
            @if (!$citizen->children->isEmpty())
                @foreach($citizen->children as $child)
                <tr data-id="{{ $child->id }}">
                    <td>{{ $child->name }}</td>
                    <td>{{ $child->date_of_birth }}</td>
                    <td>{{ $child->gender }}</td>
                    <td>
                        <a href="{{ route('children.edit' , $child->id) }}">
                            <button class="edit-button bg-blue-500 text-white px-3 py-1 rounded-md mr-2" data-id="{{ $child->id }}">Edit</button>
                        </a>
                        <button class="delete-button bg-red-500 text-white px-3 py-1 rounded-md" data-id="{{ $child->id }}">Delete</button>
                    </td>
                </tr>
                @endforeach
                @else
                    <h2>لم يتم تسجيل اطفال </h2>
                @endif
            </tbody>
        </table>
                </div>
                
    @endcomponent




</div>
  



</body>
<script>

    function showModal() {
    document.getElementById('addCitizenModal').classList.remove('hidden');
    // Optionally, populate the distribution select options here
}

function hideModal() {
    document.getElementById('addCitizenModal').classList.add('hidden');
}
function showChildModal() {
        document.getElementById('childModal').classList.toggle('hidden');
}
function hideChildModal() {
        document.getElementById('childModal').classList.toggle('hidden');
}

// addin cild frome ere
document.getElementById('addChildForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let formData = new FormData(this);
    fetch('{{ route('children.store') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log(`data`,data);
            let child = data.child;
            let childrenList = document.getElementById('childrenList');
            let newChild = document.createElement('tr');
            newChild.innerHTML = `
                <tr data-id="${child.id}">
                        <td>${child.name}</td>
                        <td>${child.date_of_birth}</td>
                        <td>${child.gender}</td>
                        <td>
                            
                            <button class="delete-button bg-red-500 text-white px-3 py-1 rounded-md" data-id="${child.id}">Delete</button>
                        </td>
                </tr>

            `;
            childrenList.appendChild(newChild);

            // Clear the form
            document.getElementById('addChildForm').reset();
            hideChildModal();
        } else {
            alert('An error occurred while adding the child.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
    });
});

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
            distributionId: distributionId
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
    fetch(`/distributions/pivot/${id}`, {
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

document.querySelector('#childrenTable').addEventListener('click', function(event) {
    if (event.target.classList.contains('edit-button')) {
        let childId = event.target.dataset.id;
        let row = event.target.closest('tr');
        let name = row.querySelector('td:nth-child(1)').textContent;
        let dateOfBirth = row.querySelector('td:nth-child(2)').textContent;
        let gender = row.querySelector('td:nth-child(3)').textContent;

        document.querySelector('#addChildForm [name="name"]').value = name;
        document.querySelector('#addChildForm [name="date_of_birth"]').value = dateOfBirth;
        document.querySelector('#addChildForm [name="gender"]').value = gender === 'Male' ? 'male' : 'female';
        document.getElementById('addChildForm').dataset.editingId = childId;
        document.querySelector('#addChildForm button[type="submit"]').textContent = 'Update Child';
    }

    if (event.target.classList.contains('delete-button')) {
        let childId = event.target.dataset.id;
        fetch(`/children/${childId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                event.target.closest('tr').remove();
            } else {
                alert('An error occurred while deleting the child.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    }
});
</script>
<script src="{{ asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
    // Initialize Select2
    $('#prepositives').select2({
        placeholder: "Select Prepositives",
        allowClear: true
    });

    // Handle Apply button click
    $('#applyFilters').on('click', function() {
        let filters = {
            prepositives: $('#prepositives').val(),
            living_status: $('#living_status').val(),
            social_status: $('#social_status').val(),
            gender: $('#gender').val()
        };

        // Make an AJAX request to apply the filters (adjust the URL and method as needed)
        $.ajax({
            url: '/path/to/filter/endpoint', // Replace with your endpoint
            method: 'GET', // or 'POST' if needed
            data: filters,
            success: function(response) {
                // Handle the response to update the citizens list
                console.log(response);
                // Update the citizens list on the page using the response data
            },
            error: function(xhr) {
                console.error('Error applying filters:', xhr);
            }
        });
    });
});
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
            console.log('click')
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
                    alert('تم تحديث');
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