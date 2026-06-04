@php
    $statusCounts = $candidatures->groupBy('statut')->map->count();
    $total = $candidatures->count();
    $kanbanColumns = [
        'En cours' => ['a_envoyer', 'envoyee', 'en_cours'],
        'Entretien' => ['entretien'],
        'Offre' => ['acceptee'],
        'Refusé' => ['refusee', 'sans_suite'],
    ];
    $kanbanColors = [
        'En cours' => 'border-t-sky-500',
        'Entretien' => 'border-t-indigo-500',
        'Offre' => 'border-t-emerald-500',
        'Refusé' => 'border-t-rose-500',
    ];
@endphp

<x-app-layout>
    <div x-data="applications('{{ request('sort', 'latest') }}', '{{ request('search', '') }}', '{{ request('statut', 'all') }}')" x-init="init()" class="space-y-6">

        {{-- Hidden form for server-side submission --}}
        <form id="filter-form" method="GET" action="{{ route('candidatures.index') }}" class="hidden">
            <input type="hidden" name="sort" x-ref="sortInput">
            <input type="hidden" name="search" x-ref="searchInput">
            <input type="hidden" name="statut" x-ref="statutInput">
        </form>

        {{-- PAGE HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 animate-in animate-in-delay-1">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Candidatures</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Gérez et suivez toutes vos candidatures en un seul endroit.</p>
            </div>
            <a href="{{ route('candidatures.create') }}"
               class="inline-flex items-center gap-2 h-11 px-5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-medium hover:from-indigo-500 hover:to-violet-500 transition-all duration-200 shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 active:scale-[0.97]">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                Nouvelle candidature
            </a>
        </div>

        {{-- TOOLBAR --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-4 animate-in animate-in-delay-2">
            {{-- Search --}}
            <div class="relative flex-1 max-w-md">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                </svg>
                <input type="text"
                       x-model="search"
                       placeholder="Rechercher par entreprise, poste..."
                       class="w-full h-10 pl-10 pr-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all">
            </div>

            {{-- View toggle --}}
            <div class="flex items-center gap-1 p-1 rounded-xl bg-slate-100 dark:bg-slate-800 w-fit">
                <button @click="view = 'grid'"
                        :class="view === 'grid' ? 'bg-white dark:bg-slate-700 shadow-sm text-indigo-600 dark:text-indigo-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300'"
                        class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200">
                    <svg class="w-4 h-4 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
                </button>
                <button @click="view = 'list'"
                        :class="view === 'list' ? 'bg-white dark:bg-slate-700 shadow-sm text-indigo-600 dark:text-indigo-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300'"
                        class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200">
                    <svg class="w-4 h-4 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" x2="21" y1="6" y2="6"/><line x1="8" x2="21" y1="12" y2="12"/><line x1="8" x2="21" y1="18" y2="18"/><line x1="3" x2="3.01" y1="6" y2="6"/><line x1="3" x2="3.01" y1="12" y2="12"/><line x1="3" x2="3.01" y1="18" y2="18"/></svg>
                </button>
                <button @click="view = 'board'"
                        :class="view === 'board' ? 'bg-white dark:bg-slate-700 shadow-sm text-indigo-600 dark:text-indigo-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300'"
                        class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200">
                    <svg class="w-4 h-4 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                </button>
            </div>
        </div>

        {{-- FILTER CHIPS --}}
        <div class="flex flex-wrap items-center gap-2 animate-in animate-in-delay-3">
            <button @click="filterStatut = 'all'; submitFilters()"
                    :class="filterStatut === 'all' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600'"
                    class="px-4 py-1.5 rounded-full text-xs font-medium transition-all duration-200">
                Toutes
                <span class="ml-1 opacity-60">{{ $total }}</span>
            </button>
            <button @click="filterStatut = 'pending'; submitFilters()"
                    :class="filterStatut === 'pending' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600'"
                    class="px-4 py-1.5 rounded-full text-xs font-medium transition-all duration-200">
                En attente
                <span class="ml-1 opacity-60">{{ ($statusCounts['a_envoyer'] ?? 0) + ($statusCounts['envoyee'] ?? 0) + ($statusCounts['en_cours'] ?? 0) }}</span>
            </button>
            <button @click="filterStatut = 'interview'; submitFilters()"
                    :class="filterStatut === 'interview' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600'"
                    class="px-4 py-1.5 rounded-full text-xs font-medium transition-all duration-200">
Entretien
                <span class="ml-1 opacity-60">{{ $statusCounts['entretien'] ?? 0 }}</span>
            </button>
            <button @click="filterStatut = 'offer'; submitFilters()"
                    :class="filterStatut === 'offer' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600'"
                    class="px-4 py-1.5 rounded-full text-xs font-medium transition-all duration-200">
                Offre
                <span class="ml-1 opacity-60">{{ $statusCounts['acceptee'] ?? 0 }}</span>
            </button>
            <button @click="filterStatut = 'rejected'; submitFilters()"
                    :class="filterStatut === 'rejected' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600'"
                    class="px-4 py-1.5 rounded-full text-xs font-medium transition-all duration-200">
Refusé
                <span class="ml-1 opacity-60">{{ ($statusCounts['refusee'] ?? 0) + ($statusCounts['sans_suite'] ?? 0) }}</span>
            </button>

            {{-- Sort --}}
            <div class="ml-auto flex items-center gap-2">
                <label class="text-xs text-slate-400 dark:text-slate-500">Trier par :</label>
                <select x-model="sortBy"
                        x-on:change="submitFilters()"
                        class="h-8 px-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs text-slate-600 dark:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition-all">
                    <option value="latest">Plus récentes</option>
                    <option value="oldest">Plus anciennes</option>
                    <option value="company">Entreprise A–Z</option>
                    <option value="priority">Priorité</option>
                </select>
            </div>
        </div>

        {{-- ============================== --}}
        {{-- GRID VIEW                       --}}
        {{-- ============================== --}}
        <template x-if="view === 'grid'">
            <div>
                @if($candidatures->isNotEmpty())
                    {{-- Stats row --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6 animate-in animate-in-delay-3">
                        <div class="bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700/50 p-4">
                            <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $total }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Total candidatures</p>
                        </div>
                        <div class="bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700/50 p-4">
                            <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $statusCounts['entretien'] ?? 0 }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Entretiens</p>
                        </div>
                        <div class="bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700/50 p-4">
                            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $statusCounts['acceptee'] ?? 0 }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Offres</p>
                        </div>
                        <div class="bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700/50 p-4">
                            <p class="text-2xl font-bold text-rose-600 dark:text-rose-400">{{ ($statusCounts['refusee'] ?? 0) + ($statusCounts['sans_suite'] ?? 0) }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Refusées</p>
                        </div>
                    </div>

                    {{-- Cards grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($candidatures as $candidature)
                            <x-application-card :candidature="$candidature" />
                        @endforeach
                    </div>
                @else
                    {{-- Empty state --}}
                    <div class="text-center py-20">
                        <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto">
                            <svg class="w-8 h-8 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900 dark:text-white">Aucune candidature pour le moment</h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 max-w-sm mx-auto">Commencez à suivre votre recherche d'emploi en ajoutant votre première candidature.</p>
                        <a href="{{ route('candidatures.create') }}"
                           class="inline-flex items-center gap-2 mt-6 h-11 px-5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-medium hover:from-indigo-500 hover:to-violet-500 transition-all duration-200 shadow-lg shadow-indigo-500/20">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
Nouvelle candidature
                        </a>
                    </div>
                @endif

                {{-- Pagination --}}
                @if($candidatures->isNotEmpty())
                    <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100 dark:border-slate-800">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Affichage de <span class="font-medium text-slate-700 dark:text-slate-300">1</span> à <span class="font-medium text-slate-700 dark:text-slate-300">{{ $total }}</span> sur <span class="font-medium text-slate-700 dark:text-slate-300">{{ $total }}</span> candidatures</p>
                        <div class="flex items-center gap-1">
                            <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors disabled:opacity-40 disabled:pointer-events-none" disabled>
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            </button>
                            <button class="w-9 h-9 flex items-center justify-center rounded-lg bg-indigo-600 text-white text-sm font-medium shadow-sm">1</button>
                            <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" disabled>
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </template>

        {{-- ============================== --}}
        {{-- LIST VIEW                      --}}
        {{-- ============================== --}}
        <template x-if="view === 'list'">
            <div class="bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-slate-700/50">
                                <th class="w-12 px-4 py-3.5">
                                    <input type="checkbox" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                </th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Entreprise</th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Poste</th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Statut</th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Priorité</th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Postulé</th>
                                <th class="px-4 py-3.5 text-right text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            @forelse($candidatures as $candidature)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors duration-150">
                                    <td class="px-4 py-3.5">
                                        <input type="checkbox" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                                {{ strtoupper(substr($candidature->entreprise, 0, 1)) }}
                                            </div>
                                            <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $candidature->entreprise }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-sm text-slate-600 dark:text-slate-400">{{ $candidature->poste }}</td>
                                    <td class="px-4 py-3.5"><x-status-badge :statut="$candidature->statut" /></td>
                                    <td class="px-4 py-3.5">
                                        @php
                                            $pStars = ['basse' => 1, 'moyenne' => 2, 'haute' => 3];
                                            $pColors = ['basse' => 'text-slate-300', 'moyenne' => 'text-amber-400', 'haute' => 'text-rose-400'];
                                        @endphp
                                        <span class="{{ $pColors[$candidature->priorite] ?? 'text-slate-300' }}">{{ str_repeat('★', $pStars[$candidature->priorite] ?? 1) }}</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-sm text-slate-500 dark:text-slate-400">{{ $candidature->date_candidature?->format('M d, Y') ?? '—' }}</td>
                                    <td class="px-4 py-3.5 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="{{ route('candidatures.show', $candidature) }}"
                                               class="px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-colors">Voir</a>
                                            <a href="{{ route('candidatures.edit', $candidature) }}"
                                               class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">Modifier</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-16 text-center">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto">
                                            <svg class="w-6 h-6 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                        </div>
                                        <p class="mt-3 text-sm font-medium text-slate-900 dark:text-white">Aucune candidature pour le moment</p>
                                        <p class="mt-1 text-xs text-slate-500">Commencez à suivre votre recherche.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </template>

        {{-- ============================== --}}
        {{-- KANBAN BOARD                   --}}
        {{-- ============================== --}}
        <template x-if="view === 'board'">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 min-h-[600px]">
                @foreach($kanbanColumns as $columnName => $statuses)
                    @php
                        $columnCandidatures = $candidatures->filter(fn($c) => in_array($c->statut, $statuses));
                        $columnCount = $columnCandidatures->count();
                    @endphp
                    <div class="bg-slate-50 dark:bg-slate-800/40 rounded-2xl border-t-4 {{ $kanbanColors[$columnName] }} p-4">
                        {{-- Column header --}}
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $columnName }}</h3>
                                <span class="px-2 py-0.5 rounded-full text-[11px] font-medium bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400">{{ $columnCount }}</span>
                            </div>
                            <button class="w-6 h-6 flex items-center justify-center rounded-md text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                            </button>
                        </div>

                        {{-- Cards --}}
                        <div class="space-y-3">
                            @forelse($columnCandidatures as $candidature)
                                <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700/50 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $candidature->poste }}</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $candidature->entreprise }}</p>
                                        </div>
                                        <span class="w-2 h-2 rounded-full {{ $candidature->priorite === 'haute' ? 'bg-rose-400' : ($candidature->priorite === 'moyenne' ? 'bg-amber-400' : 'bg-slate-300') }}"></span>
                                    </div>
                                    <div class="mt-3 flex items-center justify-between">
                                        <x-status-badge :statut="$candidature->statut" />
                                        <span class="text-[11px] text-slate-400">{{ $candidature->date_candidature?->format('M d') ?? '—' }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-xs text-slate-400 dark:text-slate-500">Aucune candidature</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </template>

    </div>

    {{-- Alpine.js component --}}
    <script>
        function applications(sort, search, statut) {
            return {
                view: 'grid',
                search: search,
                filterStatut: statut,
                sortBy: sort,
                init() {
                    const saved = localStorage.getItem('apps_view');
                    if (saved) this.view = saved;
                },
                submitFilters() {
                    this.$refs.sortInput.value = this.sortBy;
                    this.$refs.searchInput.value = this.search;
                    this.$refs.statutInput.value = this.filterStatut;
                    this.$nextTick(() => document.getElementById('filter-form').submit());
                }
            }
        }
    </script>
</x-app-layout>
