<div class="container mt-4">
    <h2>Citizen Search</h2>
    <form wire:submit.prevent="searchCitizen" class="mb-4">
        <div class="form-group">
            <label for="searchId">ادخل رقم الهوية:</label>
            <input type="text" id="searchId" wire:model.debounce.300ms="searchId" class="form-control @error('searchId') is-invalid @elseif($isValid) is-valid @enderror" placeholder="Enter 9-digit ID">
            @error('searchId')
                <div class="invalid-feedback">{{ $message }}</div>
            @elseif($isValid)
                <div class="valid-feedback">رقم صالح!</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-2">ابحث</button>
    </form>

    @if($errorMessage)
        <div class="alert alert-danger">{{ $errorMessage }}</div>
    @endif

    @if($citizen)
        <div class="card">
            <div class="card-header">نتيجة البحث</div>
            <a href="{{route('citizens.show',$citizen->id)}}">
            <div class="card-body">
                <h5 class="card-title">{{ $citizen->firstname}} {{$citizen->secondname}} {{$citizen->thirdname}} {{$citizen->lastname }}</h5>
                <p class="card-text">الهوية: {{ $citizen->id }}</p>
            </div>
            </a>
        </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('citizen-search-updated', () => {
            validateID();
        });

        function validateID() {
            const idInput = document.getElementById('searchId');
            const id = idInput.value;

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
                    idInput.classList.remove('is-invalid');
                } else {
                    idInput.classList.add('is-invalid');
                    idInput.classList.remove('is-valid');
                }
            } else if (id.length > 0) {
                idInput.classList.add('is-invalid');
                idInput.classList.remove('is-valid');
            } else {
                idInput.classList.remove('is-invalid', 'is-valid');
            }
        }

        document.getElementById('searchId').addEventListener('input', validateID);
        document.getElementById('searchId').addEventListener('blur', validateID);
    });
</script>
