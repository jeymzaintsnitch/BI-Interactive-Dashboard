<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PH GadgetMart BI Dashboard')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <!-- Inline script to instantly load user's theme choice and prevent screen flashing -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('bi-theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark-theme');
            } else {
                document.documentElement.classList.remove('dark-theme');
            }
        })();
    </script>
</head>
    
<body class="d-flex flex-column min-vh-100" style="background: var(--bg-main); color: var(--text-main); transition: background 0.4s cubic-bezier(0.4, 0, 0.2, 1), color 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
    
    <!-- Top Header Navigation -->
    @include('Business_Template.header')
    
    <!-- Main Content Container -->
    <div class="flex-grow-1">
        @yield('content')
    </div>
    
    <!-- Footer -->
    @include('Business_Template.footer')
    
    @stack('scripts')
</body>

</html>