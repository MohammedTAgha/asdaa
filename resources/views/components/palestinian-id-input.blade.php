<div>
    <div class="row mb-3">
        <label for="{{ $name }}" class="col-sm-3 col-form-label text-sm-end">{{ $label }}</label>
        <div class="col-sm-7">
            <input type="text" 
                id="{{ $name }}" 
                name="{{ $name }}" 
                class="form-control palestinian-id" 
                value="{{ $value }}" 
                {{ $required ? 'required' : '' }}>
            <div class="invalid-feedback">رقم غير صحيح: الطول يجب ان يكون 9 ارقام</div>
            <div class="valid-feedback">الهوية صحيحة</div>
        </div>
        <div class="col-sm-2">
            <button type="button" class="btn btn-primary search-by-id" disabled>بحث</button>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    // ID validation function
    function validatePalestinianID(idInput) {
        const id = idInput.value;

        idInput.classList.remove('is-invalid', 'is-valid');
        idInput.closest('.row').querySelector('.invalid-feedback').textContent = '';
        idInput.closest('.row').querySelector('.valid-feedback').textContent = '';

        if (id.length === 9 && /^\d{9}$/.test(id)) {
            let sum = 0;
            for (let i = 0; i < 8; i++) {
                let digit = parseInt(id[i]);
                if (i % 2 === 0) {
                    sum += digit;
                } else {
                    let doubled = digit * 2;
                    sum += doubled > 9 ? doubled - 9 : doubled;
                }
            }

            let checkDigit = (10 - (sum % 10)) % 10;
            if (checkDigit === parseInt(id[8])) {
                idInput.classList.add('is-valid');
                idInput.closest('.row').querySelector('.valid-feedback').textContent = 'الهوية صحيحة!';
                return true;
            } else {
                idInput.classList.add('is-invalid');
                idInput.closest('.row').querySelector('.invalid-feedback').textContent = 'الهوية غير صالحة!';
                return false;
            }
        } else if (id.length > 0) {
            idInput.classList.add('is-invalid');
            idInput.closest('.row').querySelector('.invalid-feedback').textContent = 'يجب ان يكون الطول 9 خانات ';
            return false;
        }
        return false;
    }

    // Function to search and fill person details    function searchAndFillPersonDetails(input) {
        const searchButton = input.closest('.row').querySelector('.search-by-id');
        searchButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> جاري البحث...';
        searchButton.disabled = true;

        console.log('Starting search for ID:', input.value);        fetch(`/records/search-by-id?id=${input.value}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data);
                if (data.person) {
                    // Fill the form fields
                    document.getElementById('firstname').value = data.person.firstname || '';
                    document.getElementById('secondname').value = data.person.secondname || '';
                    document.getElementById('thirdname').value = data.person.thirdname || '';
                    document.getElementById('lastname').value = data.person.lastname || '';
                    
                    // Handle date of birth formatting
                    if (data.person.date_of_birth) {
                        const parts = data.person.date_of_birth.split('/');
                        if (parts.length === 3) {
                            const formattedDate = `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
                            document.getElementById('date_of_birth').value = formattedDate;
                        }
                    }

                    // Handle gender
                    const genderSelect = document.getElementById('gender');
                    if (genderSelect) {
                        genderSelect.value = data.person.gender === 'ذكر' ? '0' : '1';
                    }

                    // Handle social status
                    const socialStatusSelect = document.getElementById('social_status');
                    if (socialStatusSelect) {
                        socialStatusSelect.value = data.person.social_status || '';
                    }

                    // Handle wife information if available
                    if (data.person.wife_id) {
                        document.getElementById('wife_id').value = data.person.wife_id;
                        document.getElementById('wife_name').value = data.person.wife_name;
                    }
                }            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء البحث عن البيانات');
            })
            .finally(() => {
                console.log('Search completed, resetting button');
                searchButton.innerHTML = 'بحث';
                searchButton.disabled = false;
            });
    }

    // Add validation and search button functionality to all Palestinian ID inputs
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.palestinian-id').forEach(input => {
            const searchButton = input.closest('.row').querySelector('.search-by-id');
            
            input.addEventListener('input', () => {
                const isValid = validatePalestinianID(input);
                searchButton.disabled = !isValid;
            });

            searchButton.addEventListener('click', () => {
                if (validatePalestinianID(input)) {
                    searchAndFillPersonDetails(input);
                }
            });
        });
    });
</script>
@endpush
@endonce