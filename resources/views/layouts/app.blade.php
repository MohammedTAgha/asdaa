<!DOCTYPE html>
<html lang="en">

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="rtl" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="vertical-menu-template">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=0.85" />
{{-- <meta name="viewport" --}}
{{--    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" /> --}}
<title> @yield('title','ادارة اصداء') </title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<!-- Favicon -->
<link rel="icon" href="{{ asset('assets/img/asdaa.jpg') }}" />
@livewireStyles
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
            {{-- asside --}}
            @include('layouts.aside')
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                {{-- header --}}
                @include('layouts.header')
                <!--begin::Content-->
                @if (session('addCitizensReportHtml'))
                    {!! session('addCitizensReportHtml') !!}
                @endif
                <div class="content pt-18 px-8 d-flex flex-column flex-column-fluid" id="kt_content"
                    style="padding-top: 260px">
                    @yield('content')
                    <!-- Snackbar container -->
                    <x-alert />
                    {{-- <div id="snackbar" class="snackbar"></div> --}}
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
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/global/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/cdn.min.js') }}" defer></script>
    @livewireScripts
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
</body>
''
</html>
