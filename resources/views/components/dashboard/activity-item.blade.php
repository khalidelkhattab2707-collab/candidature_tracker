@props([
    'title' => '',
    'description' => '',
    'time' => '',
    'date' => '',
    'type' => 'default',
])

@php
    $icons = [
        'interview' => '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>',
        'submitted' => '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><path d="M12 11v4"/><path d="M10 13h4"/></svg>',
        'offer' => '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
        'rejected' => '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>',
        'followup' => '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22 11 13 2 9 22 2z"/></svg>',
        'default' => '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
    ];
    $iconColors = [
        'interview' => 'bg-violet-100 dark:bg-violet-900/40 text-violet-600 dark:text-violet-300 ring-violet-200 dark:ring-violet-700/50',
        'submitted' => 'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 ring-blue-200 dark:ring-blue-700/50',
        'offer' => 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-300 ring-emerald-200 dark:ring-emerald-700/50',
        'rejected' => 'bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-300 ring-rose-200 dark:ring-rose-700/50',
        'followup' => 'bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-300 ring-amber-200 dark:ring-amber-700/50',
        'default' => 'bg-slate-100 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 ring-slate-200 dark:ring-slate-600/50',
    ];
    $lineColors = [
        'interview' => 'bg-violet-200 dark:bg-violet-800/40',
        'submitted' => 'bg-blue-200 dark:bg-blue-800/40',
        'offer' => 'bg-emerald-200 dark:bg-emerald-800/40',
        'rejected' => 'bg-rose-200 dark:bg-rose-800/40',
        'followup' => 'bg-amber-200 dark:bg-amber-800/40',
        'default' => 'bg-slate-200 dark:bg-slate-700/50',
    ];
@endphp

<div class="flex gap-4 group/item">
    {{-- Timeline line + icon --}}
    <div class="flex flex-col items-center shrink-0">
        <div class="w-10 h-10 rounded-xl {{ $iconColors[$type] ?? $iconColors['default'] }} ring-4 ring-white dark:ring-slate-900 flex items-center justify-center transition-all duration-300 group-hover/item:scale-110 group-hover/item:shadow-lg">
            {!! $icons[$type] ?? $icons['default'] !!}
        </div>
        <div class="w-px flex-1 {{ $lineColors[$type] ?? $lineColors['default'] }} group-last/item:hidden"></div>
    </div>

    {{-- Content --}}
    <div class="flex-1 pb-8 group-last/item:pb-0">
        <div class="bg-white dark:bg-slate-800/60 rounded-xl border border-slate-100 dark:border-slate-700/30 p-4 transition-all duration-300 group-hover/item:shadow-md group-hover/item:border-slate-200 dark:group-hover/item:border-slate-600/50 group-hover/item:-translate-y-0.5">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-slate-900 dark:text-white transition-colors group-hover/item:text-indigo-600 dark:group-hover/item:text-indigo-400">{{ $title }}</p>
                    @if($description)
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $description }}</p>
                    @endif
                </div>
                <div class="text-right shrink-0">
                    @if($date)
                        <p class="text-[11px] font-medium text-slate-400 dark:text-slate-500">{{ $date }}</p>
                    @endif
                    @if($time)
                        <p class="text-[10px] text-slate-400/60 dark:text-slate-500/60 mt-0.5">{{ $time }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
