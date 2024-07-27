
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ادارة مخيم اصداء</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="article" />
      
        <!--begin::Fonts-->
        <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" /> -->
        <!--end::Fonts-->
        <!--begin::Global Stylesheets Bundle(used by all pages)-->
        
        <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
        <link href="{{ asset('assets/css/fas/all.min.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/tailwind.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/dataTables.tailwindcss.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Global Stylesheets Bundle-->
        <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> -->

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
            from {bottom: 0; opacity: 0;} 
            to {bottom: 30px; opacity: 1;}
        }
        
        @keyframes fadeout {
            from {bottom: 30px; opacity: 1;} 
            to {bottom: 0; opacity: 0;}
        }
    </style>
</head>
<body class="bg-gray-100 h-screen antialiased leading-none font-sans" style="direction:rtl">
    <div class="flex h-full">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2">
            <div class="text-white flex items-center space-x-2 px-4">
                <span class="text-2xl font-extrabold">لوحة التحكم</span>
            </div>

            <nav>
                <a href="{{ route('home') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    الرئيسية
                </a>
                <a href="{{ route('citizens.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    كل الاسماء
                </a>
                <a href="{{ route('distributions.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    الكشوفات
                </a>
                <a href="{{ route('representatives.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    المناديب
                </a>
                <a href="{{ route('regions.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    المناطق
                </a>
                <a href="{{ route('distribution_citizens.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
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
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
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
                switch(type) {
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
            @if(session('success'))
                showSnackbar("{{ session('success') }}", 'success');
            @elseif(session('danger'))
                showSnackbar("{{ session('danger') }}", 'danger');
            @elseif(session('error'))
            showSnackbar("{{ session('error') }}", 'warning');
            @elseif(session('info'))
                showSnackbar("{{ session('info') }}", 'info');
            @elseif(session('warning'))
                showSnackbar("{{ session('warning') }}", 'warning');


            @endif
    </script>

    <!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js')}}"></script>
        <script src="{{ asset('assets/js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{ asset('assets/js/dataTables.tailwindcss.js')}}"></script>
        @stack('scripts')

		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="{{ asset('assets/js/custom/apps/chat/chat.js')}}"></script>
		<script src="{{ asset('assets/js/custom/widgets.js')}}"></script>
		<script src="{{ asset('assets/js/custom/modals/create-app.js')}}"></script>
		<script src="{{ asset('assets/js/custom/modals/upgrade-plan.js')}}"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
        <!--begin::Page Vendors Javascript(used by this page)-->
    
    
   
    <!-- <script src="https://cdn.datatables.net/1.10.24/js/dataTables.tailwind.js"></script> -->
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('assets/js/custom/pages/projects/project/project.js')}}"></script>
    <script src="{{ asset('assets/js/custom/modals/users-search.js')}}"></script>
    <script src="{{ asset('assets/js/custom/modals/new-target.js')}}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js')}}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js')}}"></script>
    <script src="{{ asset('assets/js/custom/modals/create-app.js')}}"></script>
    <script src="{{ asset('assets/js/custom/modals/upgrade-plan.js')}}"></script>
    <!--end::Page Custom Javascript-->

    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.bg-gray-800').classList.toggle('hidden');
        });
    </script>
</body>
</html>