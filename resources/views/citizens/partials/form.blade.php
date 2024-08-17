{{-- styles to be added  --}}

{{-- <link rel="stylesheet" href="../../assets/vendor/libs/flatpickr/flatpickr.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" /> --}}


<div class="col-xxl">
    <div class="card mb-4">
        <h5 class="card-header">اضافة نازح جديد</h5>
        <div class="card-body mx-8">
            <h6 class="mb-b fw-semibold">1. بيانات النازح</h6>
            <div class="row mb-3">
                <label for="id" class="col-sm-3 col-form-label text-sm-end">الهوية</label>
                <div class="col-sm-9">
                    <input type="text" id="id" name="id" class="form-control" required>
                    <div class="invalid-feedback">رقم غير صحيح: الطول يجب ان يكون 9 ارقام</div>
                    <div class="valid-feedback">الهوية صحيحة</div>
                </div>
            </div>
            {{-- name --}}
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label text-sm-end">الاسم </label>
                <div class="col-sm-2">
                    <label for="firstname" class="form-label">الاسم الاول</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" required>
                </div>
                <!-- Second Name -->
                <div class="col-sm-2">
                    <label for="secondname" class="form-label">الاب</label>
                    <input type="text" name="secondname" id="secondname" class="form-control">
                </div>
                <!-- Third Name -->
                <div class="col-sm-2">
                    <label for="thirdname" class="form-label">الجد</label>
                    <input type="text" name="thirdname" id="thirdname" class="form-control">
                </div>
                <!-- Last Name -->
                <div class="col-sm-2">
                    <label for="lastname" class="form-label">العائلة</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" required>
                </div>
            </div>
            {{-- 3 --}}
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label text-sm-end">الحالة </label>
                <div class="col-sm-3">
                    <label for="social_status" class="form-label">الحالة الاجتماعية</label>
                    <select id="social_status" name="social_status" class="select2 form-select" data-allow-clear="true">
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
                <!-- Second Name -->
                <div class="col-sm-2">
                    <label for="gender" class="form-label">الجنس</label>
                    <select id="gender" name="gender" class="form-select" required>
                        <option value="0">ذكر</option>
                        <option value="1">انثى</option>
                    </select>
                </div>
                <!-- Third Name -->
                <div class="col-sm-3">
                    <label for="date_of_birth" class="form-label">تاريخ الميلاد</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control">
                </div>
            </div>

            {{-- المنطقة  --}}
            <div class="row mb-3">
                <label for="wife_id" class="col-sm-3 col-form-label text-sm-end"> المنطقة</label>
                <div class="col-sm-9">
                    <select id="region_id" name="region_id"
                    class="w-full border-gray-300 w-full px-4 py-2 border rounded-md" required>
                    <option value="">اختر المنطقة</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
                </div>
            </div>

            <hr class="my-4 mx-n4" />
            <h6 class="mb-3 fw-semibold">2. بيانات الاسرة</h6>

            {{-- الزوجة  --}}
            <div class="row mb-3">
                <label for="wife_id" class="col-sm-3 col-form-label text-sm-end">هوية الزوجة</label>
                <div class="col-sm-9">
                    <input type="text" id="wife_id" name="wife_id" class="form-control">
                </div>
            </div>

            {{-- الزوجة هوية --}}
            <div class="row mb-3">
                <label for="wife_name" class="col-sm-3 col-form-label text-sm-end">اسم الزوجة</label>
                <div class="col-sm-9">
                    <input type="text" id="wife_name" name="wife_name" class="form-control">
                </div>
            </div>

            {{-- عدد  --}}
            <div class="row mb-3">
                <!-- Family Members -->
                <label class="col-sm-3 col-form-label text-sm-end">عدد الاسرة </label>
                <div class="col-sm-2">
                    <label for="family_members" class="form-label">عدد الافراد</label>
                    <input type="number" id="family_members" name="family_members" class="form-control">
                </div>
                <!-- mails_count -->
                <div class="col-sm-2">
                    <label for="mails_count" class="form-label">عدد الذكور </label>
                    <input type="number" id="mails_count" name="mails_count" class="form-control">
                </div>
                <!--femails_count -->
                <div class="col-sm-2">
                    <label for="femails_count" class="form-label">عدد الاناث</label>
                    <input type="number" id="femails_count" name="femails_count" class="form-control">
                </div>
            </div>
            {{-- عدد  --}}
            <div class="row mb-3">
                <!-- leesthan3  -->
                <label class="col-sm-3 col-form-label text-sm-end">الاعمار </label>
                <div class="col-sm-2">
                    <label for="leesthan3" class="form-label">اقل من 3 سنوات </label>
                    <input type="number" id="leesthan3" name="leesthan3" class="form-control">
                </div>
                <!-- mails_count -->
                <div class="col-sm-2">
                    <label for="elderly_count" class="form-label">عدد المسنين </label>
                    <input type="number" id="elderly_count" name="elderly_count" class="form-control">
                </div>
            </div>

            {{-- المزمنة  --}}
            <div class="row mb-3">

                <label class="col-sm-3 col-form-label text-sm-end">امراض مزمنة </label>
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

            {{-- اعاقات  --}}
            <div class="row mb-3">

                <label class="col-sm-3 col-form-label text-sm-end">اعاقات </label>
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

            {{-- بيانات اخرى --}}

            <hr class="my-4 mx-n4" />
            <h6 class="mb-3 fw-semibold">3. بيانات اخرى </h6>

            <!-- Living Status -->
            <div class="row mb-3 select2-primary">
                <label for="living_status" class="col-sm-3 col-form-label text-sm-end">حالة السكن</label>
                <div class="col-sm-9">
                    <select id="living_status" name="living_status" class="form-select">
                        <option value="">غير محدد</option>
                        <option value="1">سيئ</option>
                        <option value="2">جيد</option>
                        <option value="3">ممتاز</option>
                    </select>

                </div>
            </div>

            <!-- Job -->
            <div class="row mb-3">
                <label for="job" class="col-sm-3 col-form-label text-sm-end">العمل</label>
                <div class="col-sm-9">
                    <select id="job" name="job" class="form-select">
                        <option value="">غير محدد</option>
                        <option value="1">لا يعمل</option>
                        <option value="2">عامل</option>
                        <option value="3">موظف</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="original_address" class="col-sm-3 col-form-label text-sm-end">عنوان السكن الأصلي</label>
                <div class="col-sm-9">
                    <input type="text" id="original_address" name="original_address" class="form-control">
                </div>
            </div>

            <!-- Note -->
            <div class="row mb-3">
                <label for="original_address" class="col-sm-3 col-form-label text-sm-end">عنوان السكن الأصلي</label>
                <div class="col-sm-9">
                    <input type="text" id="original_address" name="original_address" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-9">
                    <label for="note" class="col-sm-3 col-form-label text-sm-end"> ملاحظة</label>
                    <textarea id="note" name="note" rows="3" class="form-control"></textarea>
                </div>
            </div>
        </div>



        <div class="pt-4">
            <div class="row justify-content-end">
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary me-sm-2 me-1">Submit</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@push('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


    <script>
        // Validation for Palestinian ID
        document.getElementById('id').addEventListener('input', validateID);
        document.getElementById('id').addEventListener('blur', validateID);

        function validateID() {
            const idInput = document.getElementById('id');
            const id = idInput.value;

            idInput.classList.remove('is-invalid', 'is-valid');
            document.querySelector('#id ~ .invalid-feedback').textContent = '';
            document.querySelector('#id ~ .valid-feedback').textContent = '';

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
                    document.querySelector('#id ~ .valid-feedback').textContent = 'ID is valid!';
                } else {
                    idInput.classList.add('is-invalid');
                    document.querySelector('#id ~ .invalid-feedback').textContent = 'Invalid ID!';
                }
            } else if (id.length > 0) {
                idInput.classList.add('is-invalid');
                document.querySelector('#id ~ .invalid-feedback').textContent = 'Invalid ID: Must be 9 digits long';
            }
        }
    </script>
@endpush
