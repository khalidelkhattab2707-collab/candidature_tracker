@extends('layouts.auth')

@section('content')
<div class="min-h-screen bg-[#f8f8fa] flex items-center justify-center p-6">
        <div class="w-full max-w-[420px]">
            <div class="text-center mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center mx-auto shadow-lg shadow-indigo-500/20">
                    <span class="text-white font-bold">CT</span>
                </div>
                <h1 class="mt-6 text-2xl font-bold text-gray-900">Réinitialiser votre mot de passe</h1>
                <p class="mt-2 text-sm text-gray-500">Pas de problème. Entrez votre email et nous vous enverrons un lien de réinitialisation.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Adresse email</label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           placeholder="vous@exemple.fr"
                           class="w-full h-12 px-4 border border-gray-200 rounded-xl text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all duration-200 bg-white">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <button type="submit"
                        class="w-full h-12 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-xl font-medium text-sm hover:from-indigo-500 hover:to-violet-500 transition-all duration-200 shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30">
                    Envoyer le lien de réinitialisation
                </button>

                <p class="text-center">
                    <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-500 transition-colors">&larr; Retour à la connexion</a>
                </p>
            </form>
        </div>
    </div>
@endsection
