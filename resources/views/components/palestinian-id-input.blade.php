<div>
    <div class="row mb-3">
        <label for="{{ $name }}" class="col-sm-3 col-form-label text-sm-end">{{ $label }}</label>
        <div class="col-sm-9">
            <input type="text" 
                id="{{ $name }}" 
                name="{{ $name }}" 
                class="form-control palestinian-id" 
                value="{{ $value }}" 
                {{ $required ? 'required' : '' }}>
            <div class="invalid-feedback">رقم غير صحيح: الطول يجب ان يكون 9 ارقام</div>
            <div class="valid-feedback">الهوية صحيحة</div>
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

    // Add validation to all Palestinian ID inputs
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.palestinian-id').forEach(input => {
            input.addEventListener('input', () => validatePalestinianID(input));
            input.addEventListener('blur', () => validatePalestinianID(input));
        });
    });
</script>
@endpush
@endonce