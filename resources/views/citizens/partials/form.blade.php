<div class="container mt-4">
    <form id="mainForm">
        <!-- بيانات النازح -->
        <div id="account-details" class="section">
            <div class="content-header">
                <h5 class="mb-0 fs-3">بيانات النازح</h5>
            </div>
            <div class="row g-2">
                <!-- ID -->
                <div class="col-sm-3">
                    <label for="id" class="form-label">الهوية</label>
                    <input type="text" id="id" name="id" class="form-control" required>
                    {{-- <div class="invalid-feedback">Invalid ID: Must be 9 digits long</div> --}}
                    <div id="validationResult" class="mt-3"></div>
                </div>
                <!-- Phone -->
                <div class="col-sm-3">
                    <label for="phone" class="form-label">رقم الهاتف</label>
                    <input type="text" id="phone" name="phone" class="form-control">
                </div>
                <!-- Region -->
                <div class="col-sm-3">
                    <label for="region_id" class="form-label">المنطقة</label>
                    <select id="region_id" name="region_id" class="form-select" required>
                        <option value="">اختر المنطقة</option>
                    </select>
                </div>
            </div>
            <div class="row g-3 mt-3">
                <!-- First Name -->
                <div class="col-sm-3">
                    <label for="firstname" class="form-label">الاسم الاول</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" required>
                </div>
                <!-- Second Name -->
                <div class="col-sm-3">
                    <label for="secondname" class="form-label">الاب</label>
                    <input type="text" name="secondname" id="secondname" class="form-control">
                </div>
                <!-- Third Name -->
                <div class="col-sm-3">
                    <label for="thirdname" class="form-label">الجد</label>
                    <input type="text" name="thirdname" id="thirdname" class="form-control">
                </div>
                <!-- Last Name -->
                <div class="col-sm-3">
                    <label for="lastname" class="form-label">العائلة</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" required>
                </div>
            </div>
            <div class="row g-2 mt-3">
                <!-- Social Status -->
                <div class="col-sm-3">
                    <label for="social_status" class="form-label">الحالة الاجتماعية</label>
                    <select id="social_status" name="social_status" class="form-select">
                        <option value="">غير محدد</option>
                        <option value="0">اعزب</option>
                        <option value="1">متزوج</option>
                        <option value="2">ارمل</option>
                        <option value="3">متعدد</option>
                        <option value="4">مطلق</option>
                        <option value="5">زوجة 1</option>
                        <option value="6">زوجة 2</option>
                        <option value="7">زوجة 3</option>
                        <option value="8">زوجة 4</option>
                    </select>
                </div>
                <!-- Gender -->
                <div class="col-sm-3">
                    <label for="gender" class="form-label">الجنس</label>
                    <select id="gender" name="gender" class="form-select" required>
                        <option value="0">ذكر</option>
                        <option value="1">انثى</option>
                    </select>
                </div>
                <!-- Date of Birth -->
                <div class="col-sm-3">
                    <label for="date_of_birth" class="form-label">تاريخ الميلاد</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control">
                </div>
            </div>
            <div class="mt-3 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" disabled>Previous</button>
                <button type="button" class="btn btn-primary">Next</button>
            </div>
        </div>

        <!-- بيانات الاسرة -->
        <div id="personal-info" class="section">
            <div class="content-header">
                <h6 class="mb-0">بيانات الاسرة</h6>
                <small>ادخل بيانات الاسرة.</small>
            </div>
            <div class="row g-3">
                <!-- Wife ID -->
                <div class="col-sm-4">
                    <label for="wife_id" class="form-label">هوية الزوجة</label>
                    <input type="text" id="wife_id" name="wife_id" class="form-control">
                </div>
                <!-- Wife Name -->
                <div class="col-sm-6">
                    <label for="wife_name" class="form-label">اسم الزوجة</label>
                    <input type="text" id="wife_name" name="wife_name" class="form-control">
                </div>
            </div>
            <div class="row g-3 mt-3">
                <!-- Family Members -->
                <div class="col-sm-2">
                    <label for="family_members" class="form-label">عدد الافراد</label>
                    <input type="number" id="family_members" name="family_members" class="form-control">
                </div>
                <!-- Elderly Count -->
                <div class="col-sm-2">
                    <label for="elderly_count" class="form-label">عدد المسنين</label>
                    <input type="number" id="elderly_count" name="elderly_count" class="form-control">
                </div>
            </div>
            <div class="row g-3 mt-3">
                <!-- Diseases -->
                <div class="col-sm-2">
                    <label for="disease" class="form-label">عدد الامراض المزمنة</label>
                    <input type="number" id="disease" name="disease" class="form-control">
                </div>
                <div class="col-sm-6">
                    <label for="disease_description" class="form-label">تفاصيل الامراض المزمنة</label>
                    <input type="text" id="disease_description" name="disease_description" class="form-control">
                </div>
            </div>
            <div class="row g-3 mt-3">
                <!-- Obstruction -->
                <div class="col-sm-2">
                    <label for="obstruction" class="form-label">عدد الاعاقات</label>
                    <input type="number" id="obstruction" name="obstruction" class="form-control">
                </div>
                <div class="col-sm-6">
                    <label for="obstruction_description" class="form-label">تفاصيل</label>
                    <input type="text" id="obstruction_description" name="obstruction_description"
                        class="form-control">
                </div>
            </div>
            <div class="mt-3 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary">Previous</button>
                <button type="button" class="btn btn-primary">Next</button>
            </div>
        </div>

        <!-- Social Links -->
        <div id="social-links" class="section">
            <div class="content-header">
                <h6 class="mb-0">معلومات أخرى</h6>
            </div>
            <div class="row g-3">
                <!-- Living Status -->
                <div class="col-sm-3">
                    <label for="living_status" class="form-label">حالة السكن</label>
                    <select id="living_status" name="living_status" class="form-select">
                        <option value="">غير محدد</option>
                        <option value="1">سيئ</option>
                        <option value="2">جيد</option>
                        <option value="3">ممتاز</option>
                    </select>
                </div>
                <!-- Job -->
                <div class="col-sm-3">
                    <label for="job" class="form-label">العمل</label>
                    <select id="job" name="job" class="form-select">
                        <option value="">غير محدد</option>
                        <option value="1">لا يعمل</option>
                        <option value="2">عامل</option>
                        <option value="3">موظف</option>
                    </select>
                </div>
                <!-- Original Address -->
                <div class="col-sm-8">
                    <label for="original_address" class="form-label">عنوان السكن الأصلي</label>
                    <input type="text" id="original_address" name="original_address" class="form-control">
                </div>
                <!-- Note -->
                <div class="col-sm-8 mt-3">
                    <label for="note" class="form-label">ملاحظة</label>
                    <textarea id="note" name="note" rows="3" class="form-control"></textarea>
                </div>
            </div>
            <div class="mt-3 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary">Previous</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        const idInput = document.getElementById('id');
        const validationResult = document.getElementById('validationResult');

        function validatePalestinianID(id) {
            if (!/^\d{9}$/.test(id)) {
                return false;
            }

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
            return checkDigit === parseInt(id[8]);
        }

        function displayValidationResult(isValid) {
            if (isValid) {
                validationResult.innerHTML = '<div class="alert alert-success">Valid Palestinian ID</div>';
            } else {
                validationResult.innerHTML = '<div class="alert alert-danger">Invalid Palestinian ID</div>';
            }
        }

        idInput.addEventListener('input', function() {
            if (this.value.length === 9) {
                const isValid = validatePalestinianID(this.value);
                displayValidationResult(isValid);
            } else {
                validationResult.innerHTML = '';
            }
        });

        idInput.addEventListener('blur', function() {
            if (this.value.length > 0) {
                const isValid = validatePalestinianID(this.value);
                displayValidationResult(isValid);
            }
        });
    </script>
@endpush
