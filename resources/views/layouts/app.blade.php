<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="layout()"
      :class="{ 'dark': dark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CandidatureTracker') }} — @isset($title) {{ $title }} @else Dashboard @endisset</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#FAFBFC] dark:bg-[#0B1120] text-slate-900 dark:text-white selection:bg-indigo-500/20 dark:selection:bg-indigo-400/30">

    {{-- SIDEBAR DESKTOP --}}
    <aside class="fixed top-0 left-0 z-30 hidden lg:flex flex-col h-screen w-[260px] xl:w-[280px] bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl border-r border-slate-200/70 dark:border-slate-700/30 shadow-soft dark:shadow-dark-soft">
        @include('partials.sidebar')
    </aside>

    {{-- MOBILE SIDEBAR OVERLAY --}}
    <div x-show="sidebarOpen"
         x-cloak
         x-transition:enter="transition-opacity duration-300 ease-out"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200 ease-in"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden"></div>

    {{-- MOBILE SIDEBAR DRAWER --}}
    <aside x-show="sidebarOpen"
           x-cloak
           x-transition:enter="transition-transform duration-300 ease-out-expo"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition-transform duration-250 ease-in"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed top-0 left-0 z-50 h-screen w-[280px] bg-white/95 dark:bg-slate-900/95 backdrop-blur-2xl shadow-elevated dark:shadow-dark-elevated lg:hidden">
        @include('partials.sidebar')
    </aside>

    {{-- MAIN WRAPPER --}}
    <div class="lg:pl-[260px] xl:pl-[280px] min-h-screen transition-all duration-300">
        {{-- TOPBAR --}}
        @include('partials.topbar')

        {{-- PAGE CONTENT --}}
        <main class="p-4 sm:p-6 lg:p-8 animate-in">
            {{-- Session flash --}}
            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50/80 dark:bg-emerald-900/20 backdrop-blur-sm border border-emerald-200/60 dark:border-emerald-800/40 text-emerald-700 dark:text-emerald-300 text-sm flex items-center gap-3 animate-in">
                    <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 rounded-xl bg-rose-50/80 dark:bg-rose-900/20 backdrop-blur-sm border border-rose-200/60 dark:border-rose-800/40 text-rose-700 dark:text-rose-300 text-sm flex items-center gap-3 animate-in">
                    <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

    <script>
        function layout() {
            return {
                dark: localStorage.getItem('dark') === 'true',
                sidebarOpen: false,
                toggleDark() {
                    this.dark = !this.dark;
                    localStorage.setItem('dark', this.dark);
                },
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
