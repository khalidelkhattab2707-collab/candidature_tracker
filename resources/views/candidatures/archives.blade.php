<x-app-layout>
    <div class="space-y-8 animate-in">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 animate-in animate-in-delay-1">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Archives</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Restaurer ou consulter les candidatures archivées.</p>
            </div>
            <a href="{{ route('candidatures.index') }}"
               class="inline-flex items-center gap-2 h-11 px-5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Retour aux candidatures
            </a>
        </div>

        @if($candidatures->isNotEmpty())
            <div class="bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700/50 overflow-hidden animate-in animate-in-delay-2">
                <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
                    @foreach($candidatures as $candidature)
                        @php
                            $initial = strtoupper(substr($candidature->entreprise, 0, 1));
                            $colors = ['bg-slate-500', 'bg-slate-600', 'bg-slate-400'];
                            $color = $colors[crc32($candidature->entreprise) % count($colors)];
                        @endphp
                        <div class="flex items-center gap-4 p-4 sm:px-6 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors duration-150">
                            <div class="w-10 h-10 rounded-xl {{ $color }} flex items-center justify-center text-white text-sm font-bold shrink-0">
                                {{ $initial }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ $candidature->poste }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $candidature->entreprise }} · Archivé {{ $candidature->deleted_at?->diffForHumans() ?? 'N/A' }}</p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="text-xs text-slate-400 dark:text-slate-500">{{ $candidature->date_candidature?->format('M d, Y') ?? '' }}</span>
                                <form method="POST" action="{{ route('candidatures.restore', $candidature->id) }}" onsubmit="return confirm('Restaurer cette candidature ?')" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 h-9 px-4 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-sm font-medium hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-all duration-200 active:scale-95">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                                        Restaurer
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('candidatures.force-destroy', $candidature->id) }}" onsubmit="return confirm('Supprimer définitivement cette candidature ? Cette action est irréversible.')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 h-9 px-4 rounded-xl bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 text-sm font-medium hover:bg-rose-100 dark:hover:bg-rose-900/50 transition-all duration-200 active:scale-95">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            {{-- EMPTY STATE --}}
            <div class="text-center py-20 animate-in animate-in-delay-2">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="5" x="2" y="3" rx="1"/><path d="M4 8v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8"/><path d="M10 12h4"/></svg>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-slate-900 dark:text-white">Aucune candidature archivée</h3>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 max-w-sm mx-auto">Lorsque vous archivez une candidature, elle apparaîtra ici pour que vous puissiez la restaurer plus tard.</p>
                <a href="{{ route('candidatures.index') }}"
                   class="inline-flex items-center gap-2 mt-6 h-11 px-5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-medium hover:from-indigo-500 hover:to-violet-500 transition-all duration-200 shadow-lg shadow-indigo-500/20">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    Voir les candidatures
                </a>
            </div>
        @endif

        {{-- FOOTER NOTE --}}
        @if($candidatures->isNotEmpty())
            <p class="text-xs text-slate-400 dark:text-slate-500 text-center">
                {{ $candidatures->count() }} candidature{{ $candidatures->count() > 1 ? 's' : '' }} archivée{{ $candidatures->count() > 1 ? 's' : '' }}
            </p>
        @endif
    </div>
</x-app-layout>
