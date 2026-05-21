{{-- resources/views/candidatures/create.blade.php --}}
<x-app-layout>
    <form method="POST" action="{{ route('candidatures.store') }}">
        @csrf {{-- OBLIGATOIRE : génère un token de sécurité anti-CSRF --}}

        <div>
            <label>Entreprise *</label>
            <input type="text" name="entreprise" value="{{ old('entreprise') }}" required>
            @error('entreprise')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Statut *</label>
            <select name="statut">
                @foreach(App\Models\Candidature::STATUTS as $valeur => $label)
                    <option value="{{ $valeur }}" {{ old('statut') === $valeur ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('statut')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        {{-- ... autres champs --}}

        <button type="submit">Enregistrer</button>
        <a href="{{ route('candidatures.index') }}">Annuler</a>
    </form>
</x-app-layout>