<!-- resources/views/dashboard.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ادارة مخيم اصداء</title>

        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="article" />
      
        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <!--end::Fonts-->
        <!--begin::Global Stylesheets Bundle(used by all pages)-->
        
        
        <!--end::Global Stylesheets Bundle-->

        <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
       
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


</head>
<body class="bg-gray-100 h-screen antialiased leading-none font-sans" style="direction:rtl">
    <div class="flex h-full">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2">
            <div class="text-white flex items-center space-x-2 px-4">
                <span class="text-2xl font-extrabold">Dashboard</span>
            </div>

            <nav>
                <a href="{{ route('home') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    Home
                </a>
                <a href="{{ route('citizens.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    Citizens
                </a>
                <a href="{{ route('distributions.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    Distributions
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

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>
    <!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="assets/js/custom/widgets.js"></script>
		<script src="assets/js/custom/apps/chat/chat.js"></script>
		<script src="assets/js/custom/modals/create-app.js"></script>
		<script src="assets/js/custom/modals/upgrade-plan.js"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.bg-gray-800').classList.toggle('hidden');
        });
    </script>
</body>
</html>