@php
    $initial = strtoupper(substr($candidature->entreprise, 0, 1));
    $colors = ['bg-indigo-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500', 'bg-cyan-500', 'bg-violet-500', 'bg-pink-500'];
    $color = $colors[crc32($candidature->entreprise) % count($colors)];
@endphp

<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-8 animate-in">

        {{-- HEADER --}}
        <div>
            <a href="{{ route('candidatures.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 transition-colors mb-4">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Retour aux candidatures
            </a>

            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl {{ $color }} flex items-center justify-center text-white text-xl font-bold shrink-0 shadow-sm">
                        {{ $initial }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $candidature->poste }}</h1>
                        <p class="text-base text-slate-500 dark:text-slate-400">{{ $candidature->entreprise }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('candidatures.edit', $candidature) }}"
                       class="inline-flex items-center gap-2 h-10 px-4 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                        Modifier
                    </a>
                    <form method="POST" action="{{ route('candidatures.destroy', $candidature) }}" onsubmit="return confirm('Archiver cette candidature ?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-2 h-10 px-4 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-medium text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all duration-200">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12"/><path d="M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/></svg>
                            Archiver
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- DETAIL CARD --}}
        <div class="bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700/50 p-6 sm:p-8">
            <h2 class="text-sm font-semibold text-slate-900 dark:text-white mb-6">Détails de la candidature</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <p class="text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-wider">Statut</p>
                    <div class="mt-1.5">
                        <x-status-badge :statut="$candidature->statut" />
                    </div>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-wider">Priorité</p>
                    <p class="mt-1.5 text-sm font-medium text-slate-900 dark:text-white">{{ \App\Models\Candidature::PRIORITES[$candidature->priorite] ?? $candidature->priorite }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-wider">Postulé le</p>
                    <p class="mt-1.5 text-sm font-medium text-slate-900 dark:text-white">{{ $candidature->date_candidature?->format('M d, Y') ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-wider">URL de l'offre</p>
                    @if($candidature->url_offre)
                        <a href="{{ $candidature->url_offre }}" target="_blank"
                           class="mt-1.5 inline-flex items-center gap-1 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                            Voir l'offre
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        </a>
                    @else
                        <p class="mt-1.5 text-sm text-slate-400 dark:text-slate-500">—</p>
                    @endif
                </div>
            </div>

            @if($candidature->notes)
                <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-700/50">
                    <p class="text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Notes</p>
                    <p class="text-sm text-slate-700 dark:text-slate-300 whitespace-pre-wrap">{{ $candidature->notes }}</p>
                </div>
            @endif
        </div>

        {{-- ENTRETIENS SECTION --}}
        <div class="bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700/50 p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-sm font-semibold text-slate-900 dark:text-white">
                    Entretiens
                    @if($candidature->entretiens->count() > 0)
                        <span class="ml-1.5 text-slate-400 dark:text-slate-500 font-normal">({{ $candidature->entretiens->count() }})</span>
                    @endif
                </h2>
            </div>

            @if($candidature->entretiens->count() > 0)
                <div class="space-y-3">
                    @foreach($candidature->entretiens as $entretien)
                        <div class="group flex items-center justify-between p-4 rounded-xl bg-slate-50 dark:bg-slate-900/40 border border-slate-100 dark:border-slate-700/30 hover:border-slate-200 dark:hover:border-slate-600/50 transition-all duration-200">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-9 h-9 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-slate-900 dark:text-white">{{ \App\Models\Entretien::TYPES[$entretien->type] ?? $entretien->type }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $entretien->date_heure?->format('M d, Y · H:i') ?? 'N/A' }}</p>
                                    @if($entretien->notes_preparation)
                                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5 truncate max-w-md">{{ $entretien->notes_preparation }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $entretien->resultat === 'positif' ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400' : '' }}
                                    {{ $entretien->resultat === 'negatif' ? 'bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400' : '' }}
                                    {{ $entretien->resultat === 'en_attente' ? 'bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400' : '' }}
                                    {{ $entretien->resultat === 'en_cours' ? 'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400' : '' }}">
                                    {{ \App\Models\Entretien::RESULTATS[$entretien->resultat] ?? $entretien->resultat }}
                                </span>
                                <a href="{{ route('entretiens.edit', $entretien) }}"
                                   class="p-2 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all opacity-0 group-hover:opacity-100">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('entretiens.destroy', $entretien) }}" onsubmit="return confirm('Supprimer cet entretien ?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all opacity-0 group-hover:opacity-100">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    </div>
                    <p class="mt-3 text-sm font-medium text-slate-900 dark:text-white">Aucun entretien pour le moment</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Planifiez votre premier entretien ci-dessous.</p>
                </div>
            @endif

            {{-- ADD ENTRETIEN FORM --}}
            <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-700/50">
                <h3 class="text-sm font-medium text-slate-900 dark:text-white mb-4">Planifier un entretien</h3>
                <form method="POST" action="{{ route('entretiens.store', $candidature) }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @csrf

                    <div>
                        <label for="type" class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">Type</label>
                        <select id="type" name="type" required
                                class="w-full h-10 px-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all">
                            @foreach(\App\Models\Entretien::TYPES as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="date_heure" class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">Date & heure</label>
                        <input id="date_heure" name="date_heure" type="datetime-local" required
                               class="w-full h-10 px-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all">
                    </div>

                    <div>
                        <label for="resultat" class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">Résultat</label>
                        <select id="resultat" name="resultat" required
                                class="w-full h-10 px-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all">
                            @foreach(\App\Models\Entretien::RESULTATS as $key => $label)
                                <option value="{{ $key }}" {{ $key === 'en_attente' ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2 lg:col-span-1">
                        <label for="notes_preparation" class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">Notes</label>
                        <input id="notes_preparation" name="notes_preparation" type="text" placeholder="Notes de préparation…"
                               class="w-full h-10 px-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all">
                    </div>

                    <div class="sm:col-span-2 lg:col-span-4 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center gap-2 h-10 px-5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-medium hover:from-indigo-500 hover:to-violet-500 transition-all duration-200 shadow-lg shadow-indigo-500/20 active:scale-[0.97]">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                            Ajouter l'entretien
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
