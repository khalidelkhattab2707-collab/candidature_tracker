@php
    $user = Auth::user();
    $initials = strtoupper(substr($user->name, 0, 1)) . (strpos($user->name, ' ') ? strtoupper(substr(explode(' ', $user->name)[1] ?? '', 0, 1)) : '');
@endphp

<header class="sticky top-0 z-20 glass-strong">
    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">

        {{-- LEFT --}}
        <div class="flex items-center gap-4">
            {{-- Mobile hamburger (Linear style) --}}
            <button @click="sidebarOpen = true"
                    class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200 active:scale-95">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>
                </svg>
            </button>

            {{-- Search (Vercel/Linear style) --}}
            <button class="group hidden sm:flex items-center gap-2.5 h-10 px-4 rounded-xl border border-slate-200/70 dark:border-slate-700/40 bg-white dark:bg-slate-800/60 text-sm text-slate-400 dark:text-slate-500 hover:border-slate-300 dark:hover:border-slate-600/60 hover:shadow-sm transition-all duration-200 w-64 lg:w-72 xl:w-80 focus-within:border-indigo-400/50 focus-within:ring-1 focus-within:ring-indigo-400/20">
                <svg class="w-4 h-4 shrink-0 transition-transform duration-200 group-hover:scale-105" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                </svg>
                <span class="flex-1 text-left">Rechercher...</span>
                <kbd class="hidden lg:inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded-md border border-slate-200 dark:border-slate-700/50 text-[10px] font-medium text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-800/80">
                    <span>⌘</span>K
                </kbd>
            </button>
        </div>

        {{-- RIGHT --}}
        <div class="flex items-center gap-1.5">
            {{-- Dark mode toggle (Linear style) --}}
            <button @click="toggleDark()"
                    class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200 active:scale-90">
                <svg x-show="!dark" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                </svg>
                <svg x-show="dark" x-cloak class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
                </svg>
            </button>

            {{-- Notifications with pulse (Linear/Stripe style) --}}
            <button class="relative w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200 active:scale-90">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
                </svg>
                <span class="absolute top-2.5 right-2.5 w-2 h-2 rounded-full bg-rose-500 ring-2 ring-white dark:ring-slate-900"><span class="pulse-dot"></span></span>
            </button>

            {{-- User avatar (Raycast style) --}}
            <div class="relative ml-1" x-data="{ open: false }" @click.outside="open = false">
                <button @click="open = !open"
                        class="flex items-center gap-2.5 px-2 py-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200 active:scale-95">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center text-white text-xs font-bold shadow-sm transition-transform duration-200 group-hover:scale-105">
                        {{ $initials }}
                    </div>
                    <span class="hidden sm:block text-sm font-medium text-slate-700 dark:text-slate-300">{{ $user->name }}</span>
                    <svg class="hidden sm:block w-3.5 h-3.5 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': open }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>

                {{-- Dropdown --}}
                <div x-show="open"
                     x-cloak
                     x-transition:enter="transition-all duration-200 ease-out-quart"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition-all duration-150 ease-in"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 top-full mt-2 w-56 p-1.5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/70 dark:border-slate-700/40 shadow-elevated dark:shadow-dark-elevated backdrop-blur-xl">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all duration-150">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all duration-150">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</header>
