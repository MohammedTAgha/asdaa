<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ $searchType === 'id' ? 'active bg-white' : 'text-white' }}" href="#" wire:click="setSearchType('id')">
                        <i class="ti ti-id-badge me-1"></i>بحث بالهوية
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $searchType === 'name' ? 'active bg-white' : 'text-white' }}" href="#" wire:click="setSearchType('name')">
                        <i class="ti ti-user-search me-1"></i>بحث بالإسم
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="searchCitizen" class="mb-4">
                @if ($searchType === 'id')
                    <div class="form-group">
                        <label for="searchId" class="form-label">رقم الهوية:</label>
                        <div class="input-group">
                            <input type="text" id="searchId" 
                                wire:model.debounce.300ms="searchId" 
                                class="form-control text-start {{ $isValid ? 'is-valid' : ($errorMessage ? 'is-invalid' : '') }}" 
                                placeholder="ادخل رقم الهوية (9 أرقام)"
                                maxlength="9"
                                dir="ltr">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-search me-1"></i>بحث
                            </button>
                        </div>
                        @if($errorMessage)
                            <div class="invalid-feedback d-block">{{ $errorMessage }}</div>
                        @endif
                    </div>
                @else
                    <div class="form-group">
                        <label for="searchName" class="form-label">الإسم:</label>
                        <div class="input-group">
                            <input type="text" id="searchName" 
                                wire:model.debounce.300ms="searchName" 
                                class="form-control {{ $errorMessage ? 'is-invalid' : '' }}" 
                                placeholder="ادخل الاسم (3 أحرف على الأقل)">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-search me-1"></i>بحث
                            </button>
                        </div>
                        @if($errorMessage)
                            <div class="invalid-feedback d-block">{{ $errorMessage }}</div>
                        @endif
                    </div>
                @endif
            </form>

            @if(!empty($citizens))
                <div class="table-responsive mt-4">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>رقم الهوية</th>
                                <th>الاسم الكامل</th>
                                <th>المنطقة</th>
                                <th>عدد الأفراد</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($citizens as $citizen)
                                <tr>
                                    <td>{{ $citizen->id }}</td>
                                    <td>{{ $citizen->firstname }} {{ $citizen->secondname }} {{ $citizen->thirdname }} {{ $citizen->lastname }}</td>
                                    <td>{{ $citizen->region->name ?? 'غير محدد' }}</td>
                                    <td>{{ $citizen->family_members }}</td>
                                    <td>
                                        <a href="{{ route('citizens.show', $citizen->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="ti ti-eye me-1"></i>عرض
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif(!$errorMessage && ($searchId || $searchName))
                <div class="alert alert-info mt-4">
                    <i class="ti ti-search me-2"></i>
                    ابدأ البحث باستخدام رقم الهوية أو الاسم
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        // Auto-format ID input
        const idInput = document.getElementById('searchId');
        if (idInput) {
            idInput.addEventListener('input', function(e) {
                let value = e.target.value;
                value = value.replace(/\D/g, '');
                if (value.length > 9) value = value.substr(0, 9);
                e.target.value = value;
            });
        }
    });
</script>
@endpush
