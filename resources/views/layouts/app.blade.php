<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#f43f5e">
    <title>@yield('title', 'Dinasti Sushi')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-br from-pink-50 via-orange-50 to-pink-50 min-h-screen antialiased flex flex-col">
    <div class="flex-grow">
        @yield('content')
    </div>
    
    <!-- Footer Copyright -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-sm sm:text-base text-gray-600">
                &copy; 2025 By <a href="https://github.com/nofileexistshere" target="_blank" class="text-pink-600 hover:text-pink-700 font-semibold transition-colors">NoFileExistsHere</a>
            </p>
        </div>
    </footer>
</body>
</html>
