@php
    $initial = strtoupper(substr($candidature->entreprise, 0, 1));
@endphp

<x-app-layout>
    <div class="max-w-2xl mx-auto space-y-8 animate-in">

        {{-- HEADER --}}
        <div>
            <a href="{{ route('candidatures.show', $candidature) }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 transition-colors mb-4">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Retour aux détails
            </a>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Modifier la candidature</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $candidature->poste }} at {{ $candidature->entreprise }}</p>
        </div>

        {{-- FORM --}}
        <form method="POST" action="{{ route('candidatures.update', $candidature) }}" class="bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700/50 p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Company + Position --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="entreprise" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Entreprise *</label>
                    <input id="entreprise" name="entreprise" type="text" value="{{ old('entreprise', $candidature->entreprise) }}" required
                           class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all">
                    <x-input-error :messages="$errors->get('entreprise')" class="mt-1.5" />
                </div>
                <div>
                    <label for="poste" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Poste *</label>
                    <input id="poste" name="poste" type="text" value="{{ old('poste', $candidature->poste) }}" required
                           class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all">
                    <x-input-error :messages="$errors->get('poste')" class="mt-1.5" />
                </div>
            </div>

            {{-- Offer URL --}}
            <div>
                <label for="url_offre" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">URL de l'offre</label>
                <input id="url_offre" name="url_offre" type="url" value="{{ old('url_offre', $candidature->url_offre) }}"
                       class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all">
                <x-input-error :messages="$errors->get('url_offre')" class="mt-1.5" />
            </div>

            {{-- Status + Priority + Date --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label for="statut" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Statut *</label>
                    <select id="statut" name="statut" required
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all">
                        @foreach($statuts as $key => $label)
                            <option value="{{ $key }}" {{ old('statut', $candidature->statut) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('statut')" class="mt-1.5" />
                </div>
                <div>
                    <label for="priorite" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Priorité *</label>
                    <select id="priorite" name="priorite" required
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all">
                        @foreach($priorites as $key => $label)
                            <option value="{{ $key }}" {{ old('priorite', $candidature->priorite) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('priorite')" class="mt-1.5" />
                </div>
                <div>
                    <label for="date_candidature" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Date de candidature *</label>
                    <input id="date_candidature" name="date_candidature" type="date" value="{{ old('date_candidature', $candidature->date_candidature?->format('Y-m-d')) }}" required
                           class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all">
                    <x-input-error :messages="$errors->get('date_candidature')" class="mt-1.5" />
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label for="notes" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Notes</label>
                <textarea id="notes" name="notes" rows="4"
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all resize-none">{{ old('notes', $candidature->notes) }}</textarea>
                <x-input-error :messages="$errors->get('notes')" class="mt-1.5" />
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('candidatures.show', $candidature) }}"
                   class="inline-flex items-center h-11 px-5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200">
                    Annuler
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 h-11 px-6 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-medium hover:from-indigo-500 hover:to-violet-500 transition-all duration-200 shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 active:scale-[0.97]">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
