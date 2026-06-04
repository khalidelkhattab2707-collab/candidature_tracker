@extends('layouts.auth')

@section('content')
<div class="min-h-screen bg-[#f8f8fa] flex items-center justify-center p-6">
        <div class="w-full max-w-[420px]">
            <div class="text-center mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center mx-auto shadow-lg shadow-indigo-500/20">
                    <span class="text-white font-bold">CT</span>
                </div>
                <h1 class="mt-6 text-2xl font-bold text-gray-900">Vérifiez votre email</h1>
                <p class="mt-2 text-sm text-gray-500">Merci de vous être inscrit ! Avant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ? Si vous n'avez pas reçu l'email, nous vous en enverrons un autre.</p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-sm text-green-700">
                    Un nouveau lien de vérification a été envoyé à l'adresse email fournie lors de l'inscription.
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                        class="w-full h-12 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-xl font-medium text-sm hover:from-indigo-500 hover:to-violet-500 transition-all duration-200 shadow-lg shadow-indigo-500/20">
                    Renvoyer l'email de vérification
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit"
                        class="w-full h-12 border border-gray-200 bg-white text-gray-700 rounded-xl font-medium text-sm hover:border-gray-300 hover:bg-gray-50 transition-all duration-200">
                    Déconnexion
                </button>
            </form>
        </div>
    </div>
@endsection
