@php
    $candidature = $entretien->candidature;
@endphp

<x-app-layout>
    <div class="max-w-2xl mx-auto space-y-8 animate-in">

        {{-- HEADER --}}
        <div>
            <a href="{{ route('candidatures.show', $candidature) }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 transition-colors mb-4">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Retour à la candidature
            </a>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Modifier l'entretien</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $candidature->poste }} at {{ $candidature->entreprise }}</p>
        </div>

        {{-- FORM --}}
        <form method="POST" action="{{ route('entretiens.update', $entretien) }}" class="bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700/50 p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Type + Date --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="type" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Type *</label>
                    <select id="type" name="type" required
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all">
                        @foreach($types as $key => $label)
                            <option value="{{ $key }}" {{ old('type', $entretien->type) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-1.5" />
                </div>
                <div>
                    <label for="date_heure" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Date & heure *</label>
                    <input id="date_heure" name="date_heure" type="datetime-local"
                           value="{{ old('date_heure', $entretien->date_heure?->format('Y-m-d\TH:i')) }}"
                           required
                           class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all">
                    <x-input-error :messages="$errors->get('date_heure')" class="mt-1.5" />
                </div>
            </div>

            {{-- Result + Notes --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="resultat" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Résultat *</label>
                    <select id="resultat" name="resultat" required
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all">
                        @foreach($resultats as $key => $label)
                            <option value="{{ $key }}" {{ old('resultat', $entretien->resultat) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('resultat')" class="mt-1.5" />
                </div>
                <div>
                    <label for="notes_preparation" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Notes</label>
                    <input id="notes_preparation" name="notes_preparation" type="text"
                           value="{{ old('notes_preparation', $entretien->notes_preparation) }}"
                           placeholder="Notes de préparation…"
                           class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all">
                    <x-input-error :messages="$errors->get('notes_preparation')" class="mt-1.5" />
                </div>
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

        {{-- DELETE --}}
        <div class="bg-white dark:bg-slate-800/80 rounded-2xl border border-rose-200/50 dark:border-rose-900/20 p-6 sm:p-8">
            <h2 class="text-sm font-semibold text-rose-600 dark:text-rose-400">Zone dangereuse</h2>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Une fois supprimé, cet entretien ne peut pas être récupéré.</p>
            <form method="POST" action="{{ route('entretiens.destroy', $entretien) }}" onsubmit="return confirm('Supprimer définitivement cet entretien ?')" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-2 h-10 px-5 rounded-xl bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 text-sm font-medium hover:bg-rose-100 dark:hover:bg-rose-900/40 transition-all duration-200 active:scale-[0.97]">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                    Supprimer l'entretien
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
