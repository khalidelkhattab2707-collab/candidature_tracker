@props(['candidature'])

@php
    $initial = strtoupper(substr($candidature->entreprise, 0, 1));
    $colors = ['bg-indigo-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500', 'bg-cyan-500', 'bg-violet-500', 'bg-pink-500'];
    $color = $colors[crc32($candidature->entreprise) % count($colors)];
    $priorityStars = [
        'basse' => '★',
        'moyenne' => '★★',
        'haute' => '★★★',
    ];
    $priorityColors = [
        'basse' => 'text-slate-300 dark:text-slate-600',
        'moyenne' => 'text-amber-400',
        'haute' => 'text-rose-400',
    ];
@endphp

<div class="group relative bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700/50 p-5 hover:shadow-lg hover:shadow-slate-200/50 dark:hover:shadow-slate-900/50 hover:border-slate-300 dark:hover:border-slate-600 hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">

    {{-- Header --}}
    <div class="flex items-start gap-4">
        <div class="w-10 h-10 rounded-xl {{ $color }} flex items-center justify-center text-white text-sm font-bold shrink-0 shadow-sm">
            {{ $initial }}
        </div>
        <div class="min-w-0 flex-1">
            <h3 class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ $candidature->poste }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 truncate">{{ $candidature->entreprise }}</p>
        </div>
        <x-status-badge :statut="$candidature->statut" />
    </div>

    {{-- Meta --}}
    <div class="mt-4 flex items-center gap-4 text-xs text-slate-400 dark:text-slate-500">
        <span class="flex items-center gap-1">
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            Distanciel
        </span>
        <span class="flex items-center gap-1">
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="1" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            80k – 120k €
        </span>
        <span class="flex items-center gap-0.5 {{ $priorityColors[$candidature->priorite] ?? 'text-slate-300' }}">
            {{ str_repeat('★', ($candidature->priorite === 'haute' ? 3 : ($candidature->priorite === 'moyenne' ? 2 : 1))) }}
        </span>
    </div>

    {{-- Tags --}}
    @if($candidature->notes)
        <div class="mt-3 flex flex-wrap gap-1.5">
            @foreach(collect(explode("\n", $candidature->notes))->take(3) as $tag)
                @if(trim($tag))
                    <span class="px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400">{{ trim($tag) }}</span>
                @endif
            @endforeach
        </div>
    @endif

    {{-- Footer --}}
    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between">
        <span class="text-xs text-slate-400 dark:text-slate-500">
            Postulé {{ $candidature->date_candidature?->diffForHumans() ?? 'N/A' }}
        </span>
        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            <a href="{{ route('candidatures.show', $candidature) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-colors">
                Voir
            </a>
            <a href="{{ route('candidatures.edit', $candidature) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                Modifier
            </a>
        </div>
    </div>
</div>
