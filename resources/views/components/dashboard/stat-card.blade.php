@props([
    'value' => '0',
    'label' => '',
    'icon' => '',
    'color' => 'indigo',
    'trend' => null,
    'trendUp' => true,
    'progress' => null,
    'subtext' => '',
    'sparkline' => null,
])

@php
    $palette = [
        'indigo' => [
            'from' => 'from-indigo-500/10',
            'via' => 'via-indigo-400/5',
            'to' => 'to-transparent',
            'border' => 'border-indigo-500/20 dark:border-indigo-500/10',
            'icon' => 'bg-gradient-to-br from-indigo-500 to-indigo-600 shadow-indigo-500/25',
            'text' => 'text-indigo-600 dark:text-indigo-400',
            'badge' => 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 ring-indigo-200/50 dark:ring-indigo-700/30',
            'progress' => 'bg-indigo-500',
            'progressBg' => 'bg-indigo-100 dark:bg-indigo-900/30',
            'glow' => 'group-hover:shadow-indigo-500/10',
            'spark' => 'stroke-indigo-500 dark:stroke-indigo-400',
        ],
        'violet' => [
            'from' => 'from-violet-500/10',
            'via' => 'via-violet-400/5',
            'to' => 'to-transparent',
            'border' => 'border-violet-500/20 dark:border-violet-500/10',
            'icon' => 'bg-gradient-to-br from-violet-500 to-purple-600 shadow-violet-500/25',
            'text' => 'text-violet-600 dark:text-violet-400',
            'badge' => 'bg-violet-50 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 ring-violet-200/50 dark:ring-violet-700/30',
            'progress' => 'bg-violet-500',
            'progressBg' => 'bg-violet-100 dark:bg-violet-900/30',
            'glow' => 'group-hover:shadow-violet-500/10',
            'spark' => 'stroke-violet-500 dark:stroke-violet-400',
        ],
        'emerald' => [
            'from' => 'from-emerald-500/10',
            'via' => 'via-emerald-400/5',
            'to' => 'to-transparent',
            'border' => 'border-emerald-500/20 dark:border-emerald-500/10',
            'icon' => 'bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-emerald-500/25',
            'text' => 'text-emerald-600 dark:text-emerald-400',
            'badge' => 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 ring-emerald-200/50 dark:ring-emerald-700/30',
            'progress' => 'bg-emerald-500',
            'progressBg' => 'bg-emerald-100 dark:bg-emerald-900/30',
            'glow' => 'group-hover:shadow-emerald-500/10',
            'spark' => 'stroke-emerald-500 dark:stroke-emerald-400',
        ],
        'amber' => [
            'from' => 'from-amber-500/10',
            'via' => 'via-amber-400/5',
            'to' => 'to-transparent',
            'border' => 'border-amber-500/20 dark:border-amber-500/10',
            'icon' => 'bg-gradient-to-br from-amber-500 to-orange-600 shadow-amber-500/25',
            'text' => 'text-amber-600 dark:text-amber-400',
            'badge' => 'bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 ring-amber-200/50 dark:ring-amber-700/30',
            'progress' => 'bg-amber-500',
            'progressBg' => 'bg-amber-100 dark:bg-amber-900/30',
            'glow' => 'group-hover:shadow-amber-500/10',
            'spark' => 'stroke-amber-500 dark:stroke-amber-400',
        ],
        'rose' => [
            'from' => 'from-rose-500/10',
            'via' => 'via-rose-400/5',
            'to' => 'to-transparent',
            'border' => 'border-rose-500/20 dark:border-rose-500/10',
            'icon' => 'bg-gradient-to-br from-rose-500 to-red-600 shadow-rose-500/25',
            'text' => 'text-rose-600 dark:text-rose-400',
            'badge' => 'bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 ring-rose-200/50 dark:ring-rose-700/30',
            'progress' => 'bg-rose-500',
            'progressBg' => 'bg-rose-100 dark:bg-rose-900/30',
            'glow' => 'group-hover:shadow-rose-500/10',
            'spark' => 'stroke-rose-500 dark:stroke-rose-400',
        ],
        'sky' => [
            'from' => 'from-sky-500/10',
            'via' => 'via-sky-400/5',
            'to' => 'to-transparent',
            'border' => 'border-sky-500/20 dark:border-sky-500/10',
            'icon' => 'bg-gradient-to-br from-sky-500 to-cyan-600 shadow-sky-500/25',
            'text' => 'text-sky-600 dark:text-sky-400',
            'badge' => 'bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 ring-sky-200/50 dark:ring-sky-700/30',
            'progress' => 'bg-sky-500',
            'progressBg' => 'bg-sky-100 dark:bg-sky-900/30',
            'glow' => 'group-hover:shadow-sky-500/10',
            'spark' => 'stroke-sky-500 dark:stroke-sky-400',
        ],
    ];
    $c = $palette[$color] ?? $palette['indigo'];

    $defaultSparklines = [
        'indigo' => 'M0,16 Q5,12 10,14 T20,8 T30,10 T40,4 T50,6 T60,2 T70,3',
        'violet' => 'M0,14 Q5,10 10,12 T20,6 T30,8 T40,2 T50,4 T60,1 T70,2',
        'emerald' => 'M0,18 Q5,14 10,16 T20,10 T30,12 T40,6 T50,8 T60,4 T70,5',
        'amber' => 'M0,12 Q5,16 10,14 T20,18 T30,14 T40,16 T50,12 T60,14 T70,10',
        'sky' => 'M0,16 Q5,11 10,13 T20,7 T30,9 T40,3 T50,5 T60,1 T70,2',
        'rose' => 'M0,10 Q5,14 10,12 T20,16 T30,12 T40,14 T50,10 T60,12 T70,8',
    ];
    $sparkPath = $sparkline && $sparkline !== 'true' ? $sparkline : ($defaultSparklines[$color] ?? $defaultSparklines['indigo']);
@endphp

<div class="group relative bg-white dark:bg-slate-800/80 rounded-3xl border {{ $c['border'] }} p-5 hover:shadow-xl {{ $c['glow'] }} hover:-translate-y-1 transition-all duration-300 overflow-hidden">
    {{-- Gradient overlay --}}
    <div class="absolute inset-0 bg-gradient-to-b {{ $c['from'] }} {{ $c['via'] }} {{ $c['to'] }} rounded-3xl pointer-events-none"></div>

    {{-- Top row: icon + trend badge --}}
    <div class="relative flex items-start justify-between mb-3">
        <div class="w-11 h-11 rounded-2xl {{ $c['icon'] }} flex items-center justify-center shrink-0 shadow-lg transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-3">
            <span class="text-white">{!! $icon !!}</span>
        </div>
        @if($trend)
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $c['badge'] }} ring-1 transition-all duration-300 group-hover:scale-105">
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    @if($trendUp)
                        <polyline points="18 15 12 9 6 15"/>
                    @else
                        <polyline points="6 9 12 15 18 9"/>
                    @endif
                </svg>
                {{ $trend }}
            </span>
        @endif
    </div>

    {{-- Value + label --}}
    <div class="relative mb-{{ ($progress !== null || $sparkline !== null || $subtext) ? '3' : '0' }}">
        <p class="text-3xl sm:text-4xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $value }}</p>
        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5 font-medium">{{ $label }}</p>
    </div>

    {{-- Progress bar --}}
    @if($progress !== null)
        <div class="relative">
            <div class="flex items-center justify-between mb-1.5">
                <span class="text-[10px] font-medium {{ $c['text'] }}">{{ $progress }}%</span>
                @if($subtext)
                    <span class="text-[10px] text-slate-400 dark:text-slate-500">{{ $subtext }}</span>
                @endif
            </div>
            <div class="h-1.5 {{ $c['progressBg'] }} rounded-full overflow-hidden">
                <div class="h-full {{ $c['progress'] }} rounded-full transition-all duration-700 ease-out group-hover:opacity-90"
                     style="width: {{ $progress }}%"></div>
            </div>
        </div>
    @endif

    {{-- Mini sparkline --}}
    @if($sparkline !== null && $progress === null)
        <div class="relative -mx-1">
            <svg class="w-full h-8 {{ $c['spark'] }}" viewBox="0 0 70 20" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="{{ $sparkPath }}" class="transition-all duration-500 group-hover:opacity-80"/>
                <path d="{{ $sparkPath }}" stroke="url(#sparkGrad-{{ $color }})" stroke-width="3" class="opacity-30"/>
            </svg>
            <svg class="absolute inset-0 w-full h-8" viewBox="0 0 70 20">
                <defs>
                    <linearGradient id="sparkGrad-{{ $color }}" x1="0" y1="0" x2="1" y2="0">
                        <stop offset="0%" stop-color="currentColor" stop-opacity="0"/>
                        <stop offset="50%" stop-color="currentColor" stop-opacity="0.4"/>
                        <stop offset="100%" stop-color="currentColor" stop-opacity="0"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
    @endif

    {{-- Subtext fallback --}}
    @if($subtext && $progress === null && $sparkline === null)
        <div class="relative">
            <p class="text-[11px] text-slate-400 dark:text-slate-500">{{ $subtext }}</p>
        </div>
    @endif
</div>
