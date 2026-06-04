@php
    $user = Auth::user();

    // ── Données réelles ──
    $totalCandidatures = $user->candidatures()->count();
    $interviewsCount = $user->candidatures()->where('statut', 'entretien')->count();
    $offersCount = $user->candidatures()->where('statut', 'acceptee')->count();
    $rejectedCount = $user->candidatures()->whereIn('statut', ['refusee', 'sans_suite'])->count();
    $pendingCount = $user->candidatures()->whereIn('statut', ['a_envoyer', 'envoyee', 'en_cours'])->count();
    $responseRate = $totalCandidatures > 0 ? round(($offersCount + $rejectedCount + $interviewsCount) / $totalCandidatures * 100) : 0;

    $recentCandidatures = $user->candidatures()->latest()->take(5)->get();
    $upcomingEntretiens = \App\Models\Entretien::whereHas('candidature', fn($q) => $q->where('user_id', $user->id))
        ->where('date_heure', '>=', now())
        ->orderBy('date_heure')
        ->take(5)
        ->get();

    $thisWeekInterviews = \App\Models\Entretien::whereHas('candidature', fn($q) => $q->where('user_id', $user->id))
        ->whereBetween('date_heure', [now()->startOfWeek(), now()->endOfWeek()])
        ->count();

    $pipelineByStatus = $totalCandidatures > 0
        ? $user->candidatures()->selectRaw('statut, count(*) as count')->groupBy('statut')->pluck('count', 'statut')
        : collect();

    // ── Mock data (fallback) ──
    $mockActivities = $totalCandidatures > 0 ? collect() : collect([
        ['title' => 'Entretien programmé chez Notion', 'desc' => 'Frontend Engineer · Tour technique', 'time' => 'Il y a 2 heures', 'date' => '22 Mai', 'type' => 'interview'],
        ['title' => 'Candidature envoyée à Stripe', 'desc' => 'Full Stack Developer', 'time' => 'Il y a 1 jour', 'date' => '21 Mai', 'type' => 'submitted'],
        ['title' => 'Relance envoyée à Vercel', 'desc' => 'Rappel pour le poste Senior Dev', 'time' => 'Il y a 2 jours', 'date' => '20 Mai', 'type' => 'followup'],
        ['title' => 'Offre reçue de Figma 🎉', 'desc' => 'Junior Developer · Révision des termes', 'time' => 'Il y a 3 jours', 'date' => '19 Mai', 'type' => 'offer'],
        ['title' => 'Candidature refusée chez Notion', 'desc' => 'Backend Engineer', 'time' => 'Il y a 5 jours', 'date' => '17 Mai', 'type' => 'rejected'],
    ]);

    $mockInterviews = $upcomingEntretiens->isNotEmpty() ? collect() : collect([
        ['role' => 'Frontend Engineer', 'company' => 'Stripe', 'date' => '25 Mai', 'time' => '10:00', 'type' => 'Visioconférence'],
        ['role' => 'Full Stack Developer', 'company' => 'Linear', 'date' => '27 Mai', 'time' => '14:30', 'type' => 'Technique'],
        ['role' => 'Senior Software Engineer', 'company' => 'Vercel', 'date' => '1 Juin', 'time' => '11:00', 'type' => 'RH'],
    ]);

    // ── Pipeline items (flat array for Alpine drag-drop) ──
    $pipelineConfig = [
        ['key' => 'applied', 'title' => 'En cours', 'color' => 'sky', 'statuses' => ['a_envoyer', 'envoyee', 'en_cours']],
        ['key' => 'interviewing', 'title' => 'Entretien', 'color' => 'indigo', 'statuses' => ['entretien']],
        ['key' => 'offer', 'title' => 'Offre', 'color' => 'emerald', 'statuses' => ['acceptee']],
        ['key' => 'rejected', 'title' => 'Refusé', 'color' => 'rose', 'statuses' => ['refusee', 'sans_suite']],
    ];

    $statusIcons = [
        'a_envoyer' => '📋', 'envoyee' => '✉️', 'en_cours' => '🔄',
        'entretien' => '🎯', 'acceptee' => '✅', 'refusee' => '❌', 'sans_suite' => '⏸️',
    ];

    if ($totalCandidatures > 0) {
        $allPipelineItems = $user->candidatures()->latest()->take(20)->get()->map(fn($c) => [
            'id' => $c->id,
            'poste' => $c->poste,
            'entreprise' => $c->entreprise,
            'statut' => $c->statut,
            'date' => $c->date_candidature?->format('M d') ?? '',
            'priorite' => $c->priorite,
            'notes' => $c->notes,
        ])->values()->all();
    } else {
        $allPipelineItems = [
            ['id' => 1,  'poste' => 'Frontend Engineer',     'entreprise' => 'Stripe',  'statut' => 'envoyee',   'date' => '20 Mai',  'priorite' => 'haute',   'notes' => 'Entretien technique programmé'],
            ['id' => 2,  'poste' => 'Full Stack Developer',   'entreprise' => 'Linear',  'statut' => 'envoyee',   'date' => '18 Mai',  'priorite' => 'moyenne', 'notes' => ''],
            ['id' => 3,  'poste' => 'UX Engineer',            'entreprise' => 'Framer',  'statut' => 'a_envoyer', 'date' => '22 Mai',  'priorite' => 'basse',   'notes' => ''],
            ['id' => 4,  'poste' => 'Software Engineer',      'entreprise' => 'Google',  'statut' => 'entretien', 'date' => '25 Mai',  'priorite' => 'haute',   'notes' => 'Round 2 - Conception Système'],
            ['id' => 5,  'poste' => 'Senior Developer',       'entreprise' => 'Vercel',  'statut' => 'entretien', 'date' => '1 Juin',  'priorite' => 'moyenne', 'notes' => ''],
            ['id' => 6,  'poste' => 'Junior Developer',       'entreprise' => 'Figma',   'statut' => 'acceptee',  'date' => '15 Mai',  'priorite' => 'haute',   'notes' => '🎉 Offre acceptée !'],
            ['id' => 7,  'poste' => 'Backend Engineer',       'entreprise' => 'Notion',  'statut' => 'refusee',   'date' => '10 Mai',  'priorite' => 'moyenne', 'notes' => 'Refusé après le tour final'],
            ['id' => 8,  'poste' => 'Product Designer',       'entreprise' => 'Linear',  'statut' => 'envoyee',   'date' => '23 Mai',  'priorite' => 'haute',   'notes' => ''],
            ['id' => 9,  'poste' => 'iOS Developer',          'entreprise' => 'Spotify', 'statut' => 'entretien', 'date' => '5 Juin',  'priorite' => 'moyenne', 'notes' => 'Premier tour - Entretien téléphonique'],
            ['id' => 10, 'poste' => 'Data Engineer',          'entreprise' => 'Stripe',  'statut' => 'refusee',   'date' => '5 Mai',   'priorite' => 'basse',   'notes' => ''],
        ];
    }

    $getActivities = function() use ($totalCandidatures, $mockActivities, $recentCandidatures) {
        if ($totalCandidatures > 0 && $recentCandidatures->isNotEmpty()) {
            return $recentCandidatures->map(fn($c) => [
                'title' => $c->statut === 'acceptee' ? 'Offre reçue de '.$c->entreprise.' 🎉' : ($c->statut === 'entretien' ? 'Entretien programmé chez '.$c->entreprise : ($c->statut === 'refusee' ? 'Candidature refusée chez '.$c->entreprise : 'Candidature envoyée à '.$c->entreprise)),
                'desc' => $c->poste . ($c->notes ? ' · ' . Str::limit($c->notes, 40) : ''),
                'time' => $c->created_at->diffForHumans(),
                'date' => $c->created_at->format('M d'),
                'type' => $c->statut === 'acceptee' ? 'offer' : ($c->statut === 'entretien' ? 'interview' : ($c->statut === 'refusee' ? 'rejected' : 'submitted')),
            ]);
        }
        return $mockActivities;
    };

    $activities = $getActivities();
@endphp

@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">

        {{-- ═══════════════════════════════════════ --}}
        {{-- HERO SECTION --}}
        {{-- ═══════════════════════════════════════ --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 animate-in animate-in-delay-1">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">Votre recherche d'emploi en un coup d'œil</h1>
                <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                    @if($thisWeekInterviews > 0)
                        Vous avez <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $thisWeekInterviews }}</span> entretien{{ $thisWeekInterviews > 1 ? 's' : '' }} cette semaine.
                    @elseif($totalCandidatures > 0)
                        Vous avez <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $pendingCount }}</span> candidature{{ $pendingCount > 1 ? 's' : '' }} en attente.
                    @else
                        Commencez à suivre votre recherche d'emploi.
                    @endif
                </p>
            </div>
            <a href="{{ route('candidatures.create') }}"
               class="inline-flex items-center gap-2 h-11 px-5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-medium hover:from-indigo-500 hover:to-violet-500 transition-all duration-200 shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 shrink-0">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                Nouvelle candidature
            </a>
        </div>

        {{-- ═══════════════════════════════════════ --}}
        {{-- STATS GRID --}}
        {{-- ═══════════════════════════════════════ --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 animate-in animate-in-delay-2">
            <x-dashboard.stat-card
                :value="$totalCandidatures"
label="Total candidatures"
                 color="indigo"
                 subtext="Tout l'historique"
                :trend="$totalCandidatures > 0 ? '+'.($totalCandidatures > 5 ? 3 : $totalCandidatures) : null"
                :trendUp="true"
                icon='<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>'
                sparkline="true" />

            <x-dashboard.stat-card
                :value="$pendingCount"
label="En attente"
                 color="amber"
                 :trend="$pendingCount > 0 ? $pendingCount.' active' : null"
                 :trendUp="true"
                 subtext="En attente de réponse"
                icon='<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>' />

            <x-dashboard.stat-card
                :value="$interviewsCount"
label="Entretiens à venir"
                 color="violet"
                 subtext="{{ $thisWeekInterviews > 0 ? $thisWeekInterviews.' cette semaine' : 'Aucun à venir' }}"
                icon='<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/></svg>'
                sparkline="true" />

            <x-dashboard.stat-card
                :value="$offersCount"
label="Offres reçues"
                 color="emerald"
                 :trend="$offersCount > 0 ? '+'.$offersCount : null"
                 :trendUp="true"
                 subtext="{{ $offersCount > 0 ? 'Conversion: '.($totalCandidatures > 0 ? round($offersCount/$totalCandidatures*100) : 0).'%' : 'Continuez à postuler' }}"
                icon='<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>' />

            <x-dashboard.stat-card
                :value="$responseRate.'%'"
label="Taux de réponse"
                 color="sky"
                 :progress="$responseRate"
                 subtext="{{ $totalCandidatures > 0 ? $offersCount + $rejectedCount + $interviewsCount.' réponses' : 'Aucune donnée' }}"
                icon='<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22 11 13 2 9 22 2z"/></svg>' />
        </div>

        {{-- ═══════════════════════════════════════ --}}
        {{-- 2-COLUMN GRID : TIMELINE + INTERVIEWS --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-in animate-in-delay-3">

            {{-- ACTIVITY TIMELINE --}}
            <div class="bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700/50 p-5">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Activité récente</h2>
                    <span class="text-[11px] text-slate-400 dark:text-slate-500">Aujourd'hui</span>
                </div>

                <div class="space-y-0">
                    @forelse($activities as $activity)
                        <x-dashboard.activity-item
                            :title="$activity['title']"
                            :description="$activity['desc']"
                            :time="$activity['time']"
                            :date="$activity['date'] ?? ''"
                            :type="$activity['type']" />
                    @empty
                        <div class="text-center py-10">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto">
                                <svg class="w-6 h-6 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Aucune activité pour le moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- UPCOMING INTERVIEWS --}}
            <div class="bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700/50 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Entretiens à venir</h2>
                    @if($upcomingEntretiens->isNotEmpty() || $mockInterviews->isNotEmpty())
                        <a href="{{ route('candidatures.index') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">Voir tout</a>
                    @endif
                </div>

                <div class="space-y-3">
                    @forelse($upcomingEntretiens->isNotEmpty() ? $upcomingEntretiens : $mockInterviews as $entretien)
                        @if($upcomingEntretiens->isNotEmpty())
                            <x-dashboard.interview-card
                                :role="$entretien->candidature->poste"
                                :company="$entretien->candidature->entreprise"
                                :date="$entretien->date_heure?->format('M d')"
                                :time="$entretien->date_heure?->format('H:i')"
                                :type="\App\Models\Entretien::TYPES[$entretien->type] ?? $entretien->type"
                                :route="route('candidatures.show', $entretien->candidature)" />
                        @else
                            <x-dashboard.interview-card
                                :role="$entretien['role']"
                                :company="$entretien['company']"
                                :date="$entretien['date']"
                                :time="$entretien['time']"
                                :type="$entretien['type']" />
                        @endif
                    @empty
                        <div class="text-center py-10">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto">
                                <svg class="w-6 h-6 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/></svg>
                            </div>
                            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Aucun entretien à venir.</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Planifiez des entretiens pour les voir ici.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════ --}}
        {{-- PIPELINE OVERVIEW with Alpine drag-drop --}}
        {{-- ═══════════════════════════════════════ --}}
        <div x-data="pipeline(@js($allPipelineItems), @js($pipelineConfig))" class="animate-in animate-in-delay-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Aperçu du pipeline</h2>
                <div class="flex items-center gap-3">
                    <span class="text-[11px] text-slate-400 dark:text-slate-500" x-text="`${items.length} total`"></span>
                    <a href="{{ route('candidatures.index') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">Gérer &rarr;</a>
                </div>
            </div>

            {{-- Mobile horizontal scroll container --}}
            <div class="overflow-x-auto pb-2 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 scrollbar-thin">
                <div class="flex lg:grid lg:grid-cols-4 gap-4 min-w-[700px] lg:min-w-0">
                    <template x-for="col in columns" :key="col.key">
                        <div @dragover.prevent="dragOverColumn = col.key"
                             @dragleave="dragOverColumn = null"
                             @drop.prevent="dropItem(col.key)"
                             :class="{
                                 'ring-2 ring-indigo-400/40 dark:ring-indigo-500/50 shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/30': dragOverColumn === col.key,
                                 'border-t-sky-500': col.color === 'sky',
                                 'border-t-indigo-500': col.color === 'indigo',
                                 'border-t-emerald-500': col.color === 'emerald',
                                 'border-t-rose-500': col.color === 'rose',
                             }"
                             class="flex-1 lg:flex-none bg-slate-50 dark:bg-slate-800/40 rounded-2xl border-t-4 p-4 min-h-[280px] transition-all duration-200">

                            {{-- Column header --}}
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300" x-text="col.title"></h3>
                                    <span x-text="columnCount(col.key)"
                                          class="px-2 py-0.5 rounded-full text-[11px] font-medium"
                                          :class="{
                                              'bg-sky-100 dark:bg-sky-900/40 text-sky-600 dark:text-sky-400': col.color === 'sky',
                                              'bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400': col.color === 'indigo',
                                              'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400': col.color === 'emerald',
                                              'bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400': col.color === 'rose',
                                          }"></span>
                                </div>
                                <button class="w-6 h-6 flex items-center justify-center rounded-md text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                                </button>
                            </div>

                            {{-- Cards --}}
                            <div class="space-y-3">
                                <template x-for="(item, idx) in filteredItems(col.key)" :key="item.id">
                                    <div draggable="true"
                                         @dragstart="dragStart($event, item)"
                                         @dragend="dragEnd"
                                         :class="{
                                             'opacity-40 scale-95': dragging && dragging.id === item.id,
                                             'ring-2 ring-indigo-400/50 shadow-lg': dragging && dragging.id === item.id,
                                             'hover:shadow-md hover:-translate-y-0.5': !(dragging && dragging.id === item.id),
                                         }"
                                         class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700/50 p-4 transition-all duration-200 cursor-grab active:cursor-grabbing select-none group">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-bold shrink-0 shadow-sm"
                                                     :class="{
                                                         'bg-indigo-500': ['Stripe','Google','Spotify'].includes(item.entreprise),
                                                         'bg-violet-500': ['Linear','Vercel'].includes(item.entreprise),
                                                         'bg-emerald-500': ['Figma'].includes(item.entreprise),
                                                         'bg-rose-500': ['Notion'].includes(item.entreprise),
                                                         'bg-amber-500': ['Framer'].includes(item.entreprise),
                                                         'bg-cyan-500': !['Stripe','Google','Spotify','Linear','Vercel','Figma','Notion','Framer'].includes(item.entreprise),
                                                     }"
                                                     x-text="item.entreprise.charAt(0)"></div>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-medium text-slate-900 dark:text-white truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors" x-text="item.poste"></p>
                                                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate" x-text="item.entreprise"></p>
                                                </div>
                                            </div>
                                            <span class="w-2 h-2 rounded-full shrink-0 mt-1.5"
                                                  :class="{
                                                      'bg-rose-400': item.priorite === 'haute',
                                                      'bg-amber-400': item.priorite === 'moyenne',
                                                      'bg-slate-300 dark:bg-slate-600': item.priorite !== 'haute' && item.priorite !== 'moyenne',
                                                  }"></span>
                                        </div>
                                        <div class="mt-3 flex items-center justify-between">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium"
                                                  :class="{
                                                      'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300': item.statut === 'a_envoyer',
                                                      'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400': item.statut === 'envoyee',
                                                      'bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400': item.statut === 'en_cours',
                                                      'bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400': item.statut === 'entretien',
                                                      'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400': item.statut === 'acceptee',
                                                      'bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400': item.statut === 'refusee',
                                                      'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400': item.statut === 'sans_suite',
                                                  }"
                                                  x-text="getStatusLabel(item.statut)"></span>
                                            <span class="text-[11px] text-slate-400" x-text="item.date"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            {{-- Empty state --}}
                            <div class="text-center py-8" x-show="columnCount(col.key) === 0">
                                <p class="text-xs text-slate-400 dark:text-slate-500">Aucune candidature</p>
                                <p class="text-[10px] text-slate-300 dark:text-slate-600 mt-1">Glissez les éléments ici</p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
<script>
    function pipeline(items, columns) {
        return {
            items: items,
            columns: columns,
            dragging: null,
            dragOverColumn: null,

            getColumnStatuses(key) {
                const map = {
                    applied: ['a_envoyer', 'envoyee', 'en_cours'],
                    interviewing: ['entretien'],
                    offer: ['acceptee'],
                    rejected: ['refusee', 'sans_suite'],
                };
                return map[key] || [];
            },

            filteredItems(key) {
                return this.items.filter(i => this.getColumnStatuses(key).includes(i.statut));
            },

            columnCount(key) {
                return this.filteredItems(key).length;
            },

            getStatusLabel(statut) {
                const labels = {
                    a_envoyer: 'À envoyer', envoyee: 'Envoyée', en_cours: 'En cours',
                    entretien: 'Entretien', acceptee: 'Acceptée', refusee: 'Refusée', sans_suite: 'Sans suite'
                };
                return labels[statut] || statut;
            },

            dragStart(event, item) {
                this.dragging = item;
                event.dataTransfer.effectAllowed = 'move';
                event.dataTransfer.setData('text/plain', item.id.toString());
                event.target.classList.add('opacity-40', 'scale-95');
            },

            dragEnd(event) {
                if (event.target) {
                    event.target.classList.remove('opacity-40', 'scale-95');
                }
                this.dragging = null;
                this.dragOverColumn = null;
            },

            dropItem(columnKey) {
                if (!this.dragging) return;

                const statusMap = {
                    applied: 'envoyee',
                    interviewing: 'entretien',
                    offer: 'acceptee',
                    rejected: 'refusee',
                };

                const newStatus = statusMap[columnKey];
                if (!newStatus || this.dragging.statut === newStatus) {
                    this.dragging = null;
                    this.dragOverColumn = null;
                    return;
                }

                const oldStatus = this.dragging.statut;
                this.dragging.statut = newStatus;

                // Persist to server — silently fail if item doesn't exist (mock data)
                fetch(`/candidatures/${this.dragging.id}/statut`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '',
                    },
                    body: JSON.stringify({ statut: newStatus }),
                }).catch(() => {
                    this.dragging.statut = oldStatus;
                });

                this.dragging = null;
                this.dragOverColumn = null;
            },
        };
    }
</script>
@endpush
