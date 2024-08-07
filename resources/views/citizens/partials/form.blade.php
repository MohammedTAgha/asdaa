 <!-- Default Wizard -->
 <div class="col-12 mb-4">
     <small class="text-light fw-semibold">بيانات النازح</small>
     <div class="bs-stepper wizard-numbered mt-2">
         <div class="bs-stepper-header">
             <div class="step" data-target="#account-details">
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
                 <div id="account-details" class="content">
                     <div class="content-header mb-3">  
                         <h5 class="mb-0 fs-3">بيانات النازح</h5>
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
                     <div class="row g-2">
                         {{-- id --}}
                         <div class="col-sm-3">
                             <label for="id" class="block font-medium text-gray-700">الهوية</label>
                             <input type="text" id="id" name="id"
                                 class="w-full border-gray-300 w-full px-4 py-2 border rounded-md" required>
                         </div>

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
                            <label for="date_of_birth" class="block font-medium text-gray-700">تاريخ الميلاد</label>
                            <input type="date" id="date_of_birth" name="date_of_birth"
                                class="w-full border-gray-300 w-full px-4 py-2 border rounded-md">
                        </div>
                      </div>
                     </div>
                 </div>
                 <!-- بيانات الاسرة -->
                 <div id="personal-info" class="content">
                     <div class="content-header mb-3">
                         <h6 class="mb-0">بيانات الاسرة</h6>
                         <small>ادخل بيانات الاسرة.</small>
                     </div>
                     <div class="row g-3">
                         <div class="col-sm-6">
                             <label class="form-label" for="first-name">First Name</label>
                             <input type="text" id="first-name" class="form-control" placeholder="John" />
                         </div>
                         <div class="col-sm-6">
                             <label class="form-label" for="last-name">Last Name</label>
                             <input type="text" id="last-name" class="form-control" placeholder="Doe" />
                         </div>
                         <div class="col-sm-6">
                             <label class="form-label" for="country">Country</label>
                             <select class="select2" id="country">
                                 <option label=" "></option>
                                 <option>UK</option>
                                 <option>USA</option>
                                 <option>Spain</option>
                                 <option>France</option>
                                 <option>Italy</option>
                                 <option>Australia</option>
                             </select>
                         </div>
                         <div class="col-sm-6">
                             <label class="form-label" for="language">Language</label>
                             <select class="selectpicker w-auto" id="language" data-style="btn-transparent"
                                 data-icon-base="ti" data-tick-icon="ti-check text-white" multiple>
                                 <option>English</option>
                                 <option>French</option>
                                 <option>Spanish</option>
                             </select>
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
                 </div>
                 <!-- Social Links -->
                 <div id="social-links" class="content">
                     <div class="content-header mb-3">
                         <h6 class="mb-0">Social Links</h6>
                         <small>Enter Your Social Links.</small>
                     </div>
                     <div class="row g-3">
                         <div class="col-sm-6">
                             <label class="form-label" for="twitter">Twitter</label>
                             <input type="text" id="twitter" class="form-control"
                                 placeholder="https://twitter.com/abc" />
                         </div>
                         <div class="col-sm-6">
                             <label class="form-label" for="facebook">Facebook</label>
                             <input type="text" id="facebook" class="form-control"
                                 placeholder="https://facebook.com/abc" />
                         </div>
                         <div class="col-sm-6">
                             <label class="form-label" for="google">Google+</label>
                             <input type="text" id="google" class="form-control"
                                 placeholder="https://plus.google.com/abc" />
                         </div>
                         <div class="col-sm-6">
                             <label class="form-label" for="linkedin">LinkedIn</label>
                             <input type="text" id="linkedin" class="form-control"
                                 placeholder="https://linkedin.com/abc" />
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
 <!-- /Default Wizard -->
