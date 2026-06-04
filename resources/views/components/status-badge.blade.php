@props(['statut'])

@php
    $colors = [
        'a_envoyer' => 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300',
        'envoyee'   => 'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400',
        'en_cours'  => 'bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400',
        'entretien' => 'bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400',
        'acceptee'  => 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400',
        'refusee'   => 'bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400',
        'sans_suite'=> 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400',
    ];
    $labels = \App\Models\Candidature::STATUTS;
@endphp

<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $colors[$statut] ?? $colors['a_envoyer'] }}">
    @if($statut === 'acceptee')
        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
    @elseif($statut === 'refusee')
        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
    @elseif($statut === 'entretien')
        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
    @else
        <span class="w-1.5 h-1.5 rounded-full {{ $colors[$statut] ?? $colors['a_envoyer'] }}"></span>
    @endif
    {{ $labels[$statut] ?? $statut }}
</span>
