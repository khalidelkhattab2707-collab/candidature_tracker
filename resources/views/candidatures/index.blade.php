{{-- resources/views/candidatures/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">Mes Candidatures</x-slot>

    {{-- Message flash de succès --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulaire de filtres --}}
    <form method="GET" action="{{ route('candidatures.index') }}">
        <select name="statut">
            <option value="">Tous les statuts</option>
            @foreach(App\Models\Candidature::STATUTS as $valeur => $label)
                <option value="{{ $valeur }}"
                    {{ ($filtres['statut'] ?? '') === $valeur ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        <select name="priorite">
            <option value="">Toutes les priorités</option>
            @foreach(App\Models\Candidature::PRIORITES as $valeur => $label)
                <option value="{{ $valeur }}"
                    {{ ($filtres['priorite'] ?? '') === $valeur ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        <button type="submit">Filtrer</button>
        <a href="{{ route('candidatures.index') }}">Réinitialiser</a>
    </form>

    {{-- Liste des candidatures --}}
    @forelse($candidatures as $candidature)
        <div class="card">
            <h3>{{ $candidature->entreprise }} — {{ $candidature->poste }}</h3>
            <p>Statut : {{ App\Models\Candidature::STATUTS[$candidature->statut] }}</p>
            <p>Priorité : {{ App\Models\Candidature::PRIORITES[$candidature->priorite] }}</p>
            <p>Date : {{ $candidature->date_candidature->format('d/m/Y') }}</p>

            {{-- Actions --}}
            <a href="{{ route('candidatures.show', $candidature) }}">Voir</a>
            <a href="{{ route('candidatures.edit', $candidature) }}">Modifier</a>

            {{-- Archivage --}}
            <form method="POST" action="{{ route('candidatures.destroy', $candidature) }}">
                @csrf
                @method('DELETE')
                <button type="submit">Archiver</button>
            </form>
        </div>
    @empty
        {{-- Cas vide : obligatoire avec @forelse --}}
        <p>Aucune candidature enregistrée. <a href="{{ route('candidatures.create') }}">Commencer</a></p>
    @endforelse
</x-app-layout>