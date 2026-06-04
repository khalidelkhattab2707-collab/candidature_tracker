@extends('layouts.auth')

@php
    $pattern = "data:image/svg+xml,%3Csvg width='40' height='40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.08'%3E%3Cpath d='M22 20v-2h-2v2h-2v2h2v2h2v-2h2v-2M10 30v-2H8v2H6v2h2v2h2v-2h2v-2M30 10v-2h-2v2h-2v2h2v2h2v-2h2v-2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E";
@endphp

@section('content')
<div class="flex min-h-screen">

        {{-- SECTION GAUCHE — Branding --}}
        <div class="hidden lg:flex w-1/2 relative overflow-hidden"
             style="background: linear-gradient(135deg, #0f0b3d 0%, #3128a0 45%, #7c3aed 70%, #c026d3 100%);">

            {{-- Pattern "+" overlay --}}
            <div class="absolute inset-0" style="background-image: url('{{ $pattern }}');"></div>

            {{-- Glow violet/rose --}}
            <div class="absolute -bottom-32 -right-32 w-[500px] h-[500px] rounded-full bg-purple-500/15 blur-[120px]"></div>
            <div class="absolute -top-20 -left-20 w-[400px] h-[400px] rounded-full bg-indigo-500/10 blur-[100px]"></div>

            {{-- TOP LEFT: Logo --}}
            <div class="absolute top-8 left-8 z-10 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/15 backdrop-blur-md flex items-center justify-center">
                    <span class="text-white font-bold text-sm">CT</span>
                </div>
                <span class="text-white font-semibold text-lg">CandidatureTracker</span>
            </div>

            {{-- TOP RIGHT: Floating card --}}
            <div class="absolute top-8 right-8 z-10">
                <div class="bg-white/10 backdrop-blur-xl border border-white/10 rounded-2xl px-5 py-3 shadow-lg">
                    <p class="text-white font-medium text-sm">Ingénieur Frontend</p>
                    <p class="text-white/50 text-xs mt-0.5">Stripe &middot; Entretien Ven</p>
                </div>
            </div>

            {{-- CENTER: Contenu principal --}}
            <div class="flex flex-col justify-center px-16 w-full z-10">
                <blockquote class="text-4xl lg:text-5xl font-semibold text-white leading-[1.1] max-w-lg">
                    &ldquo;Je suis passée de 0 à 3 offres en 6 semaines. Cet outil m'a apporté la clarté dont j'avais besoin.&rdquo;
                </blockquote>

                <p class="mt-5 text-white/50 text-sm">&mdash; Sarah K., reconversion professionnelle &mdash; embauchée chez Figma</p>

                {{-- Dots --}}
                <div class="flex items-center gap-2 mt-4">
                    <span class="w-8 h-2 rounded-full bg-white"></span>
                    <span class="w-2 h-2 rounded-full bg-white/30"></span>
                    <span class="w-2 h-2 rounded-full bg-white/30"></span>
                </div>

                <p class="mt-6 text-white/50 text-sm leading-relaxed max-w-sm">
                    Le compagnon de carrière qui transforme la recherche d'emploi du chaos à la clarté. Organisez, suivez et réussissez vos candidatures &mdash; tout en un seul endroit.
                </p>
            </div>

            {{-- BOTTOM RIGHT: Stats card flottante --}}
            <div class="absolute bottom-36 right-8 z-10">
                <div class="bg-white/10 backdrop-blur-xl border border-white/10 rounded-2xl px-5 py-4 shadow-lg">
                    <p class="text-white text-xl font-bold">35 candidatures</p>
                    <p class="text-white/50 text-xs mt-0.5">8 entretiens &middot; 3 offres</p>
                </div>
            </div>

            {{-- BOTTOM: Statistiques --}}
            <div class="absolute bottom-8 left-8 right-8 z-10 flex items-center gap-8 max-w-lg">
                <div>
                    <p class="text-white text-2xl font-bold">2,400+</p>
                    <p class="text-white/40 text-xs mt-0.5">Diplômés placés</p>
                </div>
                <div class="w-px h-10 bg-white/10"></div>
                <div>
                    <p class="text-white text-2xl font-bold">89%</p>
                    <p class="text-white/40 text-xs mt-0.5">Taux de réponse</p>
                </div>
                <div class="w-px h-10 bg-white/10"></div>
                <div>
                    <p class="text-white text-2xl font-bold">4.8&star;</p>
                    <p class="text-white/40 text-xs mt-0.5">Note utilisateur</p>
                </div>
            </div>
        </div>

        {{-- SECTION DROITE — Formulaire --}}
        <div class="w-full lg:w-1/2 bg-[#f8f8fa] flex items-center justify-center p-6 lg:p-8 min-h-screen">

            <div class="w-full max-w-[420px]">

                {{-- Toggle tabs --}}
                <div class="flex bg-gray-200/70 rounded-full p-1 w-fit mx-auto">
                    <a href="{{ route('login') }}"
                       class="px-6 py-2.5 rounded-full text-sm font-medium bg-white shadow-sm text-gray-900 transition-all duration-200">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-6 py-2.5 rounded-full text-sm font-medium text-gray-500 hover:text-gray-900 transition-all duration-200">
                        Créer un compte
                    </a>
                </div>

                {{-- Titre --}}
                <h1 class="mt-10 text-3xl font-bold text-gray-900 text-center">Bon retour</h1>
                <p class="mt-2 text-gray-500 text-center text-sm">Continuez votre recherche d'emploi.</p>

                {{-- Social buttons --}}
                <div class="flex gap-3 mt-8">
                    <a href="#"
                       class="flex-1 flex items-center justify-center gap-2.5 h-12 border border-gray-200 rounded-xl hover:border-gray-300 hover:bg-white transition-all duration-200 bg-white">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Google</span>
                    </a>
                    <a href="#"
                       class="flex-1 flex items-center justify-center gap-2.5 h-12 border border-gray-200 rounded-xl hover:border-gray-300 hover:bg-white transition-all duration-200 bg-white">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="#24292F">
                            <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">GitHub</span>
                    </a>
                </div>

                {{-- Divider --}}
                <div class="flex items-center gap-4 mt-8">
                    <span class="flex-1 h-px bg-gray-200"></span>
                    <span class="text-sm text-gray-400 shrink-0">ou continuez avec votre email</span>
                    <span class="flex-1 h-px bg-gray-200"></span>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                    @csrf

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Adresse email</label>
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="vous@exemple.fr"
                               class="w-full h-12 px-4 border border-gray-200 rounded-xl text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all duration-200 bg-white">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500 transition-colors">Mot de passe oublié ?</a>
                            @endif
                        </div>
                        <input id="password"
                               type="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="Entrez votre mot de passe"
                               class="w-full h-12 px-4 border border-gray-200 rounded-xl text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 transition-all duration-200 bg-white">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- Remember me --}}
                    <div class="flex items-center">
                        <input id="remember_me"
                               type="checkbox"
                               name="remember"
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-0 transition-all">
                        <label for="remember_me" class="ml-2.5 text-sm text-gray-600">Se souvenir de moi</label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full h-12 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-xl font-medium text-sm hover:from-indigo-500 hover:to-violet-500 transition-all duration-200 shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 active:shadow-indigo-500/40">
                        Se connecter &rarr;
                    </button>
                </form>

                {{-- Disclaimer --}}
                <p class="mt-8 text-xs text-gray-400 text-center leading-relaxed">
                    En continuant, vous acceptez nos
                    <a href="#" class="text-indigo-600 hover:underline">CGU</a>
                    et notre
                    <a href="#" class="text-indigo-600 hover:underline">Politique de confidentialité</a>.
                </p>
            </div>
        </div>

    </div>
@endsection
