<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizens Management</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <nav class="bg-gray-900 p-4">
        <div class="container mx-auto">
            <div class="flex items-center justify-between">
                <div class="text-white text-lg font-bold">Citizens Management</div>
                <div>
                    <a href="{{ route('citizens.index') }}" class="text-gray-300 hover:text-white">Home</a>
                    <!-- Add other navigation links as needed -->
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto px-4 mt-6">
        @yield('content')
    </div>
</body>
</html>