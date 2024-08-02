<!DOCTYPE html>
<html lang="en">

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="rtl" data-theme="theme-default"
  data-assets-path="../../assets/" data-template="vertical-menu-template">

    <meta charset="UTF-8">
    <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>ادارة مخيم اصداء</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    {{-- template code --}}

    <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
  <link rel="stylesheet" href="../../assets/vendor/fonts/tabler-icons.css" />
  <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../../assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />
  <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
  <link rel="stylesheet" href="../../assets/vendor/libs/bs-stepper/bs-stepper.css" />
  <link rel="stylesheet" href="../../assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
  <link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />
  <link rel="stylesheet" href="../../assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="../../assets/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
  <script src="../../assets/vendor/js/template-customizer.js"></script>
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="../../assets/js/config.js"></script>
  
    <!--begin::Global Stylesheets Bundle(used by all pages)-->

    {{-- <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <link href="{{ asset('assets/css/fas/all.min.css') }}" rel="stylesheet" type="text/css" /> --}}

    {{-- <link href="{{ asset('assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/tailwind.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/dataTables.tailwindcss.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <!--end::Global Stylesheets Bundle-->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
    <!-- custum styles  -->
    @yield('styles')
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->

    <style>
        /* Snackbar styles */
        .snackbar {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
            font-size: 17px;
        }

        .snackbar.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }

            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }

            to {
                bottom: 0;
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
  
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.html" class="app-brand-link">
              <span class="app-brand-logo demo">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                    fill="#7367F0" />
                  <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                    d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                  <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                    fill="#7367F0" />
                </svg>
              </span>
              <span class="app-brand-text demo menu-text fw-bold">Vuexy</span>
            </a>
  
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
              <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
          </div>
  
          <div class="menu-inner-shadow"></div>
  
          <ul class="menu-inner py-1">
            <!-- Page -->
            <li class="menu-item active">
              <a href="index.html" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Page 1">Page 1</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="page-2.html" class="menu-link">
                <i class="menu-icon tf-icons ti ti-app-window"></i>
                <div data-i18n="Page 2">Page 2</div>
              </a>
            </li>
          </ul>
        </aside>
        <!-- / Menu -->
  
        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
  
          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="ti ti-menu-2 ti-sm"></i>
              </a>
            </div>
  
            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <div class="navbar-nav align-items-center">
                <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                  <i class="ti ti-sm"></i>
                </a>
              </div>
  
              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="../../assets/img/avatars/1.png" alt class="h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="../../assets/img/avatars/1.png" alt class="h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">John Doe</span>
                            <small class="text-muted">Admin</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="ti ti-user-check me-2 ti-sm"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="ti ti-settings me-2 ti-sm"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 ti ti-credit-card me-2 ti-sm"></i>
                          <span class="flex-grow-1 align-middle">Billing</span>
                          <span
                            class="flex-shrink-0 badge badge-center rounded-pill bg-label-danger w-px-20 h-px-20">2</span>
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="ti ti-logout me-2 ti-sm"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>
  
          <!-- / Navbar -->
  
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
  
            <div class="container-xxl flex-grow-1 container-p-y">
              
              <h4 class="fw-bold py-3 mb-4">Page 1</h4>
  
              <!-- Default -->
              <div class="row">
                <div class="col-12">
                  <h5>Default</h5>
                </div>
  
                <!-- Default Wizard -->
                <div class="col-12 mb-4 ">
                  <small class="text-light fw-semibold">Basic</small>
                  <div class="bs-stepper wizard-numbered mt-2">
                    <div class="bs-stepper-header">
                      <div class="step" data-target="#account-details">
                        <button type="button" class="step-trigger">
                          <span class="bs-stepper-circle">1</span>
                          <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Account Details</span>
                            <span class="bs-stepper-subtitle">Setup Account Details</span>
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
                            <span class="bs-stepper-title">Personal Info</span>
                            <span class="bs-stepper-subtitle">Add personal info</span>
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
                            <span class="bs-stepper-title">Social Links</span>
                            <span class="bs-stepper-subtitle">Add social links</span>
                          </span>
                        </button>
                      </div>
                    </div>
                    <div class="bs-stepper-content">
                      <form onSubmit="return false">
                        <!-- Account Details -->
                        <div id="account-details" class="content">
                          <div class="content-header mb-3">
                            <h6 class="mb-0">Account Details</h6>
                            <small>Enter Your Account Details.</small>
                          </div>
                          <div class="row g-3">
                            <div class="col-sm-6">
                              <label class="form-label" for="username">Username</label>
                              <input type="text" id="username" class="form-control" placeholder="johndoe" />
                            </div>
                            <div class="col-sm-6">
                              <label class="form-label" for="email">Email</label>
                              <input type="email" id="email" class="form-control" placeholder="john.doe@email.com"
                                aria-label="john.doe" />
                            </div>
                            <div class="col-sm-6 form-password-toggle">
                              <label class="form-label" for="password">Password</label>
                              <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control"
                                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                  aria-describedby="password2" />
                                <span class="input-group-text cursor-pointer" id="password2"><i
                                    class="ti ti-eye-off"></i></span>
                              </div>
                            </div>
                            <div class="col-sm-6 form-password-toggle">
                              <label class="form-label" for="confirm-password">Confirm Password</label>
                              <div class="input-group input-group-merge">
                                <input type="password" id="confirm-password" class="form-control"
                                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                  aria-describedby="confirm-password2" />
                                <span class="input-group-text cursor-pointer" id="confirm-password2"><i
                                    class="ti ti-eye-off"></i></span>
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
                        </div>
                        <!-- Personal Info -->
                        <div id="personal-info" class="content">
                          <div class="content-header mb-3">
                            <h6 class="mb-0">Personal Info</h6>
                            <small>Enter Your Personal Info.</small>
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
  
  
              <!-- Vertical Wizard -->
              <div class="col-12 mb-4">
                <small class="text-light fw-semibold">Vertical</small>
                <div class="bs-stepper wizard-vertical vertical mt-2">
                  <div class="bs-stepper-header">
                    <div class="step" data-target="#account-details-1">
                      <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label">
                          <span class="bs-stepper-title">Account Details</span>
                          <span class="bs-stepper-subtitle">Setup Account Details</span>
                        </span>
                      </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#personal-info-1">
                      <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">
                          <span class="bs-stepper-title">Personal Info</span>
                          <span class="bs-stepper-subtitle">Add personal info</span>
                        </span>
                      </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#social-links-1">
                      <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">
                          <span class="bs-stepper-title">Social Links</span>
                          <span class="bs-stepper-subtitle">Add social links</span>
                        </span>
                      </button>
                    </div>
                  </div>
                  <div class="bs-stepper-content">
                    <form onSubmit="return false">
                      <!-- Account Details -->
                      <div id="account-details-1" class="content">
                        <div class="content-header mb-3">
                          <h6 class="mb-0">Account Details</h6>
                          <small>Enter Your Account Details.</small>
                        </div>
                        <div class="row g-3">
                          <div class="col-sm-6">
                            <label class="form-label" for="username-vertical">Username</label>
                            <input type="text" id="username-vertical" class="form-control" placeholder="johndoe" />
                          </div>
                          <div class="col-sm-6">
                            <label class="form-label" for="email-vertical">Email</label>
                            <input
                              type="email"
                              id="email-vertical"
                              class="form-control"
                              placeholder="john.doe@email.com"
                              aria-label="john.doe" />
                          </div>
                          <div class="col-sm-6 form-password-toggle">
                            <label class="form-label" for="password-vertical">Password</label>
                            <div class="input-group input-group-merge">
                              <input
                                type="password"
                                id="password-vertical"
                                class="form-control"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password2-vertical" />
                              <span class="input-group-text cursor-pointer" id="password2-vertical"
                                ><i class="ti ti-eye-off"></i
                              ></span>
                            </div>
                          </div>
                          <div class="col-sm-6 form-password-toggle">
                            <label class="form-label" for="confirm-password-vertical">Confirm Password</label>
                            <div class="input-group input-group-merge">
                              <input
                                type="password"
                                id="confirm-password-vertical"
                                class="form-control"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="confirm-password-vertical2" />
                              <span class="input-group-text cursor-pointer" id="confirm-password-vertical2"
                                ><i class="ti ti-eye-off"></i
                              ></span>
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
                      </div>
                      <!-- Personal Info -->
                      <div id="personal-info-1" class="content">
                        <div class="content-header mb-3">
                          <h6 class="mb-0">Personal Info</h6>
                          <small>Enter Your Personal Info.</small>
                        </div>
                        <div class="row g-3">
                          <div class="col-sm-6">
                            <label class="form-label" for="first-name-vertical">First Name</label>
                            <input type="text" id="first-name-vertical" class="form-control" placeholder="John" />
                          </div>
                          <div class="col-sm-6">
                            <label class="form-label" for="last-name-vertical">Last Name</label>
                            <input type="text" id="last-name-vertical" class="form-control" placeholder="Doe" />
                          </div>
                          <div class="col-sm-6">
                            <label class="form-label" for="country-vertical">Country</label>
                            <select class="select2" id="country-vertical">
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
                            <label class="form-label" for="language-vertical">Language</label>
                            <select
                              class="selectpicker w-auto"
                              id="language-vertical"
                              data-style="btn-transparent"
                              data-icon-base="ti"
                              data-tick-icon="ti-check text-white"
                              multiple>
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
                      <div id="social-links-1" class="content">
                        <div class="content-header mb-3">
                          <h6 class="mb-0">Social Links</h6>
                          <small>Enter Your Social Links.</small>
                        </div>
                        <div class="row g-3">
                          <div class="col-sm-6">
                            <label class="form-label" for="twitter-vertical">Twitter</label>
                            <input
                              type="text"
                              id="twitter-vertical"
                              class="form-control"
                              placeholder="https://twitter.com/abc" />
                          </div>
                          <div class="col-sm-6">
                            <label class="form-label" for="facebook-vertical">Facebook</label>
                            <input
                              type="text"
                              id="facebook-vertical"
                              class="form-control"
                              placeholder="https://facebook.com/abc" />
                          </div>
                          <div class="col-sm-6">
                            <label class="form-label" for="google-vertical">Google+</label>
                            <input
                              type="text"
                              id="google-vertical"
                              class="form-control"
                              placeholder="https://plus.google.com/abc" />
                          </div>
                          <div class="col-sm-6">
                            <label class="form-label" for="linkedin-vertical">LinkedIn</label>
                            <input
                              type="text"
                              id="linkedin-vertical"
                              class="form-control"
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
              <!-- /Vertical Wizard -->
              </div>
            </div>
            <!-- / Content -->
  
            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                  <div>
                    ©
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    , made with ❤️ by <a href="https://pixinvent.com" target="_blank" class="fw-semibold">Pixinvent</a>
                  </div>
                  <div>
                    <a href="https://demos.pixinvent.com/vuexy-html-admin-template/documentation/" target="_blank"
                      class="footer-link me-4">Documentation</a>
                  </div>
                </div>
              </div>
            </footer>
            <!-- / Footer -->
  
            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>
  
      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
  
      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->
  
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
  
    <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
  
    <script src="../../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->
  
    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
    <script src="../../assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="../../assets/vendor/libs/select2/select2.js"></script>
    <script src="../../assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="../../assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="../../assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
  
    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>
  
    <!-- Page JS -->
  
    <script src="../../assets/js/form-wizard-numbered.js"></script>
    <script src="../../assets/js/form-wizard-validation.js"></script>
  
  </body>
<body class="bg-gray-100 h-screen antialiased leading-none font-sans" style="direction:rtl">
    <div class="flex h-full">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2">
            <div class="text-white flex items-center space-x-2 px-4">
                <span class="text-2xl font-extrabold">لوحة التحكم</span>
            </div>

            <nav>
                <a href="{{ route('home') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    الرئيسية
                </a>
                <a href="{{ route('citizens.index') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    كل الاسماء
                </a>
                <a href="{{ route('citizens.import') }}"
                class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                رفع كشف الاسماء
            </a>
                <a href="{{ route('distributions.index') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    الكشوفات
                </a>
                <a href="{{ route('representatives.index') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    المناديب
                </a>
                <a href="{{ route('regions.index') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    المناطق
                </a>
                <a href="{{ route('distribution_citizens.index') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    Distribution Citizens
                </a>

            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <div class="bg-white shadow-md flex justify-between px-6 py-4">
                <div class="flex items-center">
                    <button id="sidebarToggle" class="text-gray-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Welcome, User</span>
                    <a href="{{ route('logout') }}" class="text-gray-600 hover:text-gray-800">Logout</a>
                </div>
            </div>
            @yield('topbar')
            <!-- Content -->
            <main class="flex-1 overflow-y-auto px-10">

                @yield('content')
                <!-- Snackbar container -->
                <div id="snackbar" class="snackbar">

                </div>
            </main>

        </div>
    </div>

    <!-- Scripts -->
    <script>
        function showSnackbar(message, type) {
            var snackbar = document.getElementById("snackbar");

            // Clear existing classes
            snackbar.className = snackbar.className.replace(/\b(alert-|bg-|border-|text-)\S+/g, '');

            // Add appropriate classes based on type
            switch (type) {
                case 'success':
                    snackbar.classList.add('text-green-800', 'border-t-4', 'border-green-300', 'bg-green-50');
                    break;
                case 'danger':
                    snackbar.classList.add('text-red-800', 'border-t-4', 'border-red-300', 'bg-red-50');
                    break;
                case 'info':
                    snackbar.classList.add('text-blue-800', 'border-t-4', 'border-blue-300', 'bg-blue-50');
                    break;
                case 'warning':
                    snackbar.classList.add('text-yellow-800', 'border-t-4', 'border-yellow-300', 'bg-yellow-50');
                    break;
                case 'erorr':
                    snackbar.classList.add('text-red-800', 'border-t-4', 'border-yellow-300', 'bg-yellow-50');
                    break;
                default:
                    snackbar.classList.add('text-gray-800', 'border-t-4', 'border-gray-300', 'bg-gray-50');
                    break;
            }

            snackbar.innerHTML = message;
            snackbar.classList.add('show');
            setTimeout(function() {
                snackbar.classList.remove('show');
            }, 3000);
        }

        // Check for flash messages
        @if (session('success'))
            showSnackbar("{{ session('success') }}", 'success');
        @elseif (session('danger'))
            showSnackbar("{{ session('danger') }}", 'danger');
        @elseif (session('error'))
            showSnackbar("{{ session('error') }}", 'warning');
        @elseif (session('info'))
            showSnackbar("{{ session('info') }}", 'info');
        @elseif (session('warning'))
            showSnackbar("{{ session('warning') }}", 'warning');
        @endif
    </script>

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    {{-- <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script> --}}
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.tailwindcss.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}


    <!--end::Global Javascript Bundle-->
    <!--begin::Page Custom Javascript(used by this page)-->
    {{-- <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/modals/create-app.js') }}"></script>
    <script src="{{ asset('assets/js/custom/modals/upgrade-plan.js') }}"></script> --}}

    @stack('scripts')
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
    <!--begin::Page Vendors Javascript(used by this page)-->



    <!-- <script src="https://cdn.datatables.net/1.10.24/js/dataTables.tailwind.js"></script> -->
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    {{-- <script src="{{ asset('assets/js/custom/pages/projects/project/project.js') }}"></script>
    <script src="{{ asset('assets/js/custom/modals/users-search.js') }}"></script>
    <script src="{{ asset('assets/js/custom/modals/new-target.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/modals/create-app.js') }}"></script>
    <script src="{{ asset('assets/js/custom/modals/upgrade-plan.js') }}"></script> --}}
    <!--end::Page Custom Javascript-->

    <script>
        //  document.addEventListener('DOMContentLoaded', () => {
        //     const form = document.querySelector('form');
        //     form.addEventListener('submit', (event) => {
        //         const inputs = form.querySelectorAll('input');
        //         inputs.forEach(input => {
        //             if (input.value.trim() === '') {
        //                 input.disabled = true;
        //             }
        //         });
        //     });
        // });
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.bg-gray-800').classList.toggle('hidden');
        });
    </script>
</body>

</html>
