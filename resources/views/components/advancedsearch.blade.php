<form action="#">
    <!--begin::Card-->
    <div class="card mb-7">
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Compact form-->
            <div class="d-flex align-items-center">
                <!--begin::Input group-->
                <div class="position-relative w-md-400px me-md-2">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="black"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" class="form-control form-control-solid ps-10" name="search" value=""
                        placeholder="Search">
                </div>
                <!--end::Input group-->
                <!--begin:Action-->
                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-primary me-5">Search</button>
                    <a id="kt_horizontal_search_advanced_link" class="btn btn-link collapsed" data-bs-toggle="collapse"
                        href="#kt_advanced_search_form" aria-expanded="false">Advanced Search</a>
                </div>
                <!--end:Action-->
            </div>
            <!--end::Compact form-->
            <!--begin::Advance form-->
            <div class="collapse" id="kt_advanced_search_form" style="">
                <!--begin::Separator-->
                <div class="separator separator-dashed mt-9 mb-6"></div>
                <!--end::Separator-->
                <!--begin::Row-->
                <div class="row g-8 mb-8">
                    <!--begin::Col-->
                    <div class="col-xxl-7">
                        <label class="fs-6 form-label fw-bolder text-dark">Tags</label>
                        <tags class="tagify form-control form-control-solid" tabindex="-1">
                            <tag title="products" contenteditable="false" spellcheck="false" tabindex="-1"
                                class="tagify__tag tagify--noAnim" value="products">
                                <x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag">
                                </x>
                                <div><span class="tagify__tag-text">products</span></div>
                            </tag>
                            <tag title="users" contenteditable="false" spellcheck="false" tabindex="-1"
                                class="tagify__tag tagify--noAnim" value="users">
                                <x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag">
                                </x>
                                <div><span class="tagify__tag-text">users</span></div>
                            </tag>
                            <tag title="events" contenteditable="false" spellcheck="false" tabindex="-1"
                                class="tagify__tag tagify--noAnim" value="events">
                                <x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag">
                                </x>
                                <div><span class="tagify__tag-text">events</span></div>
                            </tag><span contenteditable="" tabindex="0" data-placeholder="​" aria-placeholder=""
                                class="tagify__input" role="textbox" aria-autocomplete="both"
                                aria-multiline="false"></span>
                        </tags><input type="text" class="form-control form-control form-control-solid" name="tags"
                            value="products, users, events">
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xxl-5">
                        <!--begin::Row-->
                        <div class="row g-8">
                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <label class="fs-6 form-label fw-bolder text-dark">Team Type</label>
                                <!--begin::Select-->
                                <select class="form-select form-select-solid select2-hidden-accessible"
                                    data-control="select2" data-placeholder="In Progress" data-hide-search="true"
                                    data-select2-id="select2-data-10-xi3n" tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="1">Not started</option>
                                    <option value="2" selected="selected" data-select2-id="select2-data-12-6nyo">
                                        In Progress</option>
                                    <option value="3">Done</option>
                                </select><span class="select2 select2-container select2-container--bootstrap5"
                                    dir="ltr" data-select2-id="select2-data-11-hcze" style="width: 100%;"><span
                                        class="selection"><span
                                            class="select2-selection select2-selection--single form-select form-select-solid"
                                            role="combobox" aria-haspopup="true" aria-expanded="false"
                                            tabindex="0" aria-disabled="false"
                                            aria-labelledby="select2-1r7p-container"
                                            aria-controls="select2-1r7p-container"><span
                                                class="select2-selection__rendered" id="select2-1r7p-container"
                                                role="textbox" aria-readonly="true" title="In Progress">In
                                                Progress</span><span class="select2-selection__arrow"
                                                role="presentation"><b
                                                    role="presentation"></b></span></span></span><span
                                        class="dropdown-wrapper" aria-hidden="true"></span></span>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <label class="fs-6 form-label fw-bolder text-dark">Select Group</label>
                                <!--begin::Radio group-->
                                <div class="nav-group nav-group-fluid">
                                    <!--begin::Option-->
                                    <label>
                                        <input type="radio" class="btn-check" name="type" value="has"
                                            checked="checked">
                                        <span
                                            class="btn btn-sm btn-color-muted btn-active btn-active-primary fw-bolder px-4">All</span>
                                    </label>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label>
                                        <input type="radio" class="btn-check" name="type" value="users">
                                        <span
                                            class="btn btn-sm btn-color-muted btn-active btn-active-primary fw-bolder px-4">Users</span>
                                    </label>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label>
                                        <input type="radio" class="btn-check" name="type" value="orders">
                                        <span
                                            class="btn btn-sm btn-color-muted btn-active btn-active-primary fw-bolder px-4">Orders</span>
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Radio group-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row g-8">
                    <!--begin::Col-->
                    <div class="col-xxl-7">
                        <!--begin::Row-->
                        <div class="row g-8">
                            <!--begin::Col-->
                            <div class="col-lg-4">
                                <label class="fs-6 form-label fw-bolder text-dark">Min. Amount</label>
                                <!--begin::Dialer-->
                                <div class="position-relative" data-kt-dialer="true" data-kt-dialer-min="1000"
                                    data-kt-dialer-max="50000" data-kt-dialer-step="1000" data-kt-dialer-prefix="$"
                                    data-kt-dialer-decimals="2">
                                    <!--begin::Decrease control-->
                                    <button type="button"
                                        class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 start-0"
                                        data-kt-dialer-control="decrease">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen042.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                                    rx="10" fill="black"></rect>
                                                <rect x="6.01041" y="10.9247" width="12" height="2"
                                                    rx="1" fill="black"></rect>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--end::Decrease control-->
                                    <!--begin::Input control-->
                                    <input type="text" class="form-control form-control-solid border-0 ps-12"
                                        data-kt-dialer-control="input" placeholder="Amount" name="manageBudget"
                                        readonly="readonly" value="$50">
                                    <!--end::Input control-->
                                    <!--begin::Increase control-->
                                    <button type="button"
                                        class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 end-0"
                                        data-kt-dialer-control="increase">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen041.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                                    rx="10" fill="black"></rect>
                                                <rect x="10.8891" y="17.8033" width="12" height="2"
                                                    rx="1" transform="rotate(-90 10.8891 17.8033)"
                                                    fill="black"></rect>
                                                <rect x="6.01041" y="10.9247" width="12" height="2"
                                                    rx="1" fill="black"></rect>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--end::Increase control-->
                                </div>
                                <!--end::Dialer-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-lg-4">
                                <label class="fs-6 form-label fw-bolder text-dark">Max. Amount</label>
                                <!--begin::Dialer-->
                                <div class="position-relative" data-kt-dialer="true" data-kt-dialer-min="1000"
                                    data-kt-dialer-max="50000" data-kt-dialer-step="1000" data-kt-dialer-prefix="$"
                                    data-kt-dialer-decimals="2">
                                    <!--begin::Decrease control-->
                                    <button type="button"
                                        class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 start-0"
                                        data-kt-dialer-control="decrease">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen042.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                                    rx="10" fill="black"></rect>
                                                <rect x="6.01041" y="10.9247" width="12" height="2"
                                                    rx="1" fill="black"></rect>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--end::Decrease control-->
                                    <!--begin::Input control-->
                                    <input type="text" class="form-control form-control-solid border-0 ps-12"
                                        data-kt-dialer-control="input" placeholder="Amount" name="manageBudget"
                                        readonly="readonly" value="$100">
                                    <!--end::Input control-->
                                    <!--begin::Increase control-->
                                    <button type="button"
                                        class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 end-0"
                                        data-kt-dialer-control="increase">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen041.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                                    rx="10" fill="black"></rect>
                                                <rect x="10.8891" y="17.8033" width="12" height="2"
                                                    rx="1" transform="rotate(-90 10.8891 17.8033)"
                                                    fill="black"></rect>
                                                <rect x="6.01041" y="10.9247" width="12" height="2"
                                                    rx="1" fill="black"></rect>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--end::Increase control-->
                                </div>
                                <!--end::Dialer-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-lg-4">
                                <label class="fs-6 form-label fw-bolder text-dark">Team Size</label>
                                <input type="text" class="form-control form-control form-control-solid"
                                    name="city">
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xxl-5">
                        <!--begin::Row-->
                        <div class="row g-8">
                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <label class="fs-6 form-label fw-bolder text-dark">Category</label>
                                <!--begin::Select-->
                                <select class="form-select form-select-solid select2-hidden-accessible"
                                    data-control="select2" data-placeholder="In Progress" data-hide-search="true"
                                    data-select2-id="select2-data-13-kxkk" tabindex="-1" aria-hidden="true">
                                    <option value=""></option>
                                    <option value="1">Not started</option>
                                    <option value="2" selected="selected"
                                        data-select2-id="select2-data-15-892b">Select</option>
                                    <option value="3">Done</option>
                                </select><span class="select2 select2-container select2-container--bootstrap5"
                                    dir="ltr" data-select2-id="select2-data-14-9t1b" style="width: 100%;"><span
                                        class="selection"><span
                                            class="select2-selection select2-selection--single form-select form-select-solid"
                                            role="combobox" aria-haspopup="true" aria-expanded="false"
                                            tabindex="0" aria-disabled="false"
                                            aria-labelledby="select2-gkr4-container"
                                            aria-controls="select2-gkr4-container"><span
                                                class="select2-selection__rendered" id="select2-gkr4-container"
                                                role="textbox" aria-readonly="true" title="Select">Select</span><span
                                                class="select2-selection__arrow" role="presentation"><b
                                                    role="presentation"></b></span></span></span><span
                                        class="dropdown-wrapper" aria-hidden="true"></span></span>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <label class="fs-6 form-label fw-bolder text-dark">Status</label>
                                <div class="form-check form-switch form-check-custom form-check-solid mt-1">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="flexSwitchChecked" checked="checked">
                                    <label class="form-check-label" for="flexSwitchChecked">Active</label>
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Advance form-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</form>
