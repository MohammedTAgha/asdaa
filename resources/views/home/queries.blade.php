
@extends('dashboard')

@section('content')
    <livewire:citizen-search />
    @push('scripts')
        <script>
            const modal = new bootstrap.Modal(document.getElementById('citizenModal'));
            console.log('ccc');
            $(document).ready(function() {
                $('#submitButton').click(function() {
                    console.log('ccc');
                    var id = $('#id').val();
                    var first_name = $('#first_name').val();
                    var second_name = $('#second_name').val();
                    var third_name = $('#third_name').val();
                    var last_name = $('#last_name').val();

                    $.ajax({
                        url: '/citizens', // Use the resource route for citizens
                        type: 'GET',
                        data: {
                            id: id,
                            first_name: first_name,
                            second_name: second_name,
                            third_name: third_name,
                            last_name: last_name,
                            returnjson: 1,
                        },
                        success: function(response) {
                            // Handle the response data here
                            //document.getElementById('modal').classList.remove('hidden');
                            modal.show();
                            console.log(response);
                            const cardsContainer = document.getElementById('cardsContainer');
                            cardsContainer.innerHTML = ''; // Clear previous content
                            response.forEach(citizen => {
                                const card = document.createElement('div');
                                card.className = 'p-4 bg-gray-100 rounded-lg shadow';
                                card.innerHTML = `
                                <div>
                                <a href="/citizens/${citizen.id}">
                                <p><strong>الهوية:</strong> ${citizen.id}</p>
                                <p><strong>الاسم:</strong> ${citizen.firstname} ${citizen.secondname} ${citizen.thirdname} ${citizen.lastname}</p>
                                <p><strong>تاريخ الميلاد:</strong> ${citizen.date_of_birth}</p>
                                <p><strong>الجنس:</strong> ${citizen.gender}</p>
                                <p><strong>الزوجة:</strong> ${citizen.wife_name}</p>
                                <p><strong>رقم المنقطة:</strong> ${citizen.region_id}</p>
                                <p><strong>العمل:</strong> ${citizen.job}</p>
                                <p><strong>الحالة الاجتماعية:</strong> ${citizen.living_status}</p>
                                <p><strong>Note:</strong> ${citizen.note}</p>
                                </div>
                                </a>
                            `;
                                cardsContainer.appendChild(card);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });
            });

            document.getElementById('closeModalButton').addEventListener('click', function() {
                document.getElementById('modal').classList.add('hidden');
            });
        </script>
    @endpush
@endsection
