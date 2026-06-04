@props([
    'column' => '',
    'title' => '',
    'color' => 'indigo',
    'onDrop' => '',
])

@php
    $colors = [
        'sky' => ['border' => 'border-t-sky-500', 'badge' => 'bg-sky-100 dark:bg-sky-900/40 text-sky-600 dark:text-sky-400', 'accent' => 'bg-sky-500'],
        'indigo' => ['border' => 'border-t-indigo-500', 'badge' => 'bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400', 'accent' => 'bg-indigo-500'],
        'emerald' => ['border' => 'border-t-emerald-500', 'badge' => 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400', 'accent' => 'bg-emerald-500'],
        'rose' => ['border' => 'border-t-rose-500', 'badge' => 'bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400', 'accent' => 'bg-rose-500'],
        'amber' => ['border' => 'border-t-amber-500', 'badge' => 'bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400', 'accent' => 'bg-amber-500'],
    ];
    $c = $colors[$color] ?? $colors['indigo'];
@endphp

<div @dragover.prevent="dragOverColumn = '{{ $column }}'"
     @dragleave="dragOverColumn = null"
     @drop.prevent="dropItem('{{ $column }}')"
     :class="{
         'ring-2 ring-indigo-400/40 dark:ring-indigo-500/50 shadow-lg': dragOverColumn === '{{ $column }}',
         'border-t-4 {{ $c['border'] }}': true
     }"
     class="bg-slate-50 dark:bg-slate-800/40 rounded-2xl p-4 min-h-[250px] transition-all duration-200">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $title }}</h3>
            <span class="px-2 py-0.5 rounded-full text-[11px] font-medium {{ $c['badge'] }}" x-text="items.filter(i => getColumnStatuses('{{ $column }}').includes(i.statut)).length">0</span>
        </div>
        <button class="w-6 h-6 flex items-center justify-center rounded-md text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
        </button>
    </div>

    {{-- CARDS CONTAINER — rendu par Alpine, slot fallback --}}
    <div class="space-y-3" x-show="$el.children.length > 0">
        {{ $slot }}
    </div>

    {{-- EMPTY STATE --}}
    <div class="text-center py-8" x-show="items.filter(i => getColumnStatuses('{{ $column }}').includes(i.statut)).length === 0">
        <p class="text-xs text-slate-400 dark:text-slate-500">No applications</p>
        <p class="text-[10px] text-slate-300 dark:text-slate-600 mt-1">Drag items here</p>
    </div>
</div>
