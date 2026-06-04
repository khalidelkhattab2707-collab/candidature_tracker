@props([
    'item' => '{}',
    'poste' => '',
    'entreprise' => '',
    'statut' => '',
    'date' => '',
    'priorite' => 'moyenne',
    'index' => 0,
])

@php
    if (is_string($item) && $item !== '{}') {
        $itemData = json_decode($item, true);
        $poste = $itemData['poste'] ?? $poste;
        $entreprise = $itemData['entreprise'] ?? $entreprise;
        $statut = $itemData['statut'] ?? $statut;
        $date = $itemData['date'] ?? $date;
        $priorite = $itemData['priorite'] ?? $priorite;
    }

    $dotColor = match($priorite) {
        'haute' => 'bg-rose-400',
        'moyenne' => 'bg-amber-400',
        default => 'bg-slate-300 dark:bg-slate-600',
    };
    $colors = ['bg-indigo-500', 'bg-violet-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500', 'bg-cyan-500', 'bg-pink-500'];
    $bg = $colors[crc32($entreprise) % count($colors)];
@endphp

<div draggable="true"
     @dragstart="dragStart($event, {{ $index }})"
     @dragend="dragEnd"
     :class="{
         'opacity-40 scale-95': draggingIndex === {{ $index }},
         'ring-2 ring-indigo-400/50 shadow-lg': dragOverIndex === {{ $index }},
         'hover:shadow-md hover:-translate-y-0.5': draggingIndex !== {{ $index }}
     }"
     class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700/50 p-4 transition-all duration-200 cursor-grab active:cursor-grabbing select-none group">

    <div class="flex items-start justify-between">
        <div class="flex items-center gap-3 min-w-0">
            <div class="w-8 h-8 rounded-lg {{ $bg }} flex items-center justify-center text-white text-xs font-bold shrink-0 shadow-sm">
                {{ strtoupper(substr($entreprise, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium text-slate-900 dark:text-white truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $poste }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $entreprise }}</p>
            </div>
        </div>
        <span class="w-2 h-2 rounded-full {{ $dotColor }} shrink-0 mt-1.5"></span>
    </div>

    @if($date)
        <div class="mt-3 flex items-center justify-between">
            <x-status-badge :statut="$statut" />
            <span class="text-[11px] text-slate-400">{{ $date }}</span>
        </div>
    @else
        <div class="mt-3 flex items-center justify-between">
            <x-status-badge :statut="$statut" />
            <span class="text-[11px] text-slate-400" x-text="getDateText({{ $index }})"></span>
        </div>
    @endif
</div>
