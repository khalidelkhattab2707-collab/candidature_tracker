<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="authLayout()"
      :class="{ 'dark': dark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CandidatureTracker') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased selection:bg-indigo-500/20 dark:selection:bg-indigo-400/30">
    @yield('content')

    <script>
        function authLayout() {
            return {
                dark: localStorage.getItem('dark') === 'true',
                init() {
                    if (this.dark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            }
        }
    </script>
</body>
</html>
