<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ادارة اصداء')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Styles -->
    @livewireStyles
    <link href="{{ asset('assets/css/tailwind.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="container mx-auto px-4 py-8">
        @yield('content')
    </div>

    <!-- Scripts -->
    @livewireScripts
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            console.log('Livewire loaded');
        });
    </script>
    @stack('scripts')
</body>
</html> 