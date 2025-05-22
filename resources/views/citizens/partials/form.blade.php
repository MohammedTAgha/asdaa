{{-- styles to be added  --}}

{{-- <link rel="stylesheet" href="../../assets/vendor/libs/flatpickr/flatpickr.css" />
<link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" /> --}}


<div class="col-xxl">
   
    <div class="card mb-4">
        <h5 class="card-header mt-2 text-xl"> {{isset($citizen) ? 'تعديل موجود' : 'جديد'}} </h5>
        <div class="card-body mx-4">
            <h6 class="mb-b fw-semibold">1. بيانات النازح</h6>
            <x-palestinian-id-input :value="$citizen->id ?? old('id','')" />
            {{-- name --}}
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label text-sm-end">الاسم </label>
                <div class="col-sm-2">
                    <label for="firstname" class="form-label">الاسم الاول</label>
                    <input type="text" value="{{ $citizen->firstname ?? old('firstname','') }}" name="firstname" id="firstname" class="form-control" value="{{ $citizen->id ?? old('id','') }}"  required>
                </div>
                <!-- Second Name -->
                <div class="col-sm-2">
                    <label for="secondname" class="form-label">الاب</label>
                    <input type="text" value="{{ $citizen->secondname ?? old('secondname','') }}" name="secondname" id="secondname" class="form-control">
                </div>
                <!-- Third Name -->
                <div class="col-sm-2">
                    <label for="thirdname" class="form-label">الجد</label>
                    <input type="text" value="{{ $citizen->thirdname ?? old('thirdname','') }}" name="thirdname" id="thirdname" class="form-control">
                </div>
                <!-- Last Name -->
                <div class="col-sm-2">
                    <label for="lastname" class="form-label">العائلة</label>
                    <input type="text" value="{{ $citizen->lastname ?? old('lastname','') }}" name="lastname" id="lastname" class="form-control" required>
                </div>
            </div>
            {{-- 3 --}}
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label text-sm-end">الحالة </label>
                <div class="col-sm-3">
                    <label for="social_status" class="form-label">الحالة الاجتماعية</label>
                    <select id="social_status" name="social_status" class="form-select" data-allow-clear="true">
                        <option value="" >غير محدد</option>
                        <option value="اعزب" {{ isset($citizen) && $citizen->social_status == 'اعزب'? 'selected' : '' }}>اعزب</option>
                        <option value="متزوج" {{ isset($citizen) && $citizen->social_status == 'متزوج'? 'selected' : '' }}>متزوج</option>
                        <option value="ارمل" {{ isset($citizen) && $citizen->social_status == 'ارمل'? 'selected' : '' }}>ارمل</option>
                        <option value="متعدد" {{ isset($citizen) && $citizen->social_status == 'متعدد'? 'selected' : '' }}>متعدد</option>
                        <option value="مطل" {{ isset($citizen) && $citizen->social_status == 'مطلق'? 'selected' : '' }}>مطلق</option>
                        <option value="زوجة 1">زوجة 1 </option>
                        <option value="زوجة 2">زوجة 2 </option>
                        <option value="زوجة 3">زوجة 3 </option>
                        <option value="زوجة 4">زوجة 4 </option>
                    </select>
                </div>
                <!-- Second Name -->
                <div class="col-sm-2">
                    <label for="gender" class="form-label">الجنس</label>
                    <select id="gender" name="gender" class="form-select" required>
                        <option value="0" {{isset($citizen) && $citizen->gender=='0' ? 'selected' : ''}}>ذكر</option>
                        <option value="1" {{isset($citizen) && $citizen->gender=='1' ? 'selected' : ''}}>انثى</option>
                    </select>
                </div>
                <!-- date_of_birth -->
                <div class="col-sm-3">
                    <label for="date_of_birth" class="form-label">تاريخ الميلاد</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ $citizen->date_of_birth ?? old('date_of_birth','') }}" class="form-control">
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
                        <option value="{{ $region->id }}" {{isset($citizen) && $citizen->region_id== $region->id ? 'selected' : ''}}>{{ $region->name }}</option>
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
                    <input value="{{ $citizen->wife_id ?? old('wife_id','') }}" type="text" id="wife_id" name="wife_id" class="form-control">
                </div>
            </div>

            {{-- الزوجة هوية --}}
            <div class="row mb-3">
                <label for="wife_name" class="col-sm-3 col-form-label text-sm-end">اسم الزوجة</label>
                <div class="col-sm-9">
                    <input value="{{ $citizen->wife_name ?? old('wife_name','') }}" type="text" id="wife_name" name="wife_name" class="form-control">
                </div>
            </div>

            {{-- عدد  --}}
            <div class="row mb-3">
                <!-- Family Members -->
                <label class="col-sm-3 col-form-label text-sm-end">عدد الاسرة </label>
                <div class="col-sm-2">
                    <label for="family_members" class="form-label">عدد الافراد</label>
                    <input value="{{ $citizen->family_members ?? old('family_members','') }}" type="number" id="family_members" name="family_members" class="form-control">
                </div>
                <!-- mails_count -->
                <div class="col-sm-2">
                    <label for="mails_count" class="form-label">عدد الذكور </label>
                    <input value="{{ $citizen->mails_count ?? old('mails_count','') }}" type="number" id="mails_count" name="mails_count" class="form-control">
                </div>
                <!--femails_count -->
                <div class="col-sm-2">
                    <label for="femails_count" class="form-label">عدد الاناث</label>
                    <input  value="{{ $citizen->femails_count ?? old('femails_count','') }}" type="number" id="femails_count" name="femails_count" class="form-control">
                </div>
            </div>
            {{-- عدد  --}}
            <div class="row mb-3">
                <!-- leesthan3  -->
                <label class="col-sm-3 col-form-label text-sm-end">الاعمار </label>
                <div class="col-sm-2">
                    <label for="leesthan3" class="form-label">اقل من 3 سنوات </label>
                    <input value="{{ $citizen->leesthan3 ?? old('leesthan3','') }}" type="number" id="leesthan3" name="leesthan3" class="form-control">
                </div>
                <!-- elderly_count -->
                <div class="col-sm-2">
                    <label for="elderly_count" class="form-label">عدد المسنين </label>
                    <input value="{{ $citizen->elderly_count ?? old('elderly_count','') }}" type="number" id="elderly_count" name="elderly_count" class="form-control">
                </div>
            </div>

            {{-- المزمنة  --}}
            <div class="row mb-3">

                <label class="col-sm-3 col-form-label text-sm-end">امراض مزمنة </label>
                <!-- Diseases -->
                <div class="col-sm-2">
                    <label for="disease" class="form-label">عدد الامراض المزمنة</label>
                    <input value="{{ $citizen->disease ?? old('disease','') }}" type="number" id="disease" name="disease" class="form-control">
                </div>
                <div class="col-sm-6">
                    <label for="disease_description" class="form-label">تفاصيل الامراض المزمنة</label>
                    <input value="{{ $citizen->disease_description ?? old('disease_description','') }}" type="text" id="disease_description" name="disease_description" class="form-control">
                </div>
            </div>

            {{-- اعاقات  --}}
            <div class="row mb-3">

                <label class="col-sm-3 col-form-label text-sm-end">اعاقات </label>
                <!-- Obstruction -->
                <div class="col-sm-2">
                    <label for="obstruction" class="form-label">عدد الاعاقات</label>
                    <input value="{{ $citizen->obstruction ?? old('obstruction','') }}" type="number" id="obstruction" name="obstruction" class="form-control">
                </div>
                <div class="col-sm-6">
                    <label for="obstruction_description" class="form-label">تفاصيل</label>
                    <input value="{{ $citizen->obstruction_description ?? old('obstruction_description','') }}" type="text" id="obstruction_description" name="obstruction_description"
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
                        <option value="" >غير محدد</option>
                        <option value="1" {{isset($citizen) && $citizen->living_status=='1' ? 'selected' : ''}}>سيئ</option>
                        <option value="2" {{isset($citizen) && $citizen->living_status=='2' ? 'selected' : ''}}>جيد</option>
                        <option value="3" {{isset($citizen) && $citizen->living_status=='3' ? 'selected' : ''}}>ممتاز</option>
                    </select>

                </div>
            </div>

            <!-- Job -->
            <div class="row mb-3">
                <label for="job" class="col-sm-3 col-form-label text-sm-end">العمل</label>
                <div class="col-sm-9">
                    <select id="job" name="job" class="form-select">
                        <option value="">غير محدد</option>
                        <option value="1" {{isset($citizen) && $citizen->living_status=='1' ? 'selected' : ''}}>لا يعمل</option>
                        <option value="2" {{isset($citizen) && $citizen->living_status=='2' ? 'selected' : ''}}>عامل</option>
                        <option value="3" {{isset($citizen) && $citizen->living_status=='3' ? 'selected' : ''}}>موظف</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="original_address" class="col-sm-3 col-form-label text-sm-end">عنوان السكن الأصلي</label>
                <div class="col-sm-9">
                    <input value="{{ $citizen->original_address ?? old('original_address','') }}"  type="text" id="original_address" name="original_address" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <label for="is_archived" class="col-sm-3 col-form-label text-sm-end">مؤرشف</label>
                <div class="col-sm-9">
                    <select id="is_archived" name="is_archived" class="form-select">
                    
                        <option value="0"
                            {{ isset($citizen) && $citizen->is_archived == '0' ? 'selected' : '' }}>فعال</option>
                        <option value="1"
                            {{ isset($citizen) && $citizen->is_archived == '1' ? 'selected' : '' }}>مؤرشف</option>
                        
                    </select>                </div>
            </div>

            <!-- Note -->
            <div class="row mb-3">
                <label for="note"  class="col-sm-3 col-form-label text-sm-end"> ملاحظة</label>

                <div class="col-sm-9">
                    <input value="{{ $citizen->note ?? old('note','') }}"   id="note" name="note" rows="3" class="form-control"></textarea>
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
                    document.querySelector('#id ~ .valid-feedback').textContent = 'الهوية صحيحة!';
                } else {
                    idInput.classList.add('is-invalid');
                    document.querySelector('#id ~ .invalid-feedback').textContent = 'الهوية غير صالحة!';
                }
            } else if (id.length > 0) {
                idInput.classList.add('is-invalid');
                document.querySelector('#id ~ .invalid-feedback').textContent = 'يجب ان يكون الطول 9 خانات ';
            }
        }
    </script>
@endpush
