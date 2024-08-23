<!DOCTYPE html>
<html lang="en">

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="rtl" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="vertical-menu-template">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=0.9" />
{{-- <meta name="viewport" --}}
{{--    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" /> --}}
<title>ادارة مخيم اصداء</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<!-- Favicon -->
<link rel="icon" href="{{ asset('assets/img/asdaa.jpg') }}" />

<style>

</style>

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

{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.rtl.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" /> --}}
<!--end::Page Vendor Stylesheets-->
<!--begin::Global Stylesheets Bundle(used by all pages)-->
<link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.rtl.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/style.bundle.rtl.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" />



{{-- end code for metronic --}}



{{-- for vuexy --}}
<!-- Core CSS -->
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
    class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" /> --}}

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
<link href="{{ asset('assets/css/tailwind.min.css') }}" rel="stylesheet" type="text/css" />
{{-- <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" /> --}}
{{-- <link href="{{ asset('assets/css/dataTables.tailwindcss.css') }}" rel="stylesheet" type="text/css" /> --}}
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Page CSS and customozed 00 -->
@yield('styles')

{{-- custom styles --}}
<link href="{{ asset('custom/snakbar.css') }}" rel="stylesheet" type="text/css" />
@stack('custom_styles')


</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-enabled aside-fixed">
    <!--begin::Main-->
    <!--begin::Main-->
    <!--begin::Root-->
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
                        <img src="{{ asset('assets/img/asdaa.jpg') }}" alt="Logo" class="h-30px" />
                        <span class="menu-title">اصداء</span>
                    </a>
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
                            <!-- Brand -->


                            <!-- Home -->
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('home') ? 'active' : '' }}"
                                    href="{{ route('home') }}">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="ti ti-smart-home"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">الرئيسية</span>
                                </a>
                            </div>

                            <!-- Test -->
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('test') ? 'active' : '' }}"
                                    href="{{ route('test') }}">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="ti ti-smart-home"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">test</span>
                                </a>
                            </div>

                            <!-- Citizens -->
                            <div data-kt-menu-trigger="click"
                                class="menu-item menu-accordion {{ request()->routeIs('citizens.*') ? 'here show' : '' }}">
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="ti ti-users"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">النازحين</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <div class="menu-sub menu-sub-accordion">
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('citizens.index') ? 'active' : '' }}"
                                            href="{{ route('citizens.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">عرض الكل</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('citizens.create') ? 'active' : '' }}"
                                            href="{{ route('citizens.create') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">اضافة جديد</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('citizens.import') ? 'active' : '' }}"
                                            href="{{ route('citizens.import') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">رفع كشف</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Distributions -->
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('distributions.index') ? 'active' : '' }}"
                                    href="{{ route('distributions.index') }}">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="ti ti-list"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">كل الكشوفات</span>
                                </a>
                            </div>

                            <!-- Representatives -->
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('representatives.index') ? 'active' : '' }}"
                                    href="{{ route('representatives.index') }}">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="ti ti-man"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">المناديب</span>
                                </a>
                            </div>

                            <!-- Regions -->
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('regions.index') ? 'active' : '' }}"
                                    href="{{ route('regions.index') }}">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="ti ti-map"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">المناطق</span>
                                </a>
                            </div>

                            <!-- Staff -->
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('staff.index') ? 'active' : '' }}"
                                    href="{{ route('staff.index') }}">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="ti ti-users"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">الاعضاء</span>
                                </a>
                            </div>

                            <!-- Committees -->
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('committees.index') ? 'active' : '' }}"
                                    href="{{ route('committees.index') }}">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="ti ti-flag-3"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">اللجان</span>
                                </a>
                            </div>

                            <!-- Users -->
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                                    href="{{ route('users.index') }}">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="ti ti-users"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">المستخدمين</span>
                                </a>
                            </div>

                            <!-- Files -->
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('files.index') ? 'active' : '' }}"
                                    href="{{ route('files.index') }}">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="ti ti-folder-plus"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">مدير الملفات</span>
                                </a>
                            </div>

                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Aside Menu-->
                </div>
                <!--end::Aside menu-->


            </div>
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                <div id="kt_header" style="" class="header align-items-stretch">
                    <!--begin::Container-->
                    <div class="container-fluid d-flex align-items-stretch justify-content-between">
                        <!--begin::Aside mobile toggle-->
                        <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
                            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                                id="kt_aside_mobile_toggle">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                                <span class="svg-icon svg-icon-2x mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                            fill="black" />
                                        <path opacity="0.3"
                                            d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                            fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                        </div>
                        <!--end::Aside mobile toggle-->
                        <!--begin::Mobile logo-->
                        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                            <a href="../../demo1/dist/index.html" class="d-lg-none">
                                <img alt="Logo" src="assets/media/logos/logo-2.svg" class="h-30px" />
                            </a>
                        </div>
                        <!--end::Mobile logo-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                            <!--begin::Navbar-->
                            <div class="d-flex align-items-stretch" id="kt_header_nav">
                                <!--begin::Menu wrapper-->
                                <div class="header-menu align-items-stretch" data-kt-drawer="true"
                                    data-kt-drawer-name="header-menu"
                                    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                                    data-kt-drawer-width="{default:'200px', '300px': '250px'}"
                                    data-kt-drawer-direction="end"
                                    data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true"
                                    data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                                    <!--begin::Menu-->
                                    <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch"
                                        id="#kt_header_menu" data-kt-menu="true">

                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Menu wrapper-->
                            </div>
                            <!--end::Navbar-->
                            <!--begin::Topbar-->
                            <div class="d-flex align-items-stretch flex-shrink-0">
                                <!--begin::Toolbar wrapper-->
                                <div class="d-flex align-items-stretch flex-shrink-0">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-stretch ms-1 ms-lg-3">
                                        <!--begin::Search-->
                                        <div id="kt_header_search" class="d-flex align-items-stretch"
                                            data-kt-search-keypress="true" data-kt-search-min-length="2"
                                            data-kt-search-enter="enter" data-kt-search-layout="menu"
                                            data-kt-menu-trigger="auto" data-kt-menu-overflow="false"
                                            data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
                                            <!--begin::Search toggle-->
                                            <div class="d-flex align-items-center" data-kt-search-element="toggle"
                                                id="kt_header_search_toggle">
                                                <div
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                                    <span class="svg-icon svg-icon-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none">
                                                            <rect opacity="0.5" x="17.0365" y="15.1223"
                                                                width="8.15546" height="2" rx="1"
                                                                transform="rotate(45 17.0365 15.1223)"
                                                                fill="black" />
                                                            <path
                                                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                                fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                            </div>
                                            <!--end::Search toggle-->
                                            <!--begin::Menu-->

                                            <!--end::Menu-->
                                        </div>
                                        <!--end::Search-->
                                    </div>


                                    <!--begin::User-->
                                    <div class="d-flex align-items-center ms-1 ms-lg-3"
                                        id="kt_header_user_menu_toggle">
                                        <!--begin::Menu wrapper-->
                                        <div class="cursor-pointer symbol symbol-30px symbol-md-40px"
                                            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                            data-kt-menu-placement="bottom-end">
                                            <img src="assets/media/avatars/150-26.jpg" alt="user" />
                                        </div>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px"
                                            data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content d-flex align-items-center px-3">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-50px me-5">
                                                        <img alt="Logo" src="assets/media/avatars/150-26.jpg" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Username-->
                                                    <div class="d-flex flex-column">
                                                        <div class="fw-bolder d-flex align-items-center fs-5">Max Smith
                                                            <span
                                                                class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Pro</span>
                                                        </div>
                                                        <a href="#"
                                                            class="fw-bold text-muted text-hover-primary fs-7">max@kt.com</a>
                                                    </div>
                                                    <!--end::Username-->
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator my-2"></div>
                                            <!--end::Menu separator-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a href="../../demo1/dist/account/overview.html"
                                                    class="menu-link px-5">My Profile</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a href="../../demo1/dist/pages/projects/list.html"
                                                    class="menu-link px-5">
                                                    <span class="menu-text">My Projects</span>
                                                    <span class="menu-badge">
                                                        <span
                                                            class="badge badge-light-danger badge-circle fw-bolder fs-7">3</span>
                                                    </span>
                                                </a>
                                            </div>

                                            <!--end::Menu item-->
                                            <!--begin::Menu separator-->
                                            <div class="separator my-2"></div>
                                            <!--end::Menu separator-->
                                        </div>
                                        <!--end::Menu-->
                                        <!--end::Menu wrapper-->
                                    </div>
                                    <!--end::User -->
                                    <!--begin::Heaeder menu toggle-->
                                    <div class="d-flex align-items-center d-lg-none ms-2 me-n3"
                                        title="Show header menu">
                                        <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                                            id="kt_header_menu_mobile_toggle">
                                            <!--begin::Svg Icon | path: icons/duotune/text/txt001.svg-->
                                            <span class="svg-icon svg-icon-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z"
                                                        fill="black" />
                                                    <path opacity="0.3"
                                                        d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </div>
                                    </div>
                                    <!--end::Heaeder menu toggle-->
                                </div>
                                <!--end::Toolbar wrapper-->
                            </div>
                            <!--end::Topbar-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content pt-18 px-8 d-flex flex-column flex-column-fluid" id="kt_content"
                    style="padding-top: 260px">
                    @yield('content')
                    <!-- Snackbar container -->
                    <x-alert />
                    <div id="snackbar" class="snackbar"></div>
                </div>
                <!--end::Content-->

            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

    <!--end::Main-->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>

    @livewireScripts
    <!-- / Layout wrapper -->

    {{-- snake bar 1 scripts  --}}

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


    {{-- @stack('scripts') --}}
    {{-- vuexy scripts --}}
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
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
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script> --}}

    <!-- Form Validation -->
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- Page JS -->
    @stack('scripts')

    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
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
    {{-- <script src="{{ asset('assets/js/tables-datatables-basic.js') }}"></script> --}}



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    {{--    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script> --}}
    {{--    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script> --}}
    {{--    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script> --}}
    {{--    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script> --}}

    {{--    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script> --}}
    {{--    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script> --}}

    {{--    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script> --}}
    <!-- endbuild -->

    <!-- Vendors JS -->
    {{--    <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script> --}}
    {{--    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script> --}}
    {{--    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script> --}}
    {{--    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script> --}}
    {{--    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script> --}}

    {{--    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script> --}}
    <!-- Flat Picker -->
    {{-- <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script> --}}
    <!-- Form Validation -->
    {{--    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script> --}}
    {{--    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script> --}}
    {{--    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script> --}}

    <!-- Main JS -->
    {{--    <script src="{{ asset('assets/js/main.js') }}"></script> --}}
    <!-- Page JS -->



    {{--     <script src="{{ asset('assets/js/select2.min.js') }}"></script> --}}
    <!-- Page JS -->
    {{--     <script> --}}
    {{--          $(document).ready(function() { --}}
    {{--             $('.select2-multiple').select2({ --}}
    {{--                 width: 'resolve', // or 'style' or 'element'.. --}}
    {{--                 dropdownAutoWidth: true, --}}
    {{--             }); --}}
    {{--         }); --}}
    {{--         @if (session('addCitizensReportHtml')) --}}
    {{--             document.addEventListener('DOMContentLoaded', function() { --}}

    {{--                     $('#addCitizensReportModal').modal('show'); --}}

    {{--             }); --}}

    {{--             $('#closereport').click(function() { --}}
    {{--             // Hide the modal by adding the 'hidden' class --}}
    {{--             $('#addCitizensReportModal').addClass('hidden'); --}}
    {{--             }); --}}
    {{--         @endif --}}

    {{--     </script> --}}
    {{-- <script src="{{ asset('assets/js/tables-datatables-basic.js') }}"></script> --}}

    {{-- <script src="{{ asset('assets/js/tables-datatables-basic.js') }}"></script> --}}
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
</body>

</html>
