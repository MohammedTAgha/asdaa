<!--begin::Modal-->
<div class="modal fade" id="recordsSearchModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">بحث في السجلات</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-1"></i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="recordsSearchForm" class="form" action="{{ route('records.general-search') }}" method="POST">
                    @csrf
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">رقم الهوية</label>
                        <input type="text" name="id_number" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="ادخل رقم الهوية"/>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fw-semibold fs-6 mb-2">الاسم الاول</label>
                            <input type="text" name="first_name" class="form-control form-control-solid" placeholder="الاسم الاول"/>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fw-semibold fs-6 mb-2">اسم الاب</label>
                            <input type="text" name="father_name" class="form-control form-control-solid" placeholder="اسم الاب"/>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fw-semibold fs-6 mb-2">اسم الجد</label>
                            <input type="text" name="grandfather_name" class="form-control form-control-solid" placeholder="اسم الجد"/>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fw-semibold fs-6 mb-2">اسم العائلة</label>
                            <input type="text" name="family_name" class="form-control form-control-solid" placeholder="اسم العائلة"/>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="submit" class="btn btn-primary" data-kt-indicator="off">
                            <span class="indicator-label">بحث</span>
                            <span class="indicator-progress">جاري البحث...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->

                <!--begin::Results-->
                <div id="searchResults" class="mt-10 d-none">
                    <div class="separator separator-dashed my-5"></div>
                    <h3 class="fw-bold mb-5">نتائج البحث</h3>
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                            <thead>
                                <tr class="fw-bold text-muted">
                                    <th>رقم الهوية</th>
                                    <th>الاسم</th>
                                    <th>المصدر</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody id="searchResultsBody">
                                <!-- Results will be populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Results-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal-->

@push('scripts')
<script>
    // Initialize the modal
    const recordsSearchModal = new bootstrap.Modal(document.getElementById('recordsSearchModal'));

    // Handle form submission
    document.getElementById('recordsSearchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const submitButton = form.querySelector('button[type="submit"]');
        const resultsDiv = document.getElementById('searchResults');
        const resultsBody = document.getElementById('searchResultsBody');
        
        // Show loading state
        submitButton.setAttribute('data-kt-indicator', 'on');
        
        // Get form data
        const formData = new FormData(form);
        
        // Send AJAX request
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Hide loading state
            submitButton.setAttribute('data-kt-indicator', 'off');
            
            // Clear previous results
            resultsBody.innerHTML = '';
            
            // Show results section
            resultsDiv.classList.remove('d-none');
            
            // Populate results
            data.results.forEach(result => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${result.id}</td>
                    <td>${result.name}</td>
                    <td>
                        <span class="badge badge-light-${getSourceBadgeColor(result.source)}">
                            ${getSourceLabel(result.source, result.relationship)}
                        </span>
                    </td>
                    <td>
                        <a href="${result.details_url}" class="btn btn-sm btn-light-primary">
                            عرض التفاصيل
                        </a>
                    </td>
                `;
                resultsBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            submitButton.setAttribute('data-kt-indicator', 'off');
        });
    });

    // Reset form and results when modal is closed
    document.getElementById('recordsSearchModal').addEventListener('hidden.bs.modal', function () {
        const form = document.getElementById('recordsSearchForm');
        const resultsDiv = document.getElementById('searchResults');
        const submitButton = form.querySelector('button[type="submit"]');
        
        form.reset();
        resultsDiv.classList.add('d-none');
        submitButton.setAttribute('data-kt-indicator', 'off');
    });

    // Helper functions for source display
    function getSourceBadgeColor(source) {
        switch(source) {
            case 'citizen':
                return 'primary';
            case 'family_member':
                return 'warning';
            case 'person':
                return 'success';
            default:
                return 'info';
        }
    }

    function getSourceLabel(source, relationship) {
        switch(source) {
            case 'citizen':
                return 'قاعدة البيانات';
            case 'family_member':
                return `عضو عائلة (${getRelationshipLabel(relationship)})`;
            case 'person':
                return 'السجل المدني';
            default:
                return source;
        }
    }

    function getRelationshipLabel(relationship) {
        const labels = {
            'father': 'أب',
            'mother': 'أم',
            'son': 'ابن',
            'daughter': 'ابنة',
            'other': 'آخر'
        };
        return labels[relationship] || relationship;
    }
</script>
@endpush 