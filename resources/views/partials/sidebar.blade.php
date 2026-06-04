@php
    $navItems = [
        ['label' => 'Tableau de bord', 'route' => 'dashboard',            'icon' => 'LayoutDashboard', 'badge' => null],
        ['label' => 'Candidatures',  'route' => 'candidatures.index',   'icon' => 'Briefcase',       'badge' => Auth::user()->candidatures()->count()],
        ['label' => 'Entretiens',    'route' => 'entretiens.index',     'icon' => 'Calendar',        'badge' => null],
        ['label' => 'Archives',      'route' => 'candidatures.archives','icon' => 'Archive',         'badge' => null],
        ['label' => 'Profil',        'route' => 'profile.edit',          'icon' => 'User',           'badge' => null],
    ];

    if (!function_exists('navIcon')) { function navIcon($name, $active = false) {
        $class = 'w-5 h-5 transition-transform duration-200 ' . ($active ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500 group-hover:scale-105');
        return match($name) {
            'LayoutDashboard' => <<<SVG
<svg class="{$class}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="14" rx="1"/></svg>
SVG,
            'Briefcase' => <<<SVG
<svg class="{$class}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
SVG,
            'Calendar' => <<<SVG
<svg class="{$class}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
SVG,
            'Archive' => <<<SVG
<svg class="{$class}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="5" x="2" y="3" rx="1"/><path d="M4 8v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8"/><path d="M10 12h4"/></svg>
SVG,
            'User' => <<<SVG
<svg class="{$class}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
SVG,
            default => '',
        };
    } }

    $user = Auth::user();
    $initials = strtoupper(substr($user->name, 0, 1)) . (strpos($user->name, ' ') ? strtoupper(substr(explode(' ', $user->name)[1] ?? '', 0, 1)) : '');
@endphp

{{-- LOGO (Linear/Stripe style) --}}
<div class="flex items-center gap-3 px-6 pt-6 pb-8">
    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/20 shrink-0 transition-transform duration-200 hover:scale-105">
        <span class="text-white font-bold text-sm tracking-tight">CT</span>
    </div>
    <span class="text-base font-semibold tracking-tight text-slate-900 dark:text-white">CandidatureTracker</span>
</div>

{{-- NAVIGATION --}}
<nav class="flex-1 px-3 space-y-0.5">
    @foreach ($navItems as $item)
        @php
            $active = request()->routeIs($item['route']);
        @endphp
        <a href="{{ route($item['route']) }}"
           class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 ease-out-quart
                  {{ $active
                      ? 'bg-indigo-50/80 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 shadow-sm'
                      : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/50 hover:text-slate-900 dark:hover:text-white' }}">
            {{-- Active indicator (Linear style) --}}
            @if($active)
                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-5 rounded-full bg-indigo-500 dark:bg-indigo-400 animate-scale-in"></span>
            @endif
            {!! navIcon($item['icon'], $active) !!}
            <span class="flex-1 transition-transform duration-200 group-hover:translate-x-0.5">{{ $item['label'] }}</span>
            @if ($item['badge'])
                <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 tabular-nums transition-all duration-200 group-hover:scale-105">
                    {{ $item['badge'] }}
                </span>
            @endif
        </a>
    @endforeach
</nav>

{{-- USER PROFILE (Notion style) --}}
<div class="px-3 pb-6 pt-4 mt-2 border-t border-slate-100/80 dark:border-slate-700/30">
    <div class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 hover:bg-slate-50 dark:hover:bg-slate-800/40 cursor-pointer">
        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center text-white text-xs font-bold shrink-0 shadow-sm transition-transform duration-200 group-hover:scale-105">
            {{ $initials }}
        </div>
        <div class="min-w-0">
            <p class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ $user->name }}</p>
            <p class="text-xs text-slate-400 dark:text-slate-500 truncate">{{ $user->email }}</p>
        </div>
    </div>
</div>
