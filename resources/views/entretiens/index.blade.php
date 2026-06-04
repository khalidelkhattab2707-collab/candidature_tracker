<x-app-layout>
    <div class="space-y-8 animate-in">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 animate-in animate-in-delay-1">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Entretiens</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Tous vos entretiens planifiés au même endroit.</p>
            </div>
        </div>

        @if($entretiens->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 animate-in animate-in-delay-2">
                @foreach($entretiens as $entretien)
                    @php
                        $candidature = $entretien->candidature;
                        $initial = strtoupper(substr($candidature->entreprise, 0, 1));
                        $colors = ['bg-indigo-500', 'bg-violet-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500', 'bg-cyan-500', 'bg-pink-500'];
                        $color = $colors[crc32($candidature->entreprise) % count($colors)];
                    @endphp
                    <div class="group bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700/50 p-5 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl {{ $color }} flex items-center justify-center text-white text-sm font-bold shrink-0">
                                {{ $initial }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ $candidature->poste }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $candidature->entreprise }}</p>
                            </div>
                            <a href="{{ route('entretiens.edit', $entretien) }}"
                               class="p-2 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                            </a>
                        </div>

                        <div class="mt-4 flex items-center gap-4 text-xs text-slate-500 dark:text-slate-400">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                {{ $entretien->date_heure?->format('M d, Y') ?? 'N/A' }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $entretien->date_heure?->format('H:i') ?? '' }}
                            </span>
                        </div>

                        <div class="mt-3 flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $entretien->resultat === 'positif' ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400' : '' }}
                                {{ $entretien->resultat === 'negatif' ? 'bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400' : '' }}
                                {{ $entretien->resultat === 'en_attente' ? 'bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400' : '' }}
                                {{ $entretien->resultat === 'en_cours' ? 'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400' : '' }}">
                                {{ \App\Models\Entretien::RESULTATS[$entretien->resultat] ?? $entretien->resultat }}
                            </span>
                            <span class="text-xs text-slate-400 dark:text-slate-500">{{ \App\Models\Entretien::TYPES[$entretien->type] ?? $entretien->type }}</span>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between">
                            <a href="{{ route('candidatures.show', $candidature) }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">Voir la candidature &rarr;</a>
                            @if($entretien->notes_preparation)
                                <span class="text-[11px] text-slate-400 dark:text-slate-500 truncate ml-2" title="{{ $entretien->notes_preparation }}">{{ Str::limit($entretien->notes_preparation, 30) }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="animate-in animate-in-delay-3">
                {{ $entretiens->links() }}
            </div>
        @else
            {{-- EMPTY STATE --}}
            <div class="text-center py-20 animate-in animate-in-delay-2">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-slate-900 dark:text-white">Aucun entretien pour le moment</h3>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 max-w-sm mx-auto">Lorsque vous planifiez un entretien, il apparaîtra ici.</p>
                <a href="{{ route('candidatures.index') }}"
                   class="inline-flex items-center gap-2 mt-6 h-11 px-5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-medium hover:from-indigo-500 hover:to-violet-500 transition-all duration-200 shadow-lg shadow-indigo-500/20">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    Voir les candidatures
                </a>
            </div>
        @endif

    </div>
</x-app-layout>
