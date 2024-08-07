 <!-- Default Wizard -->
 <div class="container-xxl flex-grow-1 container-p-y">
 <div class="col-12 mb-4">
     <small class="text-light fw-semibold">بيانات النازح</small>
     <div class="bs-stepper wizard-vertical vertical mt-2">
         <div class="bs-stepper-header">
             <div class="step" data-target="#account-details-1">
                 <button type="button" class="step-trigger">
                     <span class="bs-stepper-circle">1</span>
                     <span class="bs-stepper-label">
                         <span class="bs-stepper-title">البيانات الاساسية</span>
                         <span class="bs-stepper-subtitle"> المعومات الشخصية</span>
                     </span>
                 </button>
             </div>
             <div class="line">
                 <i class="ti ti-chevron-right"></i>
             </div>
             <div class="step" data-target="#personal-info">
                 <button type="button" class="step-trigger">
                     <span class="bs-stepper-circle">2</span>
                     <span class="bs-stepper-label">
                         <span class="bs-stepper-title">معومات الاسرة</span>
                         <span class="bs-stepper-subtitle">ادخل بيانات الاسرة</span>
                     </span>
                 </button>
             </div>
             <div class="line">
                 <i class="ti ti-chevron-right"></i>
             </div>
             <div class="step" data-target="#social-links">
                 <button type="button" class="step-trigger">
                     <span class="bs-stepper-circle">3</span>
                     <span class="bs-stepper-label">
                         <span class="bs-stepper-title">الحالة المعيشية</span>
                         <span class="bs-stepper-subtitle"></span>
                     </span>
                 </button>
             </div>
         </div>
         <div class="bs-stepper-content">
             <form onSubmit="return false">
                 <!-- بيانات النازح -->
                 <div id="account-details-1" class="content">
                     <div class="content-header mb-3">
                         <h5 class="mb-0 fs-3">بيانات النازح</h5>
                     </div>
                     <div class="row g-2 my-4">
                        {{-- id --}}
                        <div class="col-sm-3">
                            <label for="id" class="block font-medium text-gray-700">الهوية</label>
                            <input type="text" id="id" name="id"
                                class="w-full border-gray-300 w-full px-4 py-2 border rounded-md" required>
                        </div>
                        <div class="col-sm-3">
                           <label for="phone" class="block font-medium text-gray-700">رقم الهاتف</label>
                           <input type="text" id="phone" name="phone"
                               class="w-full border-gray-300 w-full px-4 py-2 border rounded-md" >
                       </div>
                        {{-- region --}}
                        <div class="col-sm-3">
                            <label for="region_id" class="block font-medium text-gray-700">المنطقة</label>
                            <select id="region_id" name="region_id"
                                class="w-full border-gray-300 w-full px-4 py-2 border rounded-md" required>
                                <option value="">اختر المنطقة</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                     <div class="row g-3 my-4 ">
                         {{-- first name --}}
                         <div class="col-sm-3">
                             <label for="firstname" class="block text-gray-700">الاسم الاول:</label>
                             <input type="text" name="firstname" id="firstname"
                                 class="w-full px-4 py-2 border rounded-md" required>
                         </div>
                         <div class="col-sm-3 ">
                             <label for="secondname" class="block text-gray-700">الاب:</label>
                             <input type="text" name="secondname" id="secondname"
                                 class="w-full px-4 py-2 border rounded-md">

                         </div>
                         <div class="col-sm-3 ">
                             <label for="thirdname" class="block text-gray-700">الجد:</label>
                             <input type="text" name="thirdname" id="thirdname"
                                 class="w-full px-4 py-2 border rounded-md">
                         </div>
                         <div class="col-sm-3 ">
                             <label for="lastname" class="block text-gray-700"> العائلة:</label>
                             <input type="text" name="lastname" id="lastname"
                                 class="w-full px-4 py-2 border rounded-md" required>
                         </div>
                     </div>


                     <div class="row g-2 my-4">

                         {{-- id --}}
                         <div class="col-sm-3">
                             <label class="block mb-1 font-medium text-gray-700">الحالة الاجنماعية :</label>
                             <select id="social_status" name="social_status"
                                 class="w-full p-2 border border-gray-300 rounded-lg">
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

                         {{-- gender --}}
                         {{-- <div class="col-sm-3">
                            <label for="gender" class="block font-medium text-gray-700">الجنس</label>
                            <div class="form-check mb-2">
                              <input type="radio" id="basic-default-radio-male" name="basic-default-radio" class="form-check-input" required="">
                              <label class="form-check-label" for="basic-default-radio-male">Male</label>
                            </div>
                            <div class="form-check">
                              <input type="radio" id="basic-default-radio-female" name="basic-default-radio" class="form-check-input" required="">
                              <label class="form-check-label" for="basic-default-radio-female">Female</label>
                            </div>
                          </div> --}}
                         <div class="col-sm-3">
                             <label for="gender" class="block font-medium text-gray-700">الجنس</label>
                             <select id="gender" name="gender"
                                 class="w-full border-gray-300 w-full px-4 py-2 border rounded-md" required>
                                 <option value="0">ذكر</option>
                                 <option value="1">انثى</option>
                             </select>
                         </div>

                         {{-- dop --}}
                         <div class="col-sm-3">
                             <div>
                                 <label for="date_of_birth" class="block font-medium text-gray-700">تاريخ
                                     الميلاد</label>
                                 <input type="date" id="date_of_birth" name="date_of_birth"
                                     class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                             </div>
                         </div>
                     </div>
                     <div class="col-12 d-flex justify-content-between">
                        <button class="btn btn-label-secondary btn-prev" disabled>
                          <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                          <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-primary btn-next">
                          <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                          <i class="ti ti-arrow-right"></i>
                        </button>
                      </div>
                 </div>
                 <!-- بيانات الاسرة -->
                 <div id="personal-info" class="content">
                     <div class="content-header mb-3">
                         <h6 class="mb-0">بيانات الاسرة</h6>
                         <small>ادخل بيانات الاسرة.</small>
                     </div>
                     <div class="row g-3">
                         <div class="col-sm-4">
                             <label for="wife_id" class="block font-medium text-gray-700">هوية الزوجة</label>
                             <input type="text" id="wife_id" name="wife_id"
                                 class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                         </div>
                         <div class="col-sm-6">
                             <label for="wife_name" class="block font-medium text-gray-700">اسم الزوجة</label>
                             <input type="text" id="wife_name" name="wife_name"
                                 class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                         </div>
                     </div>
                     <div class="row g-3">
                         <div class="col-sm-2">
                             <label for="family_members" class="block font-medium text-gray-700"> عدد الافراد </label>
                             <input type="number" id="family_members" name="family_members"
                                 class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                         </div>
                         <div class="col-sm-2">
                             <label for="elderly_count" class="block font-medium text-gray-700">عدد المسنين</label>
                             <input type="number" id="elderly_count" name="elderly_count"
                                 class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                         </div>
                     </div>
                     {{-- desises  --}}
                     <div class="row g-3">
                         <div class="col-sm-2">
                             <label for="disease" class="block font-medium text-gray-700"> عدد الامراض المزمنة
                             </label>
                             <input type="number" id="disease" name="disease"
                                 class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                         </div>
                         <div class="col-sm-6">
                             <label for="disease_description" class="block font-medium text-gray-700">تفاصيل الامراض
                                 المزمنة</label>
                             <input type="text" id="disease_description" name="disease_description"
                                 class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                         </div>
                     </div>

                     {{-- desises  --}}
                     <div class="row g-3">
                         <div class="col-sm-2">
                             <label for="obstruction" class="block font-medium text-gray-700"> عدد الاعاقات</label>
                             <input type="number" id="obstruction" name="obstruction"
                                 class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                         </div>
                         <div class="col-sm-6">
                             <label for="obstruction_description" class="block font-medium text-gray-700">تفاصيل
                             </label>
                             <input type="text" id="obstruction_description" name="obstruction_description"
                                 class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                         </div>
                     </div>
                     <div class="col-12 d-flex justify-content-between">
                        <button class="btn btn-label-secondary btn-prev">
                          <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                          <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-primary btn-next">
                          <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                          <i class="ti ti-arrow-right"></i>
                        </button>
                      </div> 
                 </div>




                 <!-- Social Links -->
                 <div id="social-links" class="content">
                     <div class="content-header mb-3">
                         <h6 class="mb-0">معومات اخرى</h6>

                     </div>
                     <div class="row g-3">
                         <div class="col-sm-3">
                             <label class="block mb-1 font-medium text-gray-700">حالة السكن ل:</label>
                             <select id="living_status" name="living_status"
                                 class="w-full p-2 border border-gray-300 rounded-lg">
                                 <option value="">غير محدد</option>
                                 <option value="1">سيئ</option>
                                 <option value="2">جيد</option>
                                 <option value="3">ممتاز</option>
                             </select>
                         </div>
                         <div class="col-sm-3">
                          <label class="block mb-1 font-medium text-gray-700">العمل:</label>
                          <select id="job" name="job"
                              class="w-full p-2 border border-gray-300 rounded-lg">
                              <option value="">غير محدد</option>
                              <option value="1">لا يعمل</option>
                              <option value="2">عامل</option>
                              <option value="3">موظف</option>
                          </select>                         </div>
                         <div class="col-sm-8">
                             <label class="form-label" for="original_address">عنوان السكن الاصلي</label>
                             <input type="text" id="original_address" class="form-control"
                                 placeholder="https://plus.google.com/abc" />
                         </div>
                         <div class="col-sm-8">
                          <label for="note" class="block font-medium text-gray-700">ملاحظة</label>
                          <textarea id="note" name="note" rows="3"
                              class="w-full border-gray-300 w-full px-4 py-2 border rounded-md"></textarea>
                               </div>
                         <div class="col-12 d-flex justify-content-between">
                             <button class="btn btn-label-secondary btn-prev">
                                 <i class="ti ti-arrow-left me-sm-1 me-0"></i>
                                 <span class="align-middle d-sm-inline-block d-none">Previous</span>
                             </button>
                             <button class="btn btn-success btn-submit">Submit</button>
                         </div>
                     </div>
                 </div>
             </form>
         </div>
     </div>
 </div>

 </div> 
 <!-- /Default Wizard -->
