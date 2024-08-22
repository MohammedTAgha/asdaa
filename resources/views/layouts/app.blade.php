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
<!-- Favicon -->
<link rel="icon" href="{{ asset('assets/img/asdaa.jpg') }}" />



<!-- Fonts -->

{{-- <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" /> --}}

<!-- Icons -->
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" /> --}}

{{-- template code for metronic --}}
<!--begin::Page Vendor Stylesheets(used by this page)-->

<link rel="stylesheet" href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.rtl.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" />
<!--end::Page Vendor Stylesheets-->
<!--begin::Global Stylesheets Bundle(used by all pages)-->
<link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.rtl.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/style.bundle.rtl.css') }}" />


{{-- end code for metronic --}}



{{-- for vuexy --}}
<!-- Core CSS -->
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" /> --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
    class="template-customizer-theme-css" /> --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" /> --}}

<!-- Vendors CSS -->
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" /> --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" /> --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" /> --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" /> --}}

{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" /> --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" /> --}}

{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" /> --}}


<!-- Helpers -->
{{-- <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script> --}}

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
{{-- <script src="../../assets/vendor/js/template-customizer.js"></script> --}}
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
{{-- <script src="../../assets/js/config.js"></script> --}}


{{-- <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" /> --}}
{{-- <link href="{{ asset('assets/css/tailwind.min.css') }}" rel="stylesheet" type="text/css" /> --}}
{{-- <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" /> --}}
{{-- <link href="{{ asset('assets/css/dataTables.tailwindcss.css') }}" rel="stylesheet" type="text/css" /> --}}
{{-- <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> --}}

<!-- Page CSS and customozed 00 -->
@yield('styles')
@livewireStyles
<link href="{{ asset('custom/snakbar.css') }}" rel="stylesheet" type="text/css" />
@stack('custom_styles')

</head>

<body>
    {{-- @dd(auth()->user()) --}}
    <!-- Layout wrapper -->

    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">

            <!--begin::Aside-->
            <div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true"
                data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}"
                data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}"
                data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
                <!--begin::Brand-->
                <div class="aside-logo flex-column-auto" id="kt_aside_logo">
                    <!--begin::Logo-->
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/img/asdaa.jpg') }}" /> </a>
                    <!--end::Logo-->
                    <!--begin::Aside toggler-->
                    <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
                        data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                        data-kt-toggle-name="aside-minimize">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
                        <span class="svg-icon svg-icon-1 rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path opacity="0.5"
                                    d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                                    fill="black" />
                                <path
                                    d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                                    fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Aside toggler-->
                </div>
                <!--end::Brand-->
                <!--begin::Aside menu-->
                <div class="aside-menu flex-column-fluid">
                    <!--begin::Aside Menu-->
                    <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
                        data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
                        data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
                        <!--begin::Menu-->
                        <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                            id="#kt_aside_menu" data-kt-menu="true">
                            <!-- lable -->
                            <div class="menu-item">
                                <div class="menu-content pb-2">
                                    <span class="menu-section text-muted text-uppercase fs-8 ls-1">ادارة المناطق</span>
                                </div>
                            </div>
                            <!-- menue item -->
                            <div class="menu-item">
                                <a class="menu-link active" href="../../demo1/dist/index.html">
                                    <span class="menu-icon">
                                        <!--begin::Icon -->
                                        <span class="svg-icon svg-icon-2">
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-title">Default</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Aside-->
        </div>

    </div>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.html" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="{{ asset('assets/img/asdaa.jpg') }}" />
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold">اصدء</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
                    </a>
                </div>



                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Page -->
                    <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-smart-home"></i>
                            <div>الرئيسية</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('test') ? 'active' : '' }}">
                        <a href="{{ route('test') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-smart-home"></i>
                            <div>test</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('citizens.*') ? 'open' : '' }}">
                        <a href="{{ route('citizens.index') }}" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ti ti-users"></i>
                            <div>النازحين</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ request()->routeIs('citizens.index') ? 'active' : '' }}">
                                <a href="{{ route('citizens.index') }}" class="menu-link">
                                    <div>عرض الكل</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->routeIs('citizens.create') ? 'active' : '' }}">
                                <a href="{{ route('citizens.create') }}" class="menu-link">
                                    <div>اضافة جديد</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->routeIs('citizens.import') ? 'active' : '' }}">
                                <a href="{{ route('citizens.import') }}" class="menu-link">
                                    <div>رفع كشف</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- <li class="menu-item {{ request()->routeIs('citizens.import') ? 'active' : '' }}">
                        <a href="{{ route('citizens.import') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-file-upload"></i>
                            <div>رفع كشف جديد</div>
                        </a>
                    </li> --}}
                    <li class="menu-item {{ request()->routeIs('distributions.index') ? 'active' : '' }}">
                        <a href="{{ route('distributions.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-list"></i>
                            <div>كل الكشوفات</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('representatives.index') ? 'active' : '' }}">
                        <a href="{{ route('representatives.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-man"></i>
                            <div>المناديب</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('regions.index') ? 'active' : '' }}">
                        <a href="{{ route('regions.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-map"></i>
                            <div>المناطق</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->routeIs('staff.index') ? 'active' : '' }}">
                        <a href="{{ route('staff.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-users"></i>
                            <div>الاعضاء</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->routeIs('committees.index') ? 'active' : '' }}">
                        <a href="{{ route('committees.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-flag-3"></i>
                            <div>اللجان</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-users"></i>
                            <div>المستخدمين</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->routeIs('files.index') ? 'active' : '' }}">
                        <a href="{{ route('files.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-folder-plus"></i>
                            <div>مدير الملفات</div>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->
            @if (session('addCitizensReportHtml'))
                {!! session('addCitizensReportHtml') !!}
            @endif
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
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
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('storage/' . auth()->user()->staff->image ?? 'asdaa.jpg') }}"
                                            alt="Profile" class="h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ asset('storage/' . auth()->user()->staff->image ?? 'asdaa.jpg') }}"
                                                            alt="Profile" class="h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="fw-semibold d-block">{{ auth()->user()->staff->name }}</span>
                                                    <small class="text-muted">{{ auth()->user()->role->name }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
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
                                    {{-- <li>
                                        <a class="dropdown-item" href="#">
                                            <span class="d-flex align-items-center align-middle">
                                                <i class="flex-shrink-0 ti ti-credit-card me-2 ti-sm"></i>
                                                <span class="flex-grow-1 align-middle">Billing</span>
                                                <span
                                                    class="flex-shrink-0 badge badge-center rounded-pill bg-label-danger w-px-20 h-px-20">2</span>
                                            </span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                                            <i class="ti ti-logout me-2 ti-sm"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
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
                    @yield('topbar')
                    <div class="container-xxl flex-grow-1 container-p-y">

                        {{-- <h4 class="fw-bold py-3 mb-4">Page title</h4> --}}

                        @yield('content')
                        <!-- Snackbar container -->
                        <x-alert />
                        <div id="snackbar" class="snackbar"></div>
                    </div>
                    <!-- / Content -->
                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <div class="drag-target"></div>
    </div>
    @livewireScripts
    <!-- / Layout wrapper -->
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

    <script>
        var hostUrl = "assets/";
    </script>
    {{-- metronic scripts --}}
    <!--begin::Global Javascript Bundle(used by all pages)-->

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Custom Javascript(used by this page)-->

    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script> --}}

    {{-- v scripts and other libs --}}
    {{-- <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script> --}}

    {{-- <script src="{{ asset('assets/vendor/js/menu.js') }}"></script> --}}
    <!-- endbuild -->

    <!-- Vendors JS -->
    {{-- <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script> --}}

    {{-- <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script> --}}
    <!-- Flat Picker -->
    {{-- <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script> --}}
    <!-- Form Validation -->
    {{-- <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/select2.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/tables-datatables-basic.js') }}"></script> --}}

    <!-- Main JS -->
    {{-- <script src="{{ asset('assets/js/main.js') }}"></script> --}}
    <!-- Page JS -->
    @stack('scripts')

    <!-- Page JS -->
    <script>
        $(document).ready(function() {
            $('.select2-multiple').select2({
                width: 'resolve', // or 'style' or 'element'..
                dropdownAutoWidth: true,
            });
        });
        @if (session('addCitizensReportHtml'))
            document.addEventListener('DOMContentLoaded', function() {

                $('#addCitizensReportModal').modal('show');

            });

            $('#closereport').click(function() {
                // Hide the modal by adding the 'hidden' class
                $('#addCitizensReportModal').addClass('hidden');
            });
        @endif
    </script>
</body>


</html>
