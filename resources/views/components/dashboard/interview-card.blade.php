@props([
    'role' => '',
    'company' => '',
    'date' => '',
    'time' => '',
    'type' => 'Visioconférence',
    'initial' => '',
    'color' => 'indigo',
    'route' => '#',
])

@php
    $colors = ['bg-indigo-500', 'bg-violet-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500', 'bg-cyan-500', 'bg-pink-500'];
    $bg = $colors[crc32($company) % count($colors)];
@endphp

<div class="flex items-center gap-4 p-4 rounded-xl bg-white dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700/50 hover:border-slate-200 dark:hover:border-slate-600 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
    <div class="w-10 h-10 rounded-xl {{ $bg }} flex items-center justify-center text-white text-sm font-bold shrink-0 shadow-sm">
        {{ $initial ?: strtoupper(substr($company, 0, 1)) }}
    </div>

    <div class="flex-1 min-w-0">
        <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ $role }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $company }} &middot; {{ $type }}</p>
    </div>

    <div class="text-right shrink-0">
        <p class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $date }}</p>
        <p class="text-[11px] text-slate-400 dark:text-slate-500">{{ $time }}</p>
    </div>

    <a href="{{ $route }}"
       class="px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors shrink-0">
        Préparer
    </a>
</div>
