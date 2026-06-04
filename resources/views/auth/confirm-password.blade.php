@extends('layouts.auth')

@section('content')
<div class="min-h-screen bg-[#f8f8fa] flex items-center justify-center p-6">
        <div class="w-full max-w-[420px]">
            <div class="text-center mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center mx-auto shadow-lg shadow-indigo-500/20">
                    <span class="text-white font-bold">CT</span>
                </div>
                <h1 class="mt-6 text-2xl font-bold text-gray-900">Confirmer le mot de passe</h1>
                <p class="mt-2 text-sm text-gray-500">Zone sécurisée. Veuillez confirmer votre mot de passe avant de continuer.</p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Mot de passe</label>
                    <input id="password"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           placeholder="Entrez votre mot de passe"
                           class="w-full h-12 px-4 border border-gray-200 rounded-xl text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all duration-200 bg-white">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <button type="submit"
                        class="w-full h-12 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-xl font-medium text-sm hover:from-indigo-500 hover:to-violet-500 transition-all duration-200 shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30">
Confirmer
                </button>
            </form>
        </div>
    </div>
@endsection
